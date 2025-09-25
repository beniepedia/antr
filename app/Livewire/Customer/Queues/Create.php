<?php

namespace App\Livewire\Customer\Queues;

use Livewire\Component;

class Create extends Component
{
    public function takeTicket(): void
    {
        // Placeholder for creating a new queue ticket
        $this->dispatch('notify', type: 'success', message: 'Ticket created (stub).');
        $this->redirectRoute('customer.queues');
    }

    public function render()
    {
        return view('livewire.customer.queues.create')->layout('components.layouts.customer');
    }
}
