<?php

namespace App\Livewire\Customer\Queues;

use App\Models\CustomerVehicle;
use App\Models\Queue;
use App\Models\Vehicle;
use App\trait\WithQueueNumber;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    use WithQueueNumber;

    public $selected_customer_vehicle_id;

    public $liters_requested;

    protected $rules = [
        'selected_customer_vehicle_id' => 'required|exists:customer_vehicles,id',
        'liters_requested' => 'required|integer|min:1',
    ];

    public function mount()
    {
        // Set default liters if only one customer vehicle
        $customerVehicles = $this->getCustomerVehicles();

        if ($customerVehicles->count() === 1) {
            $this->selected_customer_vehicle_id = $customerVehicles->first()->id;
            $this->liters_requested = $customerVehicles->first()->vehicle->max_liters;
        }
    }

    public function updatedSelectedCustomerVehicleId()
    {
        $customerVehicle = CustomerVehicle::find($this->selected_customer_vehicle_id);
        if ($customerVehicle && $customerVehicle->vehicle) {
            $this->liters_requested = $customerVehicle->vehicle->max_liters;
        }
    }

    public function takeTicket(): void
    {
        $this->validate();

        // Check if customer already has an active queue
        $existingQueue = Queue::where('customer_id', auth('customer')->id())
            ->whereIn('status', ['waiting', 'called'])
            ->exists();

        if ($existingQueue) {
            $this->dispatch('notify', type: 'error', message: 'Anda sudah memiliki antrian aktif. Tidak dapat membuat antrian baru.');

            return;
        }

        $customerVehicle = CustomerVehicle::find($this->selected_customer_vehicle_id);

        if (!$customerVehicle || !$customerVehicle->vehicle) {
            $this->addError('selected_customer_vehicle_id', 'Invalid vehicle selected.');
            return;
        }

        if ($this->liters_requested > $customerVehicle->vehicle->max_liters) {
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
            'customer_vehicle_id' => $this->selected_customer_vehicle_id,
            'liters_requested' => $this->liters_requested,
            'queue_date' => today(),
            'status' => 'waiting',
            'checkin_time' => now(),
        ]);

        $this->dispatch('notify', type: 'success', message: 'Tiket antrean berhasil dibuat! Nomor antrean: '.$queueNumber);
        $this->redirectRoute('customer.dashboard', navigate: true);
    }

    public function getCustomerVehicles()
    {
        return Auth::guard('customer')->user()->customerVehicles()->with('vehicle');
    }

    public function render()
    {
        return view('livewire.customer.queues.create', [
            'customerVehicles' => $this->getCustomerVehicles()->get(),
        ])->layout('layouts.customer.main');
    }
}
