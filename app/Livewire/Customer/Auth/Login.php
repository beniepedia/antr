<?php

namespace App\Livewire\Customer\Auth;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    // Property ini adalah penanda kapan timer resend berakhir (berisi Unix timestamp)
    public $resendExpiresAt;

    public string $phone = '';

    public array|string $otp = [null, null, null, null];

    public bool $otpSent = false;

    // Konstanta untuk durasi timer
    const RESEND_TIMER_DURATION = 60;

    public function mount()
    {
        if (session('otpSent') && session('whatsapp')) {
            $this->phone = session('whatsapp');
            $this->otpSent = true;

            // Ambil waktu kadaluarsa dari session jika ada (misal setelah page refresh)
            $this->resendExpiresAt = session('resendExpiresAt');
        }
    }

    // --- ACCESOR UNTUK TIMER (The new source of truth) ---

    // Menggantikan properti $resendTimer. Menghitung sisa detik secara real-time.
    public function getResendTimerProperty(): int
    {
        // Jika belum ada waktu kadaluarsa, kembalikan 0.
        if (! $this->resendExpiresAt) {
            return 0;
        }

        $remaining = $this->resendExpiresAt - time();

        // Pastikan sisa waktu tidak kurang dari 0
        return max(0, $remaining);
    }

    // Properti untuk memformat tampilan waktu (MM:SS)
    public function getFormattedTimerProperty(): string
    {
        $seconds = $this->resendTimer; // Menggunakan accessor yang baru
        $m = str_pad(floor($seconds / 60), 2, '0', STR_PAD_LEFT);
        $s = str_pad($seconds % 60, 2, '0', STR_PAD_LEFT);

        return "{$m}:{$s}";
    }

    // --- METODE UTAMA ---

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

            // Set waktu kadaluarsa timer resend (60 detik)
            $this->resendExpiresAt = time() + self::RESEND_TIMER_DURATION;

            // Simpan juga di session untuk mount/refresh
            session(['otpSent' => true, 'whatsapp' => $this->phone, 'resendExpiresAt' => $this->resendExpiresAt]);
            $this->otpSent = true;

            // Placeholder untuk kirim OTP ke WhatsApp
            $this->dispatch('notify', type: 'success', message: "Kode OTP telah dikirim ke WhatsApp Anda (code: $otpCode).");
        } catch (ValidationException $e) {
            $firstError = $e->validator->errors()->first();

            if ($firstError) {
                $this->dispatch('notify', type: 'error', message: $firstError);
            }

            throw $e;
        }
    }

    public function verifyOtp(): void
    {
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

            // Cek kode OTP DAN waktu kadaluarsa OTP dari DB
            if ($customer && $customer->otp_code === $this->otp && Carbon::parse($customer->otp_expires_at)->isFuture()) {
                // OTP valid
                // Hapus data timer di session setelah sukses
                session()->forget(['otpSent', 'whatsapp', 'resendExpiresAt']);

                $this->dispatch('notify', type: 'success', message: 'OTP berhasil diverifikasi!');
                $this->redirect(route('customer.dashboard'), navigate: true);
            } else {
                $this->addError('otp', 'Kode OTP tidak valid atau sudah kadaluarsa.');
            }
        } catch (ValidationException $e) {
            $firstError = $e->validator->errors()->first();

            if ($firstError) {
                $this->dispatch('notify', type: 'error', message: $firstError);
            }

            throw $e;
        }
    }

    public function resendOtp(): void
    {
        // Gunakan accessor $this->resendTimer untuk memastikan waktu sudah habis (0)
        if ($this->resendTimer === 0) {
            // Panggil sendOtp untuk menghasilkan OTP baru dan mereset $this->resendExpiresAt
            $this->sendOtp();
        } else {
            // Beri notifikasi jika masih ada waktu
            $this->dispatch('notify', type: 'warning', message: 'Mohon tunggu hingga hitungan mundur selesai.');
        }
    }

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

        // Reset session dan variabel, termasuk waktu kadaluarsa timer
        session()->forget(['otpSent', 'whatsapp', 'resendExpiresAt']);
        $this->otpSent = false;
        $this->phone = '';
        $this->otp = [null, null, null, null];
        $this->resendExpiresAt = null;
    }

    public function render()
    {
        return view('livewire.customer.auth.login')->layout('layouts.customer-auth');
    }
}
