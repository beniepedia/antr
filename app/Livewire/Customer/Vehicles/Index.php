<?php

namespace App\Livewire\Customer\Vehicles;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $vehicles = Auth::guard('customer')->user()->vehicles()->get();

        return view('livewire.customer.vehicles.index', compact('vehicles'))->layout('layouts.customer.main');
    }
}
