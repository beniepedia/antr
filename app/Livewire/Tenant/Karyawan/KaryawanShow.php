<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KaryawanShow extends Component
{
    public $karyawan;

    public $karyawanId;

    public function mount($id)
    {
        $karyawan = User::with('profile')->find($id);

        if (! $karyawan || $karyawan->tenant_id != Auth::guard('tenant')->user()->tenant_id || $karyawan->role == 'admin') {
            abort(404);
        }

        $this->karyawan = $karyawan;
        $this->karyawanId = $karyawan->id;
    }

    public function render()
    {
        return view('livewire.tenant.karyawan.show')->layout('layouts.tenant');
    }
}
