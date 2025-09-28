<?php

namespace App\Livewire\Customer\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class Create extends Component
{
    public $license_plate = '';
    public $vehicle_id = '';

    public function rules()
    {
        return [
            'license_plate' => 'required|string|max:20|unique:customer_vehicles,license_plate',
            'vehicle_id' => 'required|exists:vehicles,id',
        ];
    }

    public function save()
    {
        $this->validate();

        auth('customer')->user()->vehicles()->attach($this->vehicle_id, [
            'license_plate' => $this->license_plate,
        ]);

        session()->flash('message', 'Kendaraan berhasil ditambahkan.');

        return redirect()->route('customer.vehicles.index');
    }

    public function render()
    {
        $vehicles = Vehicle::where('tenant_id', auth('customer')->user()->tenant_id)->get();

        return view('livewire.customer.vehicles.create', compact('vehicles'))->layout('layouts.customer.main');
    }
}