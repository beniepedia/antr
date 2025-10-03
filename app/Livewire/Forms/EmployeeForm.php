<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;

class EmployeeForm extends Form
{
    #[Validate('required')]
    #[Validate('string')]
    #[Validate('max:255')]
    public $name;

    #[Validate('required')]
    #[Validate('email')]
    #[Validate('unique:users,email')]
    public $email;

    #[Validate('required')]
    #[Validate('in:operator,supervisor,manager')]
    public $position = 'operator';

    #[Validate('nullable')]
    #[Validate('date')]
    public $hire_date;

    #[Validate('required')]
    #[Validate('in:active,inactive')]
    public $status = 'active';

    #[Validate('nullable')]
    #[Validate('string')]
    public $license_number;

    #[Validate('required')]
    #[Validate('string')]
    #[Validate('unique:profiles,whatsapp')]
    public $whatsapp;

    #[Validate('nullable')]
    #[Validate('string')]
    public $address;

    #[Validate('nullable')]
    #[Validate('image')]
    #[Validate('max:2048')]
    public $avatar;

    public $password;
    public $tenant_id;

    public $userId = null;
    public $profileId = null;

    public $employee_id = null;

    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email,' . ($this->userId ?? ''),
            'whatsapp' => 'required|string|unique:profiles,whatsapp,' . ($this->profileId ?? ''),
            'employee_id' => [
                'nullable',
                'string',
                new \App\Rules\EmployeeIdRule($this->profileId),
            ],
        ];
    }

}
