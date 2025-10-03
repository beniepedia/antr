<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Livewire\Forms\EmployeeForm;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class KaryawanEdit extends Component
{
    use WithFileUploads;

    public EmployeeForm $form;

    public $karyawanId;

    public $avatar; // Temporary file upload

    public $currentAvatar; // Current avatar path

    public function mount($id)
    {
        $karyawan = User::with('profile')->find($id);
        if (! $karyawan || $karyawan->tenant_id != Auth::guard('tenant')->user()->tenant_id || $karyawan->role == 'admin') {
            abort(404);
        }

        $this->karyawanId = $karyawan->id;
        $this->form->userId = $karyawan->id;
        $this->form->name = $karyawan->name;
        $this->form->email = $karyawan->email;
        // Load profile
        if ($karyawan->profile) {
            $this->form->profileId = $karyawan->profile->id;
            $this->form->employee_id = $karyawan->profile->employee_id;
            $this->form->position = $karyawan->profile->position;
            $this->form->hire_date = $karyawan->profile->hire_date?->format('Y-m-d');
            $this->form->status = $karyawan->profile->status;
            $this->form->license_number = $karyawan->profile->license_number;
            $this->form->whatsapp = $karyawan->profile->whatsapp;
            $this->form->address = $karyawan->profile->address;
            $this->currentAvatar = $karyawan->profile->avatar;
        }
    }

    public function save()
    {
        dd($this->form);
        $this->form->validate();

        $tenantId = Auth::guard('tenant')->user()->tenant_id;

        // Handle avatar upload
        $avatarPath = $this->currentAvatar; // Keep current if no new upload
        if ($this->avatar) {
            // Delete old avatar if exists
            if ($this->currentAvatar && Storage::disk('public')->exists($this->currentAvatar)) {
                Storage::disk('public')->delete($this->currentAvatar);
            }
            $avatarPath = $this->avatar->store('avatars', 'public');
        }

        $karyawan = User::find($this->karyawanId);
        $karyawan->update([
            'name' => $this->form->name,
            'email' => $this->form->email,
        ]);

        // Update or create profile
        Profile::updateOrCreate(
            ['user_id' => $this->karyawanId],
            [
                'tenant_id' => $tenantId,
                'employee_id' => $this->form->employee_id,
                'position' => $this->form->position,
                'hire_date' => $this->form->hire_date,
                'status' => $this->form->status,
                'license_number' => $this->form->license_number,
                'whatsapp' => $this->form->whatsapp,
                'address' => $this->form->address,
                'avatar' => $avatarPath,
            ]
        );

        $this->js('notyf.success("Karyawan berhasil diperbarui!")');

        return redirect()->route('tenant.karyawan');
    }

    public function render()
    {
        return view('livewire.tenant.karyawan.edit')->layout('layouts.tenant');
    }
}
