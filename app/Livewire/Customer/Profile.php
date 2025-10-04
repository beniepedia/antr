<?php

namespace App\Livewire\Customer;

use App\trait\WithNotyf;
use Livewire\Component;

class Profile extends Component
{
    use WithNotyf;

    public $name = '';

    public $whatsapp = '';

    public $editing = false;

    public function mount()
    {
        $user = auth('customer')->user();
        $this->name = $user->name;
        $this->whatsapp = $user->whatsapp;
    }

    public function toggleEdit()
    {
        $this->editing = ! $this->editing;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20|unique:customers,whatsapp,'.auth('customer')->id(),
        ];
    }

    public function save()
    {
        $this->validate();

        auth('customer')->user()->update([
            'name' => $this->name,
            'whatsapp' => $this->whatsapp,
        ]);

        $this->notyf('Profil berhasil diperbarui');
        $this->toggleEdit();
    }

    public function render()
    {
        return view('livewire.customer.profile')->layout('layouts.customer.main');
    }
}
