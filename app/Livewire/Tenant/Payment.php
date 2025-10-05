<?php

namespace App\Livewire\Tenant;

use App\Models\Coupon;
use App\Models\Plan;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Payment extends Component
{
    public $plan, $planId;
    public $fullName, $email;
    public $paymentMethod = 'VC';
    public $discountCode = '', $discountAmount = 0, $coupon = null;
    public $reference;

    public function mount(Plan $plan)
    {
        $this->plan = $plan;
        $this->planId = $plan->id;
        $user = Auth::guard('tenant')->user();
        $this->fullName = $user->name;
        $this->email = $user->email;
    }

    public function applyDiscount()
    {
        $code = strtoupper(trim($this->discountCode));
        if (!$code) return $this->addError('coupon', 'Masukkan kode promo.');

        $coupon = Coupon::active()->where('code', $code)->first();
        if (!$coupon) return $this->addError('coupon', 'Kode kupon tidak valid atau sudah kedaluwarsa.');

        if (!$coupon->isValidFor($this->plan))
            return $this->addError('coupon', 'Kupon tidak berlaku untuk plan ini.');

        $this->discountAmount = $coupon->calculateDiscount($this->plan);
        $coupon->markUsed();
        $this->coupon = $coupon;

        $this->resetErrorBag('coupon');
        $this->js("notyf.success('Kupon berhasil diterapkan.')");
        
    }

    public function processPayment(PaymentService $paymentService)
    {
        $this->validate([
            'paymentMethod' => 'required',
            'fullName'      => 'required|string|max:255',
            'email'         => 'required|email',
        ]);

        $tenant = Auth::guard('tenant')->user();
        $amount = max(0, $this->plan->price - $this->discountAmount);

        if ($amount <= 0) return $this->js("notyf.error('Total pembayaran tidak valid.')");

        $trx = $paymentService->createPayment(
            $tenant,
            $this->plan,
            $amount,
            $this->fullName,
            $this->email,
            $this->paymentMethod,
            $this->coupon
        );

        if (!$trx) {
            $this->js("notyf.error('Gagal membuat transaksi.')");
            return;
        }

        $this->reference = $trx->payment_ref;
        $this->dispatch('open-payment-popup', reference: $trx->payment_ref, paymentUrl: $trx->meta['payment_url'] ?? null);
    }

    public function render()
    {
        return view('livewire.tenant.payment')->layout('layouts.tenant');
    }
}
