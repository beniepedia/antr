<?php

namespace App\Livewire\Tenant\Karyawan;

use App\Livewire\Forms\EmployeeForm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class KaryawanEdit extends Component
{
    use WithFileUploads;

    public EmployeeForm $form;

    public int $karyawanId;

    public $tenant;

    public ?TemporaryUploadedFile $avatar = null;

    public ?string $currentAvatar = null;

    public $karyawan;

    public function mount($id): void
    {
        $this->tenant = Auth::guard('tenant')->user();

        abort_unless($this->tenant, 403);

        $this->karyawan = User::with('profile')
            ->where('tenant_id', $this->tenant->tenant_id)
            ->where('role', '!=', 'admin')
            ->findOrFail($id);

        $this->karyawanId = $this->karyawan->id;
        $this->form->userId = $this->karyawan->id;
        $this->form->name = $this->karyawan->name;
        $this->form->email = $this->karyawan->email;
        $this->form->role = $this->karyawan->role;

        $profile = $this->karyawan->profile;

        $this->form->model = $this->karyawan;

        if ($profile) {
            $this->form->profileId = $profile->id;
            $this->form->employee_id = $profile->employee_id;
            $this->form->position = $profile->position ?? $this->form->position;
            $this->form->hire_date = $profile->hire_date?->format('Y-m-d');
            $this->form->status = $profile->status ?? $this->form->status;
            $this->form->license_number = $profile->license_number;
            $this->form->whatsapp = $profile->whatsapp;
            $this->form->address = $profile->address;
            $this->currentAvatar = $profile->avatar;
        }
    }

    public function save()
    {
        $this->validate();

        $this->form->avatar = $this->avatar;
        $avatarPath = $this->currentAvatar;
        if ($this->form->avatar) {
            $this->deleteCurrentAvatar();
            $avatarPath = $this->form->avatar->store('avatars', 'public');
        }

        $this->form->tenant_id = $this->tenant->id;

        if ($this->form->password) {
            $this->form->password = bcrypt($this->form->password);
        } else {
            $this->form->password = $this->karyawan->password;
        }

        $this->karyawan->update($this->form->all());

        $this->karyawan->profile()->updateOrCreate(
            ['user_id' => $this->karyawanId],
            $this->form->all(),
        );

        $this->currentAvatar = $avatarPath;
        $this->reset('avatar');
        $this->form->avatar = null;

        $this->js('notyf.success("Karyawan berhasil diperbarui!")');

        return redirect()->route('tenant.karyawan');
    }

    private function deleteCurrentAvatar(): void
    {
        if (! $this->currentAvatar) {
            return;
        }

        $storage = Storage::disk('public');
        if ($storage->exists($this->currentAvatar)) {
            $storage->delete($this->currentAvatar);
        }
    }

    public function render(): View
    {
        return view('livewire.tenant.karyawan.edit')->layout('layouts.tenant');
    }
}
