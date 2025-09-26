<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Models\Profile;
use App\Models\User;
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

    public $password;

    public $password_confirmation;

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

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'nullable|min:8|confirmed',
        'employee_id' => 'nullable|string',
        'position' => 'required|in:operator,supervisor,manager',
        'hire_date' => 'nullable|date',
        'status' => 'required|in:active,inactive',
        'license_number' => 'nullable|string',
        'whatsapp' => 'required|string',
        'address' => 'nullable|string',
        'experience_years' => 'nullable|integer|min:0',
        'avatar' => 'nullable|image|max:2048', // Max 2MB
    ];

    protected $messages = [
        'email.unique' => 'Email sudah digunakan.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

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

        $this->rules['email'] .= '|unique:users,email,'.$this->karyawanId;
        $this->rules['employee_id'] .= '|unique:profiles,employee_id,'.$karyawan->profile?->id;
        $this->rules['whatsapp'] .= '|unique:profiles,whatsapp,'.$karyawan->profile?->id.',id';
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
        if ($this->password) {
            $karyawan->update(['password' => Hash::make($this->password)]);
        }

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

        return redirect('/karyawan');
    }

    public function render()
    {
        return view('livewire.tenant.karyawan.edit')->layout('layouts.tenant');
    }
}
