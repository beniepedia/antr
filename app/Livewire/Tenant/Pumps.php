<?php

namespace App\Livewire\Tenant;

use App\Models\Pump;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pumps extends Component
{
    public $pumps;

    public $showForm = false;

    public $name;

    public $tenant;

    public $editing = false;

    public $editingId;

    public function mount()
    {
        $user = Auth::guard('tenant')->user();
        $this->tenant = $user->tenant;
        $this->pumps = $this->tenant->pumps;
    }

    public function showAddForm()
    {
        $this->showForm = true;
        $this->editing = false;
        $this->name = '';
    }

    public function editPump($pumpId)
    {
        $pump = Pump::find($pumpId);
        if ($pump) {
            $this->showForm = true;
            $this->editing = true;
            $this->editingId = $pumpId;
            $this->name = $pump->name;
        }
    }

    public function hideForm()
    {
        $this->showForm = false;
        $this->editing = false;
        $this->editingId = null;
    }

    public function savePump()
    {
        $this->validate([
            'name' => 'required|string|max:255|min:3',
        ], [
            'name.required' => 'Nama pompa tidak boleh kosong',
            'name.min' => 'Nama pompa minimal :min karakter',
        ]);

        if ($this->editing) {
            $pump = Pump::find($this->editingId);
            if ($pump) {
                $pump->name = $this->name;
                $pump->save();
                $this->js('notyf.success("Pompa berhasil diupdate!")');
            }
        } else {
            Pump::create([
                'tenant_id' => $this->tenant->id,
                'name' => $this->name,
            ]);
            $this->js('notyf.success("Pompa berhasil ditambah!")');
        }

        $this->hideForm();
        $this->mount(); // Refresh data
    }

    public function toggleActive($pumpId)
    {
        $pump = Pump::find($pumpId);
        if ($pump) {
            $pump->is_active = ! $pump->is_active;
            $pump->save();
            $this->mount(); // Refresh data
        }
    }

    public function delete($pumpId)
    {
        $pump = Pump::find($pumpId);
        if ($pump) {
            $pump->delete();
            $this->mount(); // Refresh data
        }
    }

    public function render()
    {
        return view('livewire.tenant.pump')->layout('layouts.tenant');
    }
}
