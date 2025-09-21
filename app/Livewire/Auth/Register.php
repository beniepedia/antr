<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
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

        Auth::guard('tenant')->login($user);

        session()->regenerate();
        return redirect()->intended(route('tenant.dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}