<?php

namespace App\Livewire\Customer\Auth;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $phone = '';

    public array|string $otp = [null, null, null, null];

    public bool $otpSent = false;

    public ?int $resendExpiresAt = null; // nullable, lebih aman

    const RESEND_TIMER_DURATION = 120; // detik

    // ===========================
    // MOUNT
    // ===========================
    public function mount()
    {
        if (session()->has('otpSent') && session()->has('whatsapp')) {
            $this->phone = session('whatsapp');
            $this->otpSent = true;
            $this->resendExpiresAt = session('resendExpiresAt');
        }
    }

    // ===========================
    // TIMER ACCESSORS
    // ===========================
    public function getResendTimerProperty(): int
    {
        if (! $this->resendExpiresAt) {
            return 0;
        }

        return max(0, $this->resendExpiresAt - time());
    }

    public function getFormattedTimerProperty(): string
    {
        $seconds = $this->resendTimer;

        return sprintf('%02d:%02d', floor($seconds / 60), $seconds % 60);
    }

    // ===========================
    // KIRIM OTP
    // ===========================
    public function sendOtp(): void
    {
        $this->validate([
            'phone' => 'required|regex:/^[0-9]{10,13}$/',
        ], [
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Nomor WhatsApp tidak valid.',
        ]);

        $customer = Customer::firstOrNew([
            'tenant_id' => app('tenant')->id,
            'whatsapp' => $this->phone,
        ]);

        // Set OTP dan timestamp
        $customer->otp_code = rand(1000, 9999);
        $customer->otp_expires_at = now()->addMinutes(2);
        $customer->last_otp_sent_at = now();
        $customer->is_active = true; // default aktif
        $customer->save();

        // Set timer resend
        $this->resendExpiresAt = time() + self::RESEND_TIMER_DURATION;
        session([
            'otpSent' => true,
            'whatsapp' => $this->phone,
            'resendExpiresAt' => $this->resendExpiresAt,
        ]);

        $this->otpSent = true;

        $this->dispatch('notify', type: 'success', message: "Kode OTP dikirim (code: {$customer->otp_code})");
    }

    // ===========================
    // VERIFY OTP
    // ===========================
    public function verifyOtp(): void
    {
        $this->validate([
            'otp.*' => 'required|digits:1',
        ], [
            'otp.*.required' => 'Masukkan kode OTP',
            'otp.*.digits' => 'Kode OTP harus berupa angka',
        ]);

        $otpInput = implode('', $this->otp);

        $customer = Customer::where('tenant_id', app('tenant')->id)
            ->where('whatsapp', $this->phone)
            ->first();

        if (! $customer || $customer->otp_code !== $otpInput || Carbon::parse($customer->otp_expires_at)->isPast()) {
            $this->addError('otp', 'Kode OTP tidak valid atau sudah kadaluarsa.');

            return;
        }

        // Login menggunakan guard customer
        Auth::guard('customer')->login($customer, true);

        // Hapus session timer setelah sukses
        session()->forget(['otpSent', 'whatsapp', 'resendExpiresAt']);

        // Bisa set verified_at jika mau
        $customer->verified_at = now();
        $customer->otp_code = null; // hapus OTP sekali pakai
        $customer->save();

        $this->dispatch('notify', type: 'success', message: 'OTP berhasil diverifikasi!');

        $this->redirect(route('customer.dashboard'), navigate: true);
    }

    // ===========================
    // RESEND OTP
    // ===========================
    public function resendOtp(): void
    {
        if ($this->resendTimer === 0) {
            $this->sendOtp();
        } else {
            $this->dispatch('notify', type: 'warning', message: 'Tunggu sampai timer selesai.');
        }
    }

    // ===========================
    // CHANGE NUMBER
    // ===========================
    public function changeNumber(): void
    {
        if ($this->phone) {
            $customer = Customer::where('tenant_id', app('tenant')->id)
                ->where('whatsapp', $this->phone)
                ->first();

            if ($customer && ! $customer->verified_at) {
                $customer->delete();
            }
        }

        session()->forget(['otpSent', 'whatsapp', 'resendExpiresAt']);
        $this->phone = '';
        $this->otp = [null, null, null, null];
        $this->otpSent = false;
        $this->resendExpiresAt = null;
    }

    public function render()
    {
        return view('livewire.customer.auth.login')
            ->layout('layouts.customer.auth');
    }
}
