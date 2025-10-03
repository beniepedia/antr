<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Karyawan Baru</h1>
        <a href="{{ route('tenant.karyawan') }}" class="btn btn-outline">
            <span class="icon-[tabler--arrow-left] size-4 mr-2"></span>
            Kembali
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6" novalidate>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                    <span class="label-text">Nomor Lisensi</span>
                </label>
                <input type="text" wire:model="form.license_number" class="input" placeholder="Nomor Lisensi" />
                @error('form.license_number')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Tahun Pengalaman</span>
                </label>
                <input type="number" wire:model="form.experience_years" class="input" placeholder="0"
                    min="0" />
                @error('form.experience_years')
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
                <label class="label">
                    <span class="label-text">Foto Profil</span>
                </label>
                <input type="file" wire:model="form.avatar" class="file-input file" accept="image/*" />
                @error('form.avatar')
                    <span class="text-error text-sm">{{ $message }}</span>
                @enderror
                {{-- @if ($avatar)
                    <div class="mt-2">
                        <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="w-20 h-20 object-cover rounded">
                    </div>
                @endif --}}
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('tenant.karyawan') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
