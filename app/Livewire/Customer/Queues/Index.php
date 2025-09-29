<?php

namespace App\Livewire\Customer\Queues;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $queues = Auth::guard('customer')->user()->queues()->with(['tenant', 'customerVehicle.vehicle'])->orderBy('created_at', 'desc')->get();
        return view('livewire.customer.queues.index', compact('queues'))->layout('layouts.customer.main');
    }
}
