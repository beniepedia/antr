<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Livewire\Forms\EmployeeForm;
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
    
    public EmployeeForm $form;

    // public $name;

    // public $email;

    // // Profile fields
    // public $employee_id;

    // public $position = 'operator';

    // public $hire_date;

    // public $status = 'active';

    // public $license_number;

    // public $whatsapp;

    // public $address;

    // public $experience_years;

    // public $avatar; // Temporary file upload

    // protected function rules()
    // {
    //     return KaryawanMessages::getRules();
    // }

    // protected function messages()
    // {
    //     return KaryawanMessages::getMessages();
    // }

    public function save()
    {

        $this->validate();
        
        $tenantId = Auth::guard('tenant')->user()->tenant_id;

        $password = Str::random(6);
        $this->form->password = $password;
        $this->form->tenant_id = $tenantId;

        $user = User::create($this->form->all());
        $user->profile()->create($this->form->all());

        $this->js('notyf.success("Karyawan berhasil ditambah!")');

    }

    public function render()
    {
        return view('livewire.tenant.karyawan.create')->layout('layouts.tenant');
    }
}
