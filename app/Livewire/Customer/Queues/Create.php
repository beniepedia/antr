<?php

namespace App\Livewire\Customer\Queues;

use App\Models\Queue;
use App\Models\Vehicle;
use App\trait\WithQueueNumber;
use Livewire\Component;

class Create extends Component
{
    use WithQueueNumber;
    
    public $selected_vehicle_id;
    public $liters_requested;

    protected $rules = [
        'selected_vehicle_id' => 'required|exists:vehicles,id',
        'liters_requested' => 'required|integer|min:1',
    ];

    public function mount()
    {
        // Set default liters if only one vehicle
        $vehicles = $this->getVehicles();
        if ($vehicles->count() === 1) {
            $this->selected_vehicle_id = $vehicles->first()->id;
            $this->liters_requested = $vehicles->first()->max_liters;
        }
    }

    public function updatedSelectedVehicleId()
    {
        $vehicle = Vehicle::find($this->selected_vehicle_id);
        if ($vehicle) {
            $this->liters_requested = $vehicle->max_liters;
        }
    }

    public function takeTicket(): void
    {
        $this->validate();

        $vehicle = Vehicle::find($this->selected_vehicle_id);
        if ($this->liters_requested > $vehicle->max_liters) {
            $this->addError('liters_requested', 'Liters requested cannot exceed vehicle max capacity.');
            return;
        }

        // Get tenant from auth or session
        $tenantId = auth('customer')->user()->tenant->id; // Assuming tenant context

        // Generate queue number
        $queueNumber = WithQueueNumber::generate();

        Queue::create([
            'queue_number' => $queueNumber,
            'tenant_id' => $tenantId,
            'customer_id' => auth('customer')->id(),
            'vehicle_id' => $this->selected_vehicle_id,
            'liters_requested' => $this->liters_requested,
            'queue_date' => today(),
            'status' => 'waiting',
            'checkin_time' => now(),
        ]);

        $this->dispatch('notify', type: 'success', message: 'Tiket antrean berhasil dibuat! Nomor antrean: ' . $queueNumber);
        $this->redirectRoute('customer.dashboard');
    }

    public function getVehicles()
    {
        return Vehicle::where('tenant_id', auth()->user()->tenant_id ?? 1)->get();
    }

    public function render()
    {
        return view('livewire.customer.queues.create', [
            'vehicles' => $this->getVehicles(),
        ])->layout('layouts.customer.main');
    }
}
