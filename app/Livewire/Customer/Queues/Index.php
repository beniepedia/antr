<?php

namespace App\Livewire\Customer\Queues;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.customer.queues.index')->layout('components.layouts.customer');
    }
}
