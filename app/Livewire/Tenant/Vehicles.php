<?php

namespace App\Livewire\Tenant;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Vehicles extends Component
{
    public $vehicles;

    public $showForm = false;

    #[Validate('required|string|max:50', as: 'tipe kendaraan')]
    public $type;

    #[Validate('required|integer|min:1', as: 'maksimal liter')]
    public $max_liters;

    public $tenant;

    public $editing = false;

    public $editingId;

    public function mount()
    {
        $user = Auth::guard('tenant')->user();
        $this->tenant = $user->tenant;
        $this->vehicles = $this->tenant->vehicles;
    }

    public function showAddForm()
    {
        $this->showForm = true;
        $this->editing = false;
        $this->type = '';
        $this->max_liters = '';
    }

    public function editVehicle($vehicleId)
    {
        $vehicle = Vehicle::find($vehicleId);
        if ($vehicle) {
            $this->showForm = true;
            $this->editing = true;
            $this->editingId = $vehicleId;
            $this->type = $vehicle->type;
            $this->max_liters = $vehicle->max_liters;
        }
    }

    public function hideForm()
    {
        $this->showForm = false;
        $this->editing = false;
        $this->editingId = null;
    }

    public function saveVehicle()
    {
        $this->validate();

        if ($this->editing) {
            $vehicle = Vehicle::find($this->editingId);
            if ($vehicle) {
                $vehicle->type = $this->type;
                $vehicle->max_liters = $this->max_liters;
                $vehicle->save();
                $this->js('notyf.success("Kendaraan berhasil diupdate!")');
            }
        } else {
            Vehicle::create([
                'tenant_id' => $this->tenant->id,
                'type' => $this->type,
                'max_liters' => $this->max_liters,
            ]);
            $this->js('notyf.success("Kendaraan berhasil ditambah!")');
        }

        $this->hideForm();
        $this->mount(); // Refresh data
    }

    public function delete($vehicleId)
    {
        $vehicle = Vehicle::find($vehicleId);
        if ($vehicle) {
            $vehicle->delete();
            $this->mount(); // Refresh data
        }
    }

    public function render()
    {
        return view('livewire.tenant.vehicles');
    }
}
