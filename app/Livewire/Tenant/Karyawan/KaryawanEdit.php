<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Enums\PositionEnum;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class KaryawanEdit extends Component
{
    public $karyawanId;

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
            'email' => 'required|email',
            'password' => 'nullable|min:8|confirmed',
            'employee_id' => 'nullable|string',
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
            $this->shift = $karyawan->profile->shift;
            $this->hire_date = $karyawan->profile->hire_date?->format('Y-m-d');
            $this->status = $karyawan->profile->status;
            $this->station_code = $karyawan->profile->station_code;
            $this->license_number = $karyawan->profile->license_number;
            $this->experience_years = $karyawan->profile->experience_years;
            $this->avatar = $karyawan->profile->avatar;
        }

        $this->rules['email'] .= ',email,'.$this->karyawanId;
        $this->rules['employee_id'] .= ',employee_id,'.$karyawan->profile?->id;
    }

    public function save()
    {
        $tenantId = Auth::guard('tenant')->user()->tenant_id;

        $this->validate();

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
                'shift' => $this->shift,
                'hire_date' => $this->hire_date,
                'status' => $this->status,
                'station_code' => $this->station_code,
                'license_number' => $this->license_number,
                'experience_years' => $this->experience_years,
                'avatar' => $this->avatar,
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
