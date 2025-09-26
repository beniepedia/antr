<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Enums\PositionEnum;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class KaryawanCreate extends Component
{
    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    // Profile fields
    public $employee_id;

    public $position = 'operator';

    public $shift;

    public $hire_date;

    public $status = 'active';

    public $station_code;

    public $license_number;

    public $experience_years;

    public $avatar;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'employee_id' => 'nullable|string|unique:profiles,employee_id',
            'position' => 'required|in:'.implode(',', array_keys(PositionEnum::options())),
            'shift' => 'nullable|in:morning,afternoon,night',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'station_code' => 'nullable|string',
            'license_number' => 'nullable|string',
            'experience_years' => 'nullable|integer|min:0',
            'avatar' => 'nullable|string',
        ];
    }

    protected $messages = [
        'email.unique' => 'Email sudah digunakan.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function save()
    {
        $tenantId = Auth::guard('tenant')->user()->tenant_id;

        $this->validate();

        $user = User::create([
            'tenant_id' => $tenantId,
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'operator',
        ]);

        // Create profile
        Profile::create([
            'user_id' => $user->id,
            'tenant_id' => $tenantId,
            'employee_id' => $this->employee_id,
            'position' => $this->position,
            'shift' => $this->shift,
            'hire_date' => $this->hire_date,
            'status' => $this->status,
            'station_code' => $this->station_code,
            'license_number' => $this->license_number,
            'experience_years' => $this->experience_years,
            'avatar' => $this->avatar,
        ]);

        $this->js('notyf.success("Karyawan berhasil ditambahkan!")');

        return redirect('/karyawan');
    }

    public function render()
    {
        return view('livewire.tenant.karyawan.create')->layout('layouts.tenant');
    }
}
