<?php

namespace App\Livewire\Tenant\queue;

use App\Events\TenantQueueUpdated;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class QueueControl extends Component
{
    public $tenantId;

    public $currentQueue = null;

    public $nextQueue = null;

    public $waitingQueues = [];

    public $textEvent = 'state awal';

    public function mount()
    {
        $this->tenantId = Auth::guard('tenant')->user()->tenant_id;
        $this->loadQueues();

    }

    public function loadQueues()
    {

        // Current called queue
        $this->currentQueue = Queue::where('tenant_id', $this->tenantId)
            ->whereIn('status', ['waiting','called'])
            ->with(['customer', 'customerVehicle.vehicle'])
            ->first();

        // Next waiting queue
        $this->nextQueue = Queue::where('tenant_id', $this->tenantId)
            ->where('status', 'waiting')
            ->with(['customer', 'customerVehicle.vehicle'])
            ->orderBy('created_at', 'asc')
            ->first();

        // All waiting queues
        $this->waitingQueues = Queue::where('tenant_id', $this->tenantId)
            ->where('status', 'waiting')
            ->with(['customer', 'customerVehicle.vehicle'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function callNext()
    {
        if ($this->nextQueue) {
            $this->nextQueue->update([
                'status' => 'called',
                'checkin_time' => now(),
            ]);

            // Broadcast event
            // broadcast(new TenantQueueUpdated(
            //     $this->tenantId,
            //     'called',
            //     [
            //         'queue_number' => $this->nextQueue->queue_number,
            //         'status' => 'called',
            //     ]
            // ));
            // event(new \App\Events\TestBroadcast('Coba broadcast sukses!'));

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
                $this->tenantId,
                'skipped',
                [
                    'queue_number' => $this->currentQueue->queue_number,
                    'status' => 'waiting',
                ]
            ));

            $this->callNext();
        }
    }

    #[On('echo:tenant.{tenantId}.queue,.queue.updated')]
    public function handleEventUpdated()
    {
        $this->textEvent = 'update berhasil';
        $this->loadQueues();
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
                $this->tenantId,
                'completed',
                [
                    'queue_number' => $this->currentQueue->queue_number,
                    'status' => 'completed',
                ]
            ));

            $this->loadQueues();
            $this->js('notyf.success("Antrian diselesaikan!")');
        }
    }

    public function recallCurrent()
    {
        if ($this->currentQueue) {
            // Broadcast event to recall
            broadcast(new TenantQueueUpdated(
                $this->tenantId,
                'called',
                [
                    'queue_number' => $this->currentQueue->queue_number,
                    'status' => 'called',
                ]
            ));

            $this->js('notyf.success("Antrian dipanggil kembali!")');
        }
    }

    public function render()
    {
        return view('livewire.tenant.queue-control')->layout('layouts.tenant');
    }
}
