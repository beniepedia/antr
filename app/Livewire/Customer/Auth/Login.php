<?php

namespace App\Livewire\Customer\Auth;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class Login extends Component
{
    public string $phone = '';

    public array|string $otp = [null, null, null, null];

    public bool $otpSent = false;

    public int $resendTimer = 120;

    public function mount()
    {
        if (session('otpSent') && session('whatsapp')) {
            $this->phone = session('whatsapp');
            $this->otpSent = true;
        }
    }

    public function sendOtp(): void
    {
        try {
            $this->validate([
                'phone' => 'required|regex:/^[0-9]{10,13}$/',
            ], [
                'phone.required' => 'Nomor WhatsApp wajib diisi.',
                'phone.regex' => 'Nomor WhatsApp tidak valid.',
            ]);

            $customer = Customer::where('tenant_id', app('tenant')->id)
                ->where('whatsapp', $this->phone)
                ->first();

            $otpCode = rand(1000, 9999);

            if (! $customer) {
                // Buat akun baru kalau belum ada
                $customer = new Customer;
                $customer->tenant_id = app('tenant')->id;
                $customer->whatsapp = $this->phone;
                $customer->is_active = true; // default aktif
            }

            $customer->otp_code = $otpCode;
            $customer->otp_expires_at = now()->addMinutes(2);
            $customer->last_otp_sent_at = now();
            $customer->save();

            session(['otpSent' => true, 'whatsapp' => $this->phone]);

            // Placeholder untuk kirim OTP ke WhatsApp
            $this->otpSent = true;
            $this->resendTimer = 60;

            $this->dispatch('notify', type: 'success', message: "Kode OTP telah dikirim ke WhatsApp Anda (code: $otpCode).");
        } catch (ValidationException $e) {
            foreach ($e->validator->errors()->all() as $error) {
                $this->dispatch('notify', type: 'error', message: $error);
            }
            throw $e;
        }
    }

    public function verifyOtp(): void
    {

        // dd($this->otp);
        try {
            $this->validate([
                'otp.*' => 'required|digits:1',
            ], [
                'otp.*.required' => 'Masukkan kode OTP',
                'otp.*.digits' => 'Kode OTP harus berupa angka.',
            ]);

            $this->otp = implode('', $this->otp);

            $customer = Customer::where('tenant_id', app('tenant')->id)
                ->where('whatsapp', $this->phone)
                ->first();

            if ($customer && $customer->otp_code === $this->otp && Carbon::parse($customer->otp_expires_at)->isFuture()) {
                // OTP valid
                $this->dispatch('notify', type: 'success', message: 'OTP berhasil diverifikasi!');
                $this->redirect(route('customer.dashboard'), navigate: true);
            } else {
                $this->addError('otp', 'Kode OTP tidak valid atau sudah kadaluarsa.');
            }
        } catch (ValidationException $e) {
            foreach ($e->validator->errors()->all() as $error) {
                $this->dispatch('notify', type: 'error', message: $error);
            }
            throw $e;
        }
    }

    public function resendOtp(): void
    {
        if ($this->resendTimer === 0) {
            $this->sendOtp();
        }
    }

    protected $listeners = ['otpError' => 'setError'];

    public function changeNumber(): void
    {
        // Hapus nomor yang didaftarkan sebelumnya kalau belum diverifikasi/aktif
        if ($this->phone) {
            $customer = Customer::where('tenant_id', app('tenant')->id)
                ->where('whatsapp', $this->phone)
                ->first();

            if ($customer && ! $customer->verified_at) {
                $customer->delete();
            }
        }

        // Reset session dan variabel
        session()->forget(['otpSent', 'whatsapp']);
        $this->otpSent = false;
        $this->phone = '';
        $this->otp = '';
        $this->resendTimer = 0;
    }

    #[On('resetTimer')]
    public function resetTimer()
    {
        $this->resendTimer = 0;
    }

    public function render()
    {
        return view('livewire.customer.auth.login')->layout('layouts.customer-auth');
    }
}
