<?php

namespace App\Livewire\Tenant;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Upgrade extends Component
{
    public $selectedPlan = null;

    public function selectPlan($planId)
    {
        $this->selectedPlan = $planId;
    }

    public function proceedToPayment()
    {
        if ($this->selectedPlan) {
            return redirect()->route('tenant.subscription.payment', ['plan' => $this->selectedPlan]);
        }
    }

    public function render()
    {
        $plans = \App\Models\Plan::all();
        return view('livewire.tenant.upgrade', compact('plans'))->layout('layouts.tenant');
    }
}