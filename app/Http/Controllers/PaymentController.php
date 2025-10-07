<?php

namespace App\Http\Controllers;

use AdityaDarma\LaravelDuitku\Facades\DuitkuPOP;
use App\Models\Plan;
use App\Models\TenantSubscription;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        try {
            // 🔹 Ambil data notifikasi dari Duitku
            $notification = DuitkuPOP::getNotificationTransaction();

            // 🔹 Cari transaksi berdasarkan merchantOrderId (transaction_code)
            $trx = Transaction::with('plan')->where('transaction_code', $notification->merchantOrderId)->first();


            if (!$trx) {
                Log::warning('Callback received for unknown transaction', [
                    'merchantOrderId' => $notification->merchantOrderId,
                    'reference' => $notification->reference ?? null,
                ]);
                return response('Transaction not found', 404);
            }

            // 🔹 Update status berdasarkan resultCode
            if ($notification->resultCode == '00') {
                // Pembayaran berhasil
                $trx->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'meta' => array_merge($trx->meta ?? [], [
                        'callback_response' => $notification,
                    ]),
                ]);

                $subscription = TenantSubscription::where('tenant_id', $trx->tenant_id)
                    ->where('status', 'active')
                    ->first();

                if ($subscription) {
                    $subscription->update(['status' => 'expired']);
                    $subscription->create([
                        'tenant_id' => $trx->tenant_id,
                        'plan_id' => $trx->plan_id,
                        'start_date' => now(),
                        'end_date' => now()->addDays($trx->plan->duration_days),
                        'status' => 'active',
                        'price_subscription' => $trx->total
                    ]);
                }


                Log::info('Payment successful via callback', [
                    'transaction_id' => $trx->id,
                    'reference' => $notification->reference,
                ]);
            } else {
                // Pembayaran gagal
                $trx->update([
                    'status' => 'failed',
                    'meta' => array_merge($trx->meta ?? [], [
                        'callback_response' => $notification,
                    ]),
                ]);
                Log::warning('Payment failed via callback', [
                    'transaction_id' => $trx->id,
                    'resultCode' => $notification->resultCode,
                ]);
            }

            // 🔹 Return response ke Duitku (penting untuk callback)
            return response('OK', 200);
        } catch (\Throwable $e) {
            Log::error('Error processing payment callback', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return response('Error', 500);
        }
    }
}
