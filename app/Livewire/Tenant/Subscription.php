<?php

namespace App\Livewire\Tenant;

use App\Models\Plan;
use App\Models\TenantSubscription;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Subscription extends Component
{
    public $selectedPlan;

    public function mount()
    {
        $user = Auth::guard('tenant')->user();
        if (! $user->tenant_id) {
            return redirect()->route('tenant.onboarding');
        }

        // Check if already has active subscription
        $activeSub = $user->tenant->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->first();

        if ($activeSub) {
            return redirect()->route('tenant.dashboard');
        }
    }

    public function tryFree($planId)
    {
        $user = Auth::guard('tenant')->user();
        $plan = Plan::find($planId);

        if ($plan && $plan->price == 0) {
            // Create subscription for free plan
            TenantSubscription::create([
                'tenant_id' => $user->tenant_id,
                'plan_id' => $plan->id,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration_days),
                'status' => 'active',
            ]);

            $this->js('notyf.success("Paket Trial berhasil diaktifkan!")');

            return redirect()->route('tenant.dashboard');
        }
    }

    public function subscribe()
    {
        $this->validate([
            'selectedPlan' => 'required|exists:plans,id',
        ]);

        $user = Auth::guard('tenant')->user();
        $plan = Plan::find($this->selectedPlan);

        // Create subscription
        TenantSubscription::create([
            'tenant_id' => $user->tenant_id,
            'plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(), // Assuming monthly
            'status' => 'active',
            'price' => $plan->price,
        ]);

        $this->js('notyf.success("Berhasil berlangganan paket '.$plan->name.'!");');

        return redirect()->route('tenant.dashboard');
    }

    public function render()
    {
        $plans = Plan::all();

        return view('livewire.tenant.subscription', compact('plans'))->layout('layouts.guest');
    }
}
