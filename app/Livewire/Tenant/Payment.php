<?php

namespace App\Livewire\Tenant;

use AdityaDarma\LaravelDuitku\Facades\DuitkuPOP;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Payment extends Component
{
    public $planId;

    public $plan;

    public $paymentMethod = 'VC';

    public $paymentMethods = [];

    public $reference;

    public $fullName;

    public $email;

    public $discountCode = '';

    public $discountAmount = 0;

    public function mount($plan)
    {
        $this->planId = $plan;
        $this->plan = Plan::find($plan);
        if (! $this->plan) {
            abort(404, 'Plan not found');
        }
        $this->fullName = Auth::guard('tenant')->user()->name ?? '';
        $this->email = Auth::guard('tenant')->user()->email ?? '';

    }

    public function applyDiscount()
    {
        // Simple discount logic - in real app, check against database
        if (strtoupper($this->discountCode) === 'DISKON20') {
            $this->discountAmount = $this->plan->price * 0.2; // 20% discount
            session()->flash('success', 'Kode diskon berhasil diterapkan!');
        } elseif (strtoupper($this->discountCode) === 'WELCOME10') {
            $this->discountAmount = $this->plan->price * 0.1; // 10% discount
            session()->flash('success', 'Kode diskon berhasil diterapkan!');
        } else {
            $this->discountAmount = 0;
            session()->flash('error', 'Kode diskon tidak valid.');
        }
    }

    public function processPayment()
    {
        // Validate
        $this->validate([
            'paymentMethod' => 'required',
            'fullName' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        // Calculate final amount
        $finalAmount = $this->plan->price - $this->discountAmount;

        if ($finalAmount <= 0) {
            session()->flash('error', 'Total pembayaran tidak valid.');

            return;
        }

        try {
            $transaction = DuitkuPOP::createTransaction([
                'merchantOrderId' => 'PAY-'.$this->planId.'-'.time(),
                'customerVaName' => $this->fullName,
                'email' => $this->email,
                'paymentAmount' => $finalAmount,
                'paymentMethod' => $this->paymentMethod,
                'productDetails' => 'Upgrade Paket: '.$this->plan->name,
                'itemDetails' => [
                    [
                        'name' => $this->plan->name,
                        'price' => $finalAmount,
                        'quantity' => 1,
                    ],
                ],
                'customerDetail' => [
                    'firstName' => $this->fullName,
                    'lastName' => '',
                    'email' => $this->email,
                ],
                'returnUrl' => route('tenant.dashboard'),
                // 'callbackUrl' => route('tenant.payment.callback'), // Uncomment if route exists
            ]);

            if (isset($transaction->reference)) {
                $this->reference = $transaction->reference;
                // Emit event to trigger popup
                $this->dispatch('open-payment-popup', reference: $this->reference);
            } else {
                $this->dispatch('notify', type: 'error', message: 'Gagal membuat transaksi pembayaran.');
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Terjadi kesalahan, silahkan coba beberapa saat lagi.');
        }
    }

    public function render()
    {
        return view('livewire.tenant.payment')->layout('layouts.tenant');
    }
}
