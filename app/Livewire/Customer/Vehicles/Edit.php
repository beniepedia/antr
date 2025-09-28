<?php

namespace App\Livewire\Customer\Vehicles;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function PHPSTORM_META\type;

class Edit extends Component
{
    public $vehicleId;
    public $license_plate = '';
    public $vehicle_id = '';

    public function mount($id)
    {
        $customerVehicle = auth('customer')->user()->vehicles()->wherePivot('id', $id)->first();

        if (!$customerVehicle) {
            abort(404);
        }

        $this->vehicleId = $id;
        $this->license_plate = $customerVehicle->pivot->license_plate;
        $this->vehicle_id = $customerVehicle->id;
    }

    public function rules()
    {
        return [
            'license_plate' => 'required|string|max:20|unique:customer_vehicles,license_plate,' . $this->vehicleId . ',id',
            'vehicle_id' => 'required|exists:vehicles,id',
        ];
    }

    public function save()
    {
        $this->validate();

        DB::table('customer_vehicles')
            ->where('id',  $this->vehicleId) // id dari pivot (customer_vehicles)
            ->update([
                'vehicle_id' => $this->vehicle_id,
                'license_plate' => $this->license_plate,
            ]);

        $this->dispatch('notify', type:'success', message: 'tess');
        $this->redirect(route('customer.vehicles.index'), true);
    }

    public function render()
    {
        $vehicles = Vehicle::where('tenant_id', auth('customer')->user()->tenant_id)->get();

        return view('livewire.customer.vehicles.edit', compact('vehicles'))->layout('layouts.customer.main');
    }
}