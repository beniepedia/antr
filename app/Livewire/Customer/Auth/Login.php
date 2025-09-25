<?php

namespace App\Livewire\Customer\Auth;

use App\Models\Customer;
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

            $customer = new Customer;
            $otpCode = rand(1000, 9999);
            $customer->tenant_id = app('tenant')->id;
            $customer->otp_code = $otpCode;
            $customer->whatsapp = $this->phone;
            $customer->otp_expires_at = now()->addMinutes(2); // OTP valid 5 menit
            $customer->last_otp_sent_at = now();
            $customer->save();

            // Placeholder for WhatsApp OTP send logic
            $this->otpSent = true;
            $this->resendTimer = 60;

            $this->dispatch('notify', type: 'success', message: "Kode OTP telah dikirim ke WhatsApp Anda (code: $otpCode).");
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
                $this->redirect(route('customer.dashboard'), navigate: true);
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
