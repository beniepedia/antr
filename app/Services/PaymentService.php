<?php

namespace App\Services;

use AdityaDarma\LaravelDuitku\Facades\DuitkuPOP;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaymentService
{
    /**
     * Buat transaksi Duitku (dan simpan ke DB)
     */
    public function createPayment(
        $tenant,
        $plan,
        $finalAmount,
        $fullName,
        $email,
        $phone,
        $paymentMethod,
        $coupon = null
    ) {
        // 🔹 Cek transaksi pending agar tidak dobel
        $existing = Transaction::where('tenant_id', $tenant->id)
            ->where('plan_id', $plan->id)
            ->where('status', 'pending')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->first();

        if ($existing) {
            // 💡 Bandingkan nominal lama dengan nominal baru
            if ((int) $existing->total === (int) $finalAmount) {
                // ✅ Nominal sama → pakai transaksi lama
                return $existing;
            }

            // ❌ Nominal berubah → batalkan transaksi lama
            $existing->update([
                'status' => 'cancelled',
            ]);
        }


        try {
            DB::beginTransaction();
            // ✅ 1. Buat transaksi lokal
            $trx = Transaction::create([
                'tenant_id'        => $tenant->id,
                'plan_id'          => $plan->id,
                'coupon_id'        => $coupon->id ?? null,
                'transaction_code' => Transaction::generateCode(),
                'subtotal'         => $plan->price,
                'discount'         => $coupon ? $coupon->calculateDiscount($plan) : 0,
                'total'            => $finalAmount,
                'status'           => 'pending',
                'payment_method'   => 'duitku',
                'expires_at'       => now()->addHours(24),
            ]);

            // ✅ 2. Buat transaksi Duitku
            $res = DuitkuPOP::createTransaction([
                'merchantOrderId' => $trx->transaction_code,
                'customerVaName'  => $fullName,
                'email'           => $email,
                'paymentAmount'   => $finalAmount,
                'paymentMethod'   => $paymentMethod,
                'productDetails'  => 'Pembelian Paket: ' . $plan->name,
                'itemDetails'     => [
                    ['name' => $plan->name, 'price' => $finalAmount, 'quantity' => 1],
                ],
                'customerDetail'  => [
                    'firstName' => $fullName,
                    'email'     => $email,
                    'phoneNumber' => $phone,
                ],
                'returnUrl'   => route('tenant.dashboard'),
                // 'callbackUrl' => route('tenant.payment.callback'),
            ]);

            if (empty($res->reference)) {
                throw new \Exception(sprintf(
                    'Gagal mendapatkan kode reference dari Duitku (file: %s line: %d)',
                    __FILE__,
                    __LINE__
                ));
            }

            // ✅ 3. Update transaksi lokal
            $trx->update([
                'payment_ref' => $res->reference,
                'payment_url' => $res->paymentUrl ?? null,
                'meta'        => [
                    'response'    => $res,
                ],
            ]);
            DB::commit();
            return $trx;
        } catch (\Throwable $e) {

            DB::rollBack();
            if (isset($trx)) {
                $trx->markAsFailed($e->getMessage());
            }

            Log::error('Gagal membuat transaksi Duitku', [
                'error' => $e->getMessage(),
                'tenant_id' => $tenant->id ?? null,
                'email' => $email,
            ]);

            $trx = null;
        }
    }
}
