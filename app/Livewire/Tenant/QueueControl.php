<?php

namespace App\Livewire\Tenant;

use App\Events\TenantQueueUpdated;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QueueControl extends Component
{
    public $currentQueue = null;
    public $nextQueue = null;

    public function mount()
    {
        $this->loadQueues();
    }

    public function loadQueues()
    {
        $tenantId = Auth::guard('tenant')->user()->tenant_id;

        // Current called queue
        $this->currentQueue = Queue::where('tenant_id', $tenantId)
            ->where('status', 'called')
            ->with(['customer', 'customerVehicle.vehicle'])
            ->first();

        // Next waiting queue
        $this->nextQueue = Queue::where('tenant_id', $tenantId)
            ->where('status', 'waiting')
            ->with(['customer', 'customerVehicle.vehicle'])
            ->orderBy('created_at', 'asc')
            ->first();
    }

    public function callNext()
    {
        if ($this->nextQueue) {
            // $this->nextQueue->update([
            //     'status' => 'called',
            //     'checkin_time' => now(),
            // ]);

            // Broadcast event
            // broadcast(new TenantQueueUpdated(
            //     Auth::guard('tenant')->user()->tenant_id,
            //     'called',
            //     [
            //         'queue_number' => $this->nextQueue->queue_number,
            //         'status' => 'called'
            //     ]
            // ));
            event(new \App\Events\TestBroadcast("Coba broadcast sukses!"));

            $this->loadQueues();
            $this->js('notyf.success("Antrian berikutnya dipanggil!")');
        }
    }

    public function skipCurrent()
    {
        if ($this->currentQueue) {
            $this->currentQueue->update(['status' => 'waiting']);

            // Broadcast event
            broadcast(new TenantQueueUpdated(
                Auth::guard('tenant')->user()->tenant_id,
                'skipped',
                [
                    'queue_number' => $this->currentQueue->queue_number,
                    'status' => 'waiting'
                ]
            ));

            $this->callNext();
        }
    }

    public function completeCurrent()
    {
        if ($this->currentQueue) {
            $this->currentQueue->update([
                'status' => 'completed',
                'checkout_time' => now(),
            ]);

            // Broadcast event
            broadcast(new TenantQueueUpdated(
                Auth::guard('tenant')->user()->tenant_id,
                'completed',
                [
                    'queue_number' => $this->currentQueue->queue_number,
                    'status' => 'completed'
                ]
            ));

            $this->loadQueues();
            $this->js('notyf.success("Antrian diselesaikan!")');
        }
    }

    public function render()
    {
        return view('livewire.tenant.queue-control')->layout('layouts.tenant');
    }
}