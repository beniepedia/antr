<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Models\Profile;
use App\Models\User;
use App\Validation\KaryawanMessages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class KaryawanCreate extends Component
{
    use WithFileUploads;

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

    protected function rules()
    {
        return KaryawanMessages::getRules();
    }

    protected function messages()
    {
        return KaryawanMessages::getMessages();
    }

    public function save()
    {
        $tenantId = Auth::guard('tenant')->user()->tenant_id;

        $this->validate();

        // Generate random password
        $password = Str::random(12);

        // Handle avatar upload
        $avatarPath = null;
        if ($this->avatar) {
            $avatarPath = $this->avatar->store('avatars', 'public');
        }

        $user = User::create([
            'tenant_id' => $tenantId,
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($password),
            'role' => 'petugas',
        ]);

        // Create profile
        Profile::create([
            'user_id' => $user->id,
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
        ]);

        $this->dispatch('notify', type: 'success', message: 'Data karyawan berhasil ditambah');

        return redirect()->route('tenant.karyawan');
    }

    public function render()
    {
        return view('livewire.tenant.karyawan.create')->layout('layouts.tenant');
    }
}
