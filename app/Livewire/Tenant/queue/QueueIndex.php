<?php

namespace App\Livewire\Tenant\queue;

use App\Models\Queue as QueueModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class QueueIndex extends Component
{
    use WithPagination;

    public $filterStatus = '';

    public $filterDate = '';

    public function getQueuesProperty()
    {
        $query = QueueModel::where('tenant_id', Auth::guard('tenant')->user()->tenant_id)
            ->with(['customer', 'customerVehicle.vehicle', 'servedBy']);

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterDate) {
            $query->where('queue_date', $this->filterDate);
        }

        return $query->orderBy('queue_date', 'desc')
            ->orderBy('queue_number', 'asc')
            ->paginate(10);
    }

    public function callQueue($queueId)
    {
        $queue = QueueModel::find($queueId);
        if ($queue && $queue->tenant_id == Auth::guard('tenant')->user()->tenant_id) {
            $queue->update([
                'status' => 'called',
                'checkin_time' => now(),
            ]);
            $this->loadQueues();
            $this->js('notyf.success("Antrian berhasil dipanggil!")');
        }
    }

    public function completeQueue($queueId)
    {
        $queue = QueueModel::find($queueId);
        if ($queue && $queue->tenant_id == Auth::guard('tenant')->user()->tenant_id) {
            $queue->update([
                'status' => 'completed',
                'checkout_time' => now(),
            ]);
            $this->loadQueues();
            $this->js('notyf.success("Antrian berhasil diselesaikan!")');
        }
    }

    public function cancelQueue($queueId)
    {
        $queue = QueueModel::find($queueId);
        if ($queue && $queue->tenant_id == Auth::guard('tenant')->user()->tenant_id) {
            $queue->update(['status' => 'cancelled']);
            $this->loadQueues();
            $this->js('notyf.success("Antrian berhasil dibatalkan!")');
        }
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.tenant.queue.index')->layout('layouts.tenant');
    }
}
