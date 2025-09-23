<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Petugas</h1>
        <button wire:click="openCreateModal" class="btn btn-primary">
            <span class="icon-[tabler--plus] size-4 mr-2"></span>
            Tambah Petugas
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($petugas as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->email }}</td>
                        <td>
                            <span class="badge badge-outline">{{ $p->role }}</span>
                        </td>
                        <td>{{ $p->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="flex gap-2">
                                <button wire:click="openEditModal({{ $p->id }})"
                                    class="btn btn-sm btn-outline btn-info">
                                    <span class="icon-[tabler--edit] size-4"></span>
                                </button>
                                <button wire:click="delete({{ $p->id }})"
                                    class="btn btn-sm btn-outline btn-error"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
                                    <span class="icon-[tabler--trash] size-4"></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Belum ada petugas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <!-- Trigger -->
    <button class="btn btn-primary" data-overlay="#my-modal">
        Open Modal
    </button>

    <!-- Modal -->
    <div id="my-modal" class="overlay modal modal-middle hidden">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold">Dialog Title</h3>
                <button type="button" class="btn btn-text btn-circle btn-sm" data-overlay="#my-modal">
                    ✕
                </button>
            </div>
            <div class="modal-body">
                <p>Isi modal versi FlyonUI v2.0.0 dengan Tailwind 4.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-overlay="#my-modal">Close</button>
                <button class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>



</div>
<!-- Modal for Create/Edit -->
@if ($showModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg">{{ $isEditing ? 'Edit Petugas' : 'Tambah Petugas' }}</h3>
            <form wire:submit.prevent="save" class="py-4">
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Nama</span>
                    </label>
                    <input type="text" wire:model="name" class="input input-bordered" placeholder="Nama petugas"
                        required />
                    @error('name')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" wire:model="email" class="input input-bordered"
                        placeholder="email@example.com" required />
                    @error('email')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Password
                            {{ $isEditing ? '(Kosongkan jika tidak ingin mengubah)' : '' }}</span>
                    </label>
                    <input type="password" wire:model="password" class="input input-bordered" placeholder="Password"
                        {{ $isEditing ? '' : 'required' }} />
                    @error('password')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Konfirmasi Password</span>
                    </label>
                    <input type="password" wire:model="password_confirmation" class="input input-bordered"
                        placeholder="Konfirmasi Password" {{ $isEditing ? '' : 'required' }} />
                </div>
                <div class="modal-action">
                    <button type="button" wire:click="closeModal" class="btn">Batal</button>
                    <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Update' : 'Simpan' }}</button>
                </div>
            </form>
        </div>
    </div>
@endif
