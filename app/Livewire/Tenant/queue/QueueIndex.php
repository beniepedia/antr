<?php

namespace App\Livewire\Tenant\queue;

use App\Models\Queue as QueueModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QueueIndex extends Component
{
    public $queues = [];

    public $filterStatus = '';

    public $filterDate = '';

    public $staff = [];

    public function mount()
    {
        $this->loadQueues();
        $this->loadStaff();
    }

    public function loadQueues()
    {
        $query = QueueModel::where('tenant_id', Auth::guard('tenant')->user()->tenant_id)
            ->with(['customer', 'vehicle', 'servedBy']);

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterDate) {
            $query->where('queue_date', $this->filterDate);
        }

        $this->queues = $query->orderBy('queue_date', 'desc')
            ->orderBy('queue_number', 'asc')
            ->get();
    }

    public function loadStaff()
    {
        $this->staff = User::where('tenant_id', Auth::guard('tenant')->user()->tenant_id)
            ->where('role', '!=', 'admin')
            ->get();
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

    public function assignStaff($queueId, $staffId)
    {
        $queue = QueueModel::find($queueId);
        if ($queue && $queue->tenant_id == Auth::guard('tenant')->user()->tenant_id) {
            $queue->update(['served_by' => $staffId]);
            $this->loadQueues();
            $this->js('notyf.success("Staff berhasil ditugaskan!")');
        }
    }

    public function updatedFilterStatus()
    {
        $this->loadQueues();
    }

    public function updatedFilterDate()
    {
        $this->loadQueues();
    }

    public function render()
    {
        return view('livewire.tenant.queue.index')->layout('layouts.tenant');
    }
}
