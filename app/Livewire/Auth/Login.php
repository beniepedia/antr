<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{
    public $email = 'admin@jakarta.test';

    public $password = 'password';

    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ];

    public function mount()
    {
        if (Auth::guard('tenant')->check()) {
            $user = Auth::guard('tenant')->user();
            if ($user->tenant_id) {
                $this->redirect(route('tenant.dashboard'), navigate: true);
            } else {
                $this->redirect(route('tenant.onboarding'), navigate: true);
            }
        }
    }

    public function login()
    {
        $this->validate();

        $key = 'login:'.Str::lower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");

            return;
        }

        if (Auth::guard('tenant')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($key);
            session()->regenerate();

            $user = Auth::guard('tenant')->user();
            if ($user->tenant_id) {
                $this->redirect(route('tenant.dashboard'), navigate: true);
            } else {
                $this->redirect(route('tenant.onboarding'), navigate: true);
            }
        }

        RateLimiter::hit($key, 60);
        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
