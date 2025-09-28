<?php

namespace App\Livewire\Customer;

use App\Models\Queue;
use Livewire\Component;

class Dashboard extends Component
{
    public function checkIn()
    {
        $activeQueue = Queue::where('customer_id', auth()->id())
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
        $activeQueue = Queue::where('customer_id', auth()->id())
            ->whereIn('status', ['waiting', 'called'])
            ->first();

        if ($activeQueue) {
            $activeQueue->update(['status' => 'cancelled', 'checkout_time' => now()]);
            $this->dispatch('notify', type: 'info', message: 'Antrian dibatalkan.');
            // Optionally redirect or refresh
            return redirect()->route('customer.dashboard');
        } else {
            $this->dispatch('notify', type: 'error', message: 'Tidak ada antrian aktif untuk dibatalkan.');
        }
    }
    public function render()
    {
        $customerId = auth()->id();
        $tenantId = auth()->user()->tenant_id ?? 1;

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
