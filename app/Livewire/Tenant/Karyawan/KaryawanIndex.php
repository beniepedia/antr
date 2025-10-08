<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class KaryawanIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function getKaryawanProperty()
    {
        $tenantId = Auth::guard('tenant')->user()->tenant_id;
        $query = User::where('tenant_id', $tenantId)
            ->where('role', '!=', 'admin')
            ->with('profile');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhereHas('profile', function ($profileQuery) {
                        $profileQuery->where('employee_id', 'like', '%' . $this->search . '%');
                    });
            });
        }

        return $query->paginate(10);
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
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.tenant.karyawan.index', [
            'karyawan' => $this->karyawan,
        ]);
    }
}
