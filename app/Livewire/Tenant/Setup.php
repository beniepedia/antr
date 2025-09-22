<?php

namespace App\Livewire\Tenant;

use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Setup extends Component
{
    public $code;
    public $name;
    public $address;
    public $contact_person;
    public $phone;
    public $url;

    protected $rules = [
        'code' => 'required|string|max:50|unique:tenants,code',
        'name' => 'required|string|max:150',
        'address' => 'required|string',
        'contact_person' => 'required|string|max:20',
        'phone' => 'nullable|string|max:20',
        'url' => 'required|string|regex:/^[a-zA-Z0-9\-]+$/|max:50|unique:tenants,url',
    ];

    public function mount()
    {
        $user = Auth::guard('tenant')->user();

        if ($user->tenant_id) {
            return redirect()->route('tenant.dashboard');
        }
    }

    public function save()
    {
        $this->validate();

        $user = Auth::guard('tenant')->user();

        // Buat tenant baru
        $tenant = Tenant::create([
            'code' => $this->code,
            'name' => $this->name,
            'address' => $this->address,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'url' => $this->url ? $this->url . '.' . parse_url(config('app.url'), PHP_URL_HOST) : null,
            'status' => 'active',
        ]);

        // Update user dengan tenant_id
        $user->update(['tenant_id' => $tenant->id]);

        $this->js('FlyonUI.notify("Setup berhasil! Selamat datang di dashboard.", "success")');
        return redirect()->route('tenant.dashboard');
    }

    public function logout()
    {
        Auth::guard('tenant')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.tenant.setup')->layout('layouts.guest');
    }
}