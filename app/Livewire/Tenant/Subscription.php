<?php

namespace App\Livewire\Tenant;

use App\Models\Plan;
use App\Models\TenantSubscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Subscription extends Component
{
    public $plans;

    public $selectedPlan;

    public $selectedTrialPlan = null;

    public function mount()
    {
        $this->plans = Plan::all();
    }

    public function selectTrialPlan($planId)
    {
        $this->selectedTrialPlan = $planId;
        $this->dispatch('showTrialConfirmation');
    }

    public function confirmTrial($planId)
    {
        // if (! $this->selectedTrialPlan) {
        //     return;
        // }

        $tenant = Auth::guard('tenant')->user()->tenant;

        // Buat subscription untuk paket trial
        TenantSubscription::create([
            'tenant_id' => $tenant->id,
            'plan_id' => $planId,
            'start_date' => now(),
            'end_date' => now()->addDays(14), // Trial selama 14 hari
            'status' => 'active',
        ]);

        // Redirect ke dashboard
        return redirect()->route('tenant.dashboard');
    }

    public function subscribe()
    {
        // Validasi plan yang dipilih
        $this->validate([
            'selectedPlan' => 'required|exists:plans,id',
        ]);

        // Dapatkan tenant yang sedang login
        $tenant = Auth::guard('tenant')->user()->tenant;

        // Buat subscription
        TenantSubscription::create([
            'tenant_id' => $tenant->id,
            'plan_id' => $this->selectedPlan,
            'start_date' => now(),
            'end_date' => now()->addMonth(), // Default 1 bulan
            'status' => 'active',
        ]);

        // Redirect ke dashboard
        return redirect()->route('tenant.dashboard');
    }

    public function render()
    {
        return view('livewire.tenant.subscription')->layout('layouts.guest');
    }
}
