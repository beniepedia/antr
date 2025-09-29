<?php

namespace App\Livewire\Customer;

use Livewire\Component;

use function PHPSTORM_META\type;

class Profile extends Component
{
    public $name = '';
    public $whatsapp = '';

    public function mount()
    {
        $user = auth('customer')->user();
        $this->name = $user->name;
        $this->whatsapp = $user->whatsapp;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20|unique:customers,whatsapp,' . auth('customer')->id(),
        ];
    }

    public function save()
    {
        $this->validate();

        auth('customer')->user()->update([
            'name' => $this->name,
            'whatsapp' => $this->whatsapp,
        ]);
        $this->dispatch("notify", type:"success", message: "asdasd");
        // session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.customer.profile')->layout('layouts.customer.main');
    }
}