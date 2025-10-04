<?php

namespace App\Livewire\Tenant;

use App\Models\Plan;
use App\Models\Tenant;
use App\Models\TenantSubscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Setup extends Component
{
    #[Validate('required|string|max:50|unique:tenants,code', as:'kode')]
    public $code;

    #[Validate('required|string|max:150', as: 'nama')]
    public $name;

    #[Validate('required', as: 'alamat')]
    public $address;

    #[Validate('required|string|max:20')]
    public $whatsapp;

    #[Validate('required|string|max:20')]
    public $phone;

    public $url;

    public $max_queue_time;

    protected $rules = [
        'code' => 'required|string|max:50|unique:tenants,code',
        'name' => 'required|string|max:150',
        'address' => 'required|string',
        'whatsapp' => 'required|string|max:20',
        'phone' => 'nullable|string|max:20',
        'url' => 'required|string|regex:/^[a-zA-Z0-9\-]+$/|max:50|unique:tenants,url',
        'max_queue_time' => 'nullable|date_format:H:i',
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
            'whatsapp' => $this->whatsapp,
            'phone' => $this->phone,
            'url' => $this->url,
            'max_queue_time' => $this->max_queue_time,
        ]);

        // Update user dengan tenant_id
        $user->update(['tenant_id' => $tenant->id]);

        // Otomatis pilih paket trial
        $trialPlan = Plan::where('is_trial', true)->first();
        if ($trialPlan) {
            TenantSubscription::create([
                'tenant_id' => $tenant->id,
                'plan_id' => $trialPlan->id,
                'start_date' => now(),
                'end_date' => now()->addDays($trialPlan->duration_days ?? 30),
                'status' => 'active',
                'price_subscription' => $trialPlan->price,
            ]);
        }

        return redirect()->route('tenant.dashboard')->with('success', 'Setup berhasil! Paket trial telah diaktifkan. Selamat datang di dashboard');
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
