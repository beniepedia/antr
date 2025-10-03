<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Karyawan</h1>
        <a href="{{ route('tenant.karyawan') }}" class="btn btn-outline">
            <span class="icon-[tabler--arrow-left] size-4 mr-2"></span>
            Kembali
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- User Info -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nama</span>
                </label>
                <input type="text" wire:model="name" class="input input-bordered" placeholder="Nama lengkap"
                    required />
                @error('name')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" wire:model="email" class="input input-bordered" placeholder="email@example.com"
                    required />
                @error('email')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>



            <!-- Profile Info -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text">ID Karyawan</span>
                </label>
                <input type="text" wire:model="employee_id" class="input input-bordered" placeholder="ID Karyawan" />
                @error('employee_id')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Jabatan</span>
                </label>
                <select wire:model="position" class="select select-bordered" required>
                    @foreach (\App\Enums\PositionEnum::options() as $value => $label)
                        <option value="{{ $value }}" {{ $position == $value ? 'selected' : '' }}>
                            {{ $label }}</option>
                    @endforeach
                </select>
                @error('position')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tanggal Mulai Kerja</span>
                </label>
                <input type="date" wire:model="hire_date" class="input input-bordered" />
                @error('hire_date')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Status</span>
                </label>
                <select wire:model="status" class="select select-bordered" required>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
                @error('status')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nomor Lisensi</span>
                </label>
                <input type="text" wire:model="license_number" class="input input-bordered"
                    placeholder="Nomor Lisensi" />
                @error('license_number')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tahun Pengalaman</span>
                </label>
                <input type="number" wire:model="experience_years" class="input input-bordered" placeholder="0"
                    min="0" />
                @error('experience_years')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Nomor WhatsApp</span>
                </label>
                <input type="text" wire:model="whatsapp" class="input input-bordered" placeholder="628xxxxxxxxx"
                    required />
                @error('whatsapp')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Alamat</span>
                </label>
                <textarea wire:model="address" class="textarea textarea-bordered" rows="3" placeholder="Alamat lengkap"></textarea>
                @error('address')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Foto Profil</span>
                </label>
                <input type="file" wire:model="avatar" class="file-input file-input-bordered" accept="image/*" />
                @error('avatar')
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
            <a href="{{ route('tenant.karyawan') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
