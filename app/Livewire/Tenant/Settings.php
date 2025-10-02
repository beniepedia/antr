<?php

namespace App\Livewire\Tenant;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Settings extends Component
{
    public $name;

    public $whatsapp;

    public $phone;

    public $address;

    public $code;

    public $opening_time;

    public $closing_time;

    public $editing = false;

    protected $rules = [
        'name' => 'required|string|max:150',
        'whatsapp' => 'nullable|string|max:20',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'opening_time' => 'nullable|date_format:H:i',
        'closing_time' => 'nullable|date_format:H:i|after:opening_time',
    ];

    public function mount()
    {
        $tenant = Auth::guard('tenant')->user()->tenant;
        $this->name = $tenant->name;
        $this->whatsapp = $tenant->whatsapp;
        $this->phone = $tenant->phone;
        $this->address = $tenant->address;
        $this->code = $tenant->code;
        $this->opening_time = $tenant->opening_time ? $tenant->opening_time->format('H:i') : null;
        $this->closing_time = $tenant->closing_time ? $tenant->closing_time->format('H:i') : null;
    }

    public function toggleEdit()
    {
        $this->editing = !$this->editing;
    }

    public function updateSettings()
    {
        $this->validate();

        $tenant = Auth::guard('tenant')->user()->tenant;
        $tenant->update([
            'name' => $this->name,
            'whatsapp' => $this->whatsapp,
            'phone' => $this->phone,
            'address' => $this->address,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
        ]);
        $this->editing = false;
        $this->dispatch('notify', type: 'success', message: 'Pengaturan berhasil disimpan');
    }

    public function render()
    {
        return view('livewire.tenant.settings')->layout('layouts.tenant');
    }
}
