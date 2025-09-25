<?php

namespace App\Livewire\Customer\Auth;

use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public string $phone = '';

    public string $otp = '';

    public bool $otpSent = false;

    public int $resendTimer = 0;

    public function sendOtp(): void
    {
        try {
            $this->validate([
                'phone' => 'required|regex:/^[0-9]{10,13}$/',
            ], [
                'phone.required' => 'Nomor WhatsApp wajib diisi.',
                'phone.regex' => 'Nomor WhatsApp tidak valid.',
            ]);

            // Placeholder for WhatsApp OTP send logic
            $this->otpSent = true;
            $this->resendTimer = 60;
            session(['otp' => '1234']);
            $this->dispatch('notify', type: 'success', message: 'Kode OTP telah dikirim ke WhatsApp Anda (demo: 1234).');
        } catch (ValidationException $e) {
            foreach ($e->validator->errors()->all() as $error) {
                $this->dispatch('notify', type: 'error', message: $error);
            }
            throw $e; // biar error tetap bisa dipakai untuk highlight field
        }

    }

    public function verifyOtp(): void
    {
        try {
            $this->validate([
                'otp' => 'required|digits:4',
            ], [
                'otp.required' => 'Kode OTP wajib diisi.',
                'otp.digits' => 'Kode OTP harus 4 digit.',
            ]);

            // Placeholder for OTP verification & tenant guard login
            // Simulate verification
            if ($this->otp === '1234') { // Demo code
                $this->dispatch('notify', type: 'success', message: 'OTP berhasil diverifikasi!');
                $this->redirectRoute('customer.dashboard');
            } else {
                $this->addError('otp', 'Kode OTP tidak valid.');
            }
        } catch (ValidationException $e) {
            foreach ($e->validator->errors()->all() as $error) {
                $this->dispatch('notify', type: 'error', message: $error);
            }
            throw $e; // biar error tetap bisa dipakai untuk highlight field
        }
    }

    public function resendOtp(): void
    {
        if ($this->resendTimer === 0) {
            $this->sendOtp();
        }
    }

    protected $listeners = ['otpError' => 'setError'];

    public function changeNumber()
    {
        $this->otpSent = false;
        session()->forget('otp');
    }

    public function render()
    {
        if (session('otp')) {
            $this->otpSent = true;
        }

        return view('livewire.customer.auth.login')->layout('layouts.customer-auth');
    }

    public function decrementTimer()
    {
        if ($this->resendTimer > 0) {
            $this->resendTimer--;
        }
    }
}
