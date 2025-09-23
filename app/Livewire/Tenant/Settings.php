<?php

namespace App\Livewire\Tenant;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Settings extends Component
{
    public $name;

    public $contact_person;

    public $phone;

    public $address;

    public $code;

    protected $rules = [
        'name' => 'required|string|max:150',
        'contact_person' => 'nullable|string|max:100',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
    ];

    public function mount()
    {
        $tenant = Auth::guard('tenant')->user()->tenant;
        $this->name = $tenant->name;
        $this->contact_person = $tenant->contact_person;
        $this->phone = $tenant->phone;
        $this->address = $tenant->address;
        $this->code = $tenant->code;
    }

    public function updateSettings()
    {
        $this->validate();

        $tenant = Auth::guard('tenant')->user()->tenant;
        $tenant->update([
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);
        $this->dispatch('notify', type: 'success', message: 'Pengaturan berhasil disimpan');
    }

    public function render()
    {
        return view('livewire.tenant.settings')->layout('layouts.tenant');
    }
}
