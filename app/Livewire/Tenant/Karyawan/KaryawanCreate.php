<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Livewire\Forms\EmployeeForm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class KaryawanCreate extends Component
{
    use WithFileUploads;

    public EmployeeForm $form;

    public function save()
    {

        $this->validate();

        $tenantId = Auth::guard('tenant')->user()->tenant_id;

        $password = Str::random(6);
        $this->form->password = $password;
        $this->form->tenant_id = $tenantId;
        $this->form->role = 'petugas';

        $user = User::create($this->form->all());
        $user->profile()->create($this->form->all());

        $this->js('notyf.success("Karyawan berhasil ditambah!")');
    }

    public function render()
    {
        return view('livewire.tenant.karyawan.create');
    }
}
