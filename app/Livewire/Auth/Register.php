<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Register extends Component
{
    #[Validate('required|min:5', as: 'Nama')]
    public $name;

    #[Validate('required|string|email|max:255|unique:users')]
    public $email;

    public $password;

    public $password_confirmation;

    #[Validate('accepted')]
    public $terms = false;

    protected function rules()
    {
        return [
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ];
    }
    

    public function mount()
    {
        if (Auth::guard('tenant')->check()) {
            redirect()->route('tenant.dashboard');
        }
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->sendEmailVerificationNotification();

        Auth::guard('tenant')->login($user);

        session()->regenerate();

        // Jika email belum diverifikasi, redirect ke halaman verifikasi
        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(route('tenant.dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}
