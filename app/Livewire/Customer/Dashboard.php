<?php

namespace App\Livewire\Customer;

use App\Models\Queue;
use Livewire\Component;

class Dashboard extends Component
{
    public function mount()
    {
        $this->dispatch('notify', type: 'success', message: 'Antrian dibatalkan.');
    }
    public function checkIn()
    {
        $this->dispatch('notify', type: 'success', message: 'Antrian dibatalkan.');
        return;
        $activeQueue = Queue::where('customer_id', auth('customer')->id())
            ->whereIn('status', ['waiting', 'called'])
            ->first();

        if ($activeQueue && !$activeQueue->checkin_time) {
            $activeQueue->update(['checkin_time' => now()]);
            $this->dispatch('notify', type: 'success', message: 'Check-in berhasil!');
        } else {
            $this->dispatch('notify', type: 'error', message: 'Tidak dapat check-in.');
        }
    }

    public function cancelQueue()
    {
        $activeQueue = Queue::where('customer_id', auth('customer')->id())
            ->whereIn('status', ['waiting', 'called'])
            ->first();

        if ($activeQueue) {
            $activeQueue->update(['status' => 'cancelled', 'checkout_time' => now()]);
            $this->dispatch('notify', type: 'success', message: 'Antrian dibatalkan.');
            // Optionally redirect or refresh
            // return redirect()->route('customer.dashboard');
        } else {
            $this->dispatch('notify', type: 'error', message: 'Tidak ada antrian aktif untuk dibatalkan.');
        }
    }
    public function render()
    {
       
        $customer = auth('customer')->user();
        $customerId = $customer->id;
        $tenantId = $customer->tenant_id;

        $activeQueue = Queue::where('customer_id', $customerId)
            ->whereIn('status', ['waiting', 'called'])
            ->first();

        $hasActiveQueue = $activeQueue !== null;

        $currentQueueNumber = Queue::where('tenant_id', $tenantId)
            ->where('status', 'called')
            ->orderBy('queue_number')
            ->value('queue_number') ?? 0;

        return view('livewire.customer.dashboard', [
            'hasActiveQueue' => $hasActiveQueue,
            'activeQueue' => $activeQueue,
            'currentQueueNumber' => $currentQueueNumber,
        ])->layout('layouts.customer.main');
    }
}
