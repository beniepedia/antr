<?php

namespace App\Livewire\Customer\Auth;

use Livewire\Component;

class Login extends Component
{
    public string $phone = '';

    public string $otp = '';

    public bool $otpSent = false;

    public int $resendTimer = 0;

    public ?string $errorMessage = null;

    public function sendOtp(): void
    {
        $this->validate([
            'phone' => 'required|regex:/^[0-9]{10,13}$/',
        ], [
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Nomor WhatsApp tidak valid.',
        ]);

        // Placeholder for WhatsApp OTP send logic
        $this->otpSent = true;
        $this->resendTimer = 30;
        $this->errorMessage = null;
    }

    public function verifyOtp(): void
    {
        $this->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
        ]);

        // Placeholder for OTP verification & tenant guard login
        // Simulate verification
        if ($this->otp === '123456') { // Stub check
            $this->dispatch('notify', type: 'success', message: 'OTP berhasil diverifikasi!');
            $this->redirectRoute('customer.dashboard');
        } else {
            $this->addError('otp', 'Kode OTP tidak valid.');
        }
    }

    public function resendOtp(): void
    {
        if ($this->resendTimer === 0) {
            $this->sendOtp();
        }
    }

    protected $listeners = ['otpError' => 'setError'];

    public function setError($message)
    {
        $this->errorMessage = $message;
    }

    public function render()
    {
        return view('livewire.customer.auth.login')->layout('layouts.customer-auth');
    }

    public function decrementTimer()
    {
        if ($this->resendTimer > 0) {
            $this->resendTimer--;
        }
    }
}
