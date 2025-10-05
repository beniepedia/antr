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

    #[Validate('required|string|regex:/^[a-zA-Z0-9\-]+$/|max:50|unique:tenants,url')]
    public $url;

    #[Validate('required')]
    public $opening_time;

    #[Validate('required')]
    public $closing_time;

    public function mount()
    {
        $user = Auth::guard('tenant')->user();

        if ($user->tenant_id) {
            return redirect()->route('tenant.dashboard');
        }
    }

    public function save()
    {
        $validated =$this->validate();

        $user = Auth::guard('tenant')->user();

        // Buat tenant baru
        $tenant = Tenant::create($validated);

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

        return $this->redirectIntended(route('tenant.dashboard'), navigate:true);
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
