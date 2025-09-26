<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class KaryawanIndex extends Component
{
    public $karyawan = [];

    public function mount()
    {
        $this->loadKaryawan();
    }

    public function loadKaryawan()
    {
        $tenantId = Auth::guard('tenant')->user()->tenant_id;
        $this->karyawan = User::where('tenant_id', $tenantId)
            ->where('role', '!=', 'admin')
            ->with('profile')
            ->get();
    }

    public function delete($id)
    {
        $karyawan = User::find($id);
        if ($karyawan && $karyawan->tenant_id == Auth::guard('tenant')->user()->tenant_id && $karyawan->role != 'admin') {
            // Delete avatar file if exists
            if ($karyawan->profile?->avatar && Storage::disk('public')->exists($karyawan->profile->avatar)) {
                Storage::disk('public')->delete($karyawan->profile->avatar);
            }
            $karyawan->profile?->delete(); // Delete profile first
            $karyawan->delete();
            $this->js('notyf.success("Karyawan berhasil dihapus!")');
            $this->loadKaryawan();
        }
    }

    public function render()
    {
        return view('livewire.tenant.karyawan.index')->layout('layouts.tenant');
    }
}
