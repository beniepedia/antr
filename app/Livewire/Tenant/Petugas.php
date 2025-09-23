<?php

namespace App\Livewire\Tenant;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Petugas extends Component
{
    public $petugas = [];
    public $showModal = false;
    public $isEditing = false;
    public $petugasId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ];

    protected $messages = [
        'email.unique' => 'Email sudah digunakan.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function mount()
    {
        $this->loadPetugas();
    }

    public function loadPetugas()
    {
        $tenantId = Auth::guard('tenant')->user()->tenant_id;
        $this->petugas = User::where('tenant_id', $tenantId)
            ->where('role', '!=', 'admin')
            ->get();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $petugas = User::find($id);
        if ($petugas && $petugas->tenant_id == Auth::guard('tenant')->user()->tenant_id && $petugas->role != 'admin') {
            $this->petugasId = $petugas->id;
            $this->name = $petugas->name;
            $this->email = $petugas->email;
            $this->password = '';
            $this->password_confirmation = '';
            $this->isEditing = true;
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->petugasId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->resetValidation();
    }

    public function save()
    {
        $tenantId = Auth::guard('tenant')->user()->tenant_id;

        if ($this->isEditing) {
            $this->rules['email'] = 'required|email|unique:users,email,' . $this->petugasId;
            $this->rules['password'] = 'nullable|min:8|confirmed';
        }

        $this->validate();

        if ($this->isEditing) {
            $petugas = User::find($this->petugasId);
            $petugas->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            if ($this->password) {
                $petugas->update(['password' => Hash::make($this->password)]);
            }
            $this->js('notyf.success("Petugas berhasil diperbarui!")');
        } else {
            User::create([
                'tenant_id' => $tenantId,
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'petugas', // assuming role for petugas
            ]);
            $this->js('notyf.success("Petugas berhasil ditambahkan!")');
        }

        $this->closeModal();
        $this->loadPetugas();
    }

    public function delete($id)
    {
        $petugas = User::find($id);
        if ($petugas && $petugas->tenant_id == Auth::guard('tenant')->user()->tenant_id && $petugas->role != 'admin') {
            $petugas->delete();
            $this->js('notyf.success("Petugas berhasil dihapus!")');
            $this->loadPetugas();
        }
    }

    public function render()
    {
        return view('livewire.tenant.petugas.index')->layout('layouts.tenant');
    }
}