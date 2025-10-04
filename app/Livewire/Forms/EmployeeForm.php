<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EmployeeForm extends Form
{
    public ?object $model = null;


    #[Validate('required')]
    #[Validate('string')]
    #[Validate('max:255')]
    public $name;

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

    #[Validate('nullable')]
    #[Validate('string')]
    public $address;

    #[Validate('nullable')]
    #[Validate('image')]
    #[Validate('max:2048')]
    public $avatar;


    public $email;
    public $whatsapp;
    public $password;
    public $tenant_id;

    public $userId = null;
    public $profileId = null;

    public $employee_id = null;

    public $role = null;

    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->model?->id)
            ],
            'whatsapp' => [
                'required',
                'string',
                Rule::unique('profiles', 'whatsapp')->ignore($this->profileId)
            ],
            'employee_id' => [
                'nullable',
                'string',
                new \App\Rules\EmployeeIdRule($this->profileId),
            ],
        ];
    }

}
