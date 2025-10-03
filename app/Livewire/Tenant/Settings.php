<?php

namespace App\Livewire\Tenant;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Settings extends Component
{
    public $name;

    public $whatsapp;

    public $phone;

    public $address;

    public $code;

    public $url;

    public $opening_time;

    public $closing_time;

    public $editing = false;

    public $tenant;

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
        $this->tenant = Auth::guard('tenant')->user()->tenant;
        $this->name = $this->tenant->name;
        $this->whatsapp = $this->tenant->whatsapp;
        $this->phone = $this->tenant->phone;
        $this->address = $this->tenant->address;
        $this->code = $this->tenant->code;
        $this->url = make_url($this->tenant->url);
        $this->opening_time = $this->tenant->opening_time ? $this->tenant->opening_time->format('H:i') : null;
        $this->closing_time = $this->tenant->closing_time ? $this->tenant->closing_time->format('H:i') : null;
    }

    public function toggleEdit()
    {
        $this->editing = ! $this->editing;
    }

    public function downloadQR()
    {
        $qr = base64_encode(
            QrCode::format('png')
                ->size(300)
                ->margin(2)
                ->generate($this->url)
        );

        $this->dispatch('download-qr', [
            'qr' => $qr,
            'name' => "{$this->tenant->name}.png",
        ]);
    }

    public function updateSettings()
    {
        $this->validate();

        $this->tenant->update([
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
