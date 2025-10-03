<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Models\Profile;
use App\Models\User;
use App\Validation\KaryawanMessages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class KaryawanEdit extends Component
{
    use WithFileUploads;

    public $karyawanId;

    public $name;

    public $email;

    // Profile fields
    public $employee_id;

    public $position = 'operator';

    public $hire_date;

    public $status = 'active';

    public $license_number;

    public $whatsapp;

    public $address;

    public $experience_years;

    public $avatar; // Temporary file upload

    public $currentAvatar; // Current avatar path

    protected $customRules = [];

    protected function rules()
    {
        return array_merge(KaryawanMessages::getRules(), $this->customRules);
    }

    protected function messages()
    {
        return KaryawanMessages::getMessages();
    }

    public function mount($id)
    {
        $karyawan = User::with('profile')->find($id);
        if (! $karyawan || $karyawan->tenant_id != Auth::guard('tenant')->user()->tenant_id || $karyawan->role == 'admin') {
            abort(404);
        }

        $this->karyawanId = $karyawan->id;
        $this->name = $karyawan->name;
        $this->email = $karyawan->email;
        // Load profile
        if ($karyawan->profile) {
            $this->employee_id = $karyawan->profile->employee_id;
            $this->position = $karyawan->profile->position;
            $this->hire_date = $karyawan->profile->hire_date?->format('Y-m-d');
            $this->status = $karyawan->profile->status;
            $this->license_number = $karyawan->profile->license_number;
            $this->whatsapp = $karyawan->profile->whatsapp;
            $this->address = $karyawan->profile->address;
            $this->experience_years = $karyawan->profile->experience_years;
            $this->currentAvatar = $karyawan->profile->avatar;
        }

        $this->customRules = [
            'email' => 'required|email|unique:users,email,'.$this->karyawanId.',id',
            'employee_id' => 'nullable|string|unique:profiles,employee_id,'.$karyawan->profile?->id.',id',
            'whatsapp' => 'required|string|unique:profiles,whatsapp,'.$karyawan->profile?->id.',id',
        ];
    }

    public function save()
    {
        $tenantId = Auth::guard('tenant')->user()->tenant_id;

        $this->validate();

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
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Update or create profile
        Profile::updateOrCreate(
            ['user_id' => $this->karyawanId],
            [
                'tenant_id' => $tenantId,
                'employee_id' => $this->employee_id,
                'position' => $this->position,
                'hire_date' => $this->hire_date,
                'status' => $this->status,
                'license_number' => $this->license_number,
                'experience_years' => $this->experience_years,
                'whatsapp' => $this->whatsapp,
                'address' => $this->address,
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
