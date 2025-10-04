<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{
    public $email;

    public $password;

    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ];

    public function mount()
    {
        if (Auth::guard('admin')->check()) {
            redirect()->route('admin.dashboard');
        }
    }

    public function login()
    {
        $this->validate();

        $key = 'admin-login:'.Str::lower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('email', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");

            return;
        }

        if (Auth::guard('admin')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($key);
            session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($key, 60);
        $this->addError('email', 'Email atau password admin salah.');
    }

    public function render()
    {
        return view('livewire.admin.login')->layout('layouts.guest');
    }
}
