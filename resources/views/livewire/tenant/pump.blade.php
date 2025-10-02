<div class="space-y-2">
    <x-breadcumb :links="[['url' => route('tenant.dashboard'), 'label' => 'Dashboard'], ['url' => '#', 'label' => 'Pompa']]" />

    <div class="bg-base-100 rounded-lg shadow-sm p-6">
        @if (session('message'))
            <div class="alert alert-success mb-4">
                {{ session('message') }}
            </div>
        @endif
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-xl font-bold">Manajemen Pompa</h1>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4">
                <button wire:click="showAddForm" class="btn btn-primary whitespace-nowrap">
                    <span class="icon-[tabler--plus] size-4 mr-2"></span>
                    Tambah
                </button>
            </div>
        </div>

        @if (!$showForm)
            <div class="overflow-x-auto">
                <table class="table  w-full">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Status</th>
                            <th class="w-50 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pumps as $pump)
                            <tr>
                                <td>{{ $pump->name }}</td>
                                <td>
                                    <span class="badge {{ $pump->is_active ? 'badge-success' : 'badge-error' }}">
                                        {{ $pump->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <button wire:click="editPump({{ $pump->id }})" class="btn btn-sm btn-info">
                                            Edit
                                        </button>
                                        <button wire:click="toggleActive({{ $pump->id }})"
                                            class="btn btn-sm {{ $pump->is_active ? 'btn-warning' : 'btn-success' }}">
                                            {{ $pump->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                        <button @click="$dispatch('open-confirmation', { id: {{ $pump->id }} })"
                                            class="btn btn-sm btn-error">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Belum ada pompa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-base-200 rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">{{ $editing ? 'Edit Pompa' : 'Tambah Pompa Baru' }}</h2>
                <form wire:submit="savePump" class="space-y-4" novalidate>
                    <div class="flex flex-col sm:flex-row justify-center lg:gap-2">
                        <label class="label sm:w-1/4">
                            <span class="label-text">Nama Pompa</span>
                        </label>
                        <div class="w-full">
                            <input type="text" wire:model="name"
                                class="input sm:flex-1 @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama pompa" required>
                            @error('name')
                                <div class="helper-text">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="flex gap-2 justify-end">
                        <button type="button" wire:click="hideForm" class="btn btn-ghost">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        @endif

        {{-- <div class="mt-4">

        </div> --}}

        <x-confirm-dialog title="Hapus Pompa"
            message="Apakah Anda yakin ingin menghapus pompa ini? Tindakan ini tidak bisa dibatalkan." method="delete"
            confirmText="Hapus" type="error" />
    </div>
</div>
