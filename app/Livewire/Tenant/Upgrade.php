<?php

namespace App\Livewire\Tenant;

use Livewire\Component;

class Upgrade extends Component
{
    public $selectedPlan = null;

    public function selectPlan($planId)
    {
        return redirect()->route('tenant.subscription.payment', ['slug' => $planId]);
    }

    public function render()
    {
        $plans = \App\Models\Plan::all();

        return view('livewire.tenant.upgrade', compact('plans'))->layout('layouts.tenant');
    }
}
