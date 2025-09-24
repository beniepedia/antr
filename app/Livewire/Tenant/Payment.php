<?php

namespace App\Livewire\Tenant;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Payment extends Component
{
    public $planId;
    public $plan;
    public $paymentMethod = 'credit_card';
    public $fullName;
    public $email;
    public $discountCode = '';
    public $discountAmount = 0;

    public function mount($plan)
    {
        $this->planId = $plan;
        $this->plan = \App\Models\Plan::find($plan);
        if (!$this->plan) {
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

        // Implement payment processing logic here
        // For example, integrate with Midtrans, Stripe, etc.

        // For demo, simulate success
        session()->flash('success', 'Pembayaran berhasil! Paket Anda akan diaktifkan dalam 24 jam.');

        return redirect()->route('tenant.dashboard');
    }

    public function render()
    {
        return view('livewire.tenant.payment')->layout('layouts.tenant');
    }
}