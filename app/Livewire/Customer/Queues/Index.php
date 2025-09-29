<?php

namespace App\Livewire\Customer\Queues;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $queues = Auth::guard('customer')->user()->with(['tenant', 'queues', 'vehicle'])->orderBy('created_at', 'desc')->get();

        dd($queues);
        return view('livewire.customer.queues.index', compact('queues'))->layout('layouts.customer.main');
    }
}
