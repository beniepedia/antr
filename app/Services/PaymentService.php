<?php

namespace App\Services;

use AdityaDarma\LaravelDuitku\Facades\DuitkuPOP;
use App\Models\Transaction;
use Throwable;

class PaymentService
{
    /**
     * Buat transaksi Duitku (dan simpan ke DB)
     */
    public function createPayment($tenant, $plan, $finalAmount, $fullName, $email, $paymentMethod, $coupon = null)
    {
        // 🔹 Cek transaksi pending agar tidak dobel
        $existing = Transaction::where('tenant_id', $tenant->tenant_id)
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

        // 🔹 Buat transaksi lokal
        $trx = Transaction::create([
            'tenant_id'        => $tenant->tenant_id,
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

        try {
            $res = DuitkuPOP::createTransaction([
                'merchantOrderId' => $trx->transaction_code,
                'customerVaName'  => $fullName,
                'email'           => $email,
                'paymentAmount'   => $finalAmount,
                'paymentMethod'   => $paymentMethod,
                'productDetails'  => 'Upgrade Paket: ' . $plan->name,
                'itemDetails'     => [
                    ['name' => $plan->name, 'price' => $finalAmount, 'quantity' => 1],
                ],
                'customerDetail'  => [
                    'firstName' => $fullName,
                    'email'     => $email,
                ],
                'returnUrl'   => route('tenant.dashboard'),
                // 'callbackUrl' => route('tenant.payment.callback'),
            ]);

            if (!isset($res->reference)) {
                $trx->markAsFailed('No reference from Duitku');
                return null;
            }

            $trx->update([
                'payment_ref' => $res->reference,
                'meta'        => [
                    'response'    => $res,
                    'payment_url' => $res->paymentUrl ?? null,
                ],
            ]);

            return $trx;
        } catch (Throwable $e) {
            $trx->markAsFailed($e->getMessage());
            return null;
        }
    }
}
