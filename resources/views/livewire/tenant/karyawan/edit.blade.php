<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Karyawan</h1>
    </div>

    <form wire:submit.prevent="save" class="space-y-6" novalidate>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <!-- Profile Info -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">ID Karyawan</span>
                </label>
                <input type="text" wire:model="form.employee_id" class="input" placeholder="ID Karyawan" />
                @error('form.employee_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- User Info -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input type="text" wire:model="form.name" class="input" placeholder="Nama lengkap" required />
                @error('form.name')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" wire:model="form.email" class="input" placeholder="email@example.com" required />
                @error('form.email')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Password Baru (Opsional)</span>
                </label>
                <input type="password" wire:model="form.password" class="input"
                    placeholder="Kosongkan jika tidak ingin mengubah" />
                @error('form.password')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-control">
                <label class="label">
                    <span class="label-text">Konfirmasi Password</span>
                </label>
                <input type="password" wire:model="form.password_confirmation" class="input"
                    placeholder="Konfirmasi password baru" />
                @error('form.password_confirmation')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-control">
                <label class="label">
                    <span class="label-text">Jabatan</span>
                </label>
                <select wire:model="form.position" class="select select-bordered" required>
                    @foreach (\App\Enums\PositionEnum::options() as $value => $label)
                        <option value="{{ $value }}" {{ $form->position == $value ? 'selected' : '' }}>
                            {{ $label }}</option>
                    @endforeach
                </select>
                @error('form.position')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Hak Akses</span>
                </label>
                <select wire:model="form.role" class="select select-bordered" required>
                    @foreach (\App\Enums\TenantRole::cases() as $role)
                        <option value="{{ $role->value }}" {{ $form->role == $role->value ? 'selected' : '' }}
                            class="text-capitalize">
                            {{ ucfirst($role->value) }}
                        </option>
                    @endforeach
                </select>
                @error('form.role')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tanggal Mulai Kerja</span>
                </label>
                <input type="date" wire:model="form.hire_date" class="input" />
                @error('form.hire_date')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Status</span>
                </label>
                <select wire:model="form.status" class="select select-bordered" required>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
                @error('form.status')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">NIK</span>
                </label>
                <input type="text" wire:model="form.license_number" class="input" placeholder="Masukkan NIK" />
                @error('form.license_number')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nomor WhatsApp</span>
                </label>
                <input type="text" wire:model="form.whatsapp" class="input" placeholder="628xxxxxxxxx" required />
                @error('form.whatsapp')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Alamat</span>
                </label>
                <textarea wire:model="form.address" class="textarea textarea-bordered" rows="3" placeholder="Alamat lengkap"></textarea>
                @error('form.address')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label-text" for="inpuFileTypeDefault">Upload Gambar</label>
                <input type="file" wire:model="form.avatar" class="input w-full" id="inpuFileTypeDefault"
                    accept="image/*" />
                @error('form.avatar')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
                @if ($currentAvatar)
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $currentAvatar) }}" alt="Current Avatar"
                            class="w-20 h-20 object-cover rounded">
                    </div>
                @endif
                @if ($avatar)
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Pratinjau:</p>
                        <img src="{{ $avatar->temporaryUrl() }}" alt="Preview"
                            class="w-20 h-20 object-cover rounded">
                    </div>
                @endif
            </div>
        </div>


        <div class="flex justify-end space-x-4">
            <a href="{{ route('tenant.karyawan') }}" class="btn btn-outline" wire:navigate>Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
