<div class="space-y-2">
    <x-breadcumb :links="[['url' => route('tenant.dashboard'), 'label' => 'Dashboard'], ['url' => '#', 'label' => 'Kendaraan']]" />

    <div class="bg-base-100 rounded-lg shadow-sm p-6">
        @if (session('message'))
            <div class="alert alert-success mb-4">
                {{ session('message') }}
            </div>
        @endif
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-xl font-bold">Manajemen Kendaraan</h1>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4">
                @if (!$showForm)
                    <button wire:click="showAddForm" class="btn btn-primary whitespace-nowrap">
                        <span class="icon-[tabler--plus] size-4 mr-2"></span>
                        Tambah
                    </button>
                @endif
            </div>
        </div>

        @if (!$showForm)
            <div class="overflow-x-auto">
                <table class="table  w-full">
                    <thead>
                        <tr>
                            <th>Tipe</th>
                            <th>Maksimal Liter</th>
                            <th class="w-50 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehicles as $vehicle)
                            <tr>
                                <td>{{ $vehicle->type }}</td>
                                <td>{{ $vehicle->max_liters }} Liter</td>
                                <td>
                                    <div class="flex gap-2">
                                        <button wire:click="editVehicle({{ $vehicle->id }})"
                                            class="btn btn-sm btn-info">
                                            Edit
                                        </button>
                                        <button @click="$dispatch('open-confirmation', { id: {{ $vehicle->id }} })"
                                            class="btn btn-sm btn-error">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Belum ada kendaraan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-base-200 rounded-lg p-6 lg:max-w-2xl">
                <h2 class="text-lg font-semibold mb-4">{{ $editing ? 'Edit Kendaraan' : 'Tambah Kendaraan Baru' }}</h2>
                <form wire:submit="saveVehicle" class="space-y-4" novalidate>
                    <div class="container">
                        <div class="w-full">
                            <label class="label sm:w-1/4">
                                <span class="label-text">Tipe Kendaraan</span>
                            </label>
                            <input type="text" wire:model="type"
                                class="input sm:flex-1 @error('type') is-invalid @enderror" placeholder="Cth: roda 4"
                                required>
                            @error('type')
                                <div class="helper-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="container mb-10">
                        <div class="w-full">
                            <label class="label sm:w-1/4">
                                <span class="label-text">Maksimal Liter</span>
                            </label>
                            <input type="number" wire:model="max_liters"
                                class="input sm:flex-1 @error('max_liters') is-invalid @enderror"
                                placeholder="Masukkan maksimal liter" required>
                            @error('max_liters')
                                <div class="helper-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex gap-2 justify-end">
                        <button type="button" wire:click="hideForm" class="btn btn-ghost">Batal</button>
                        <button type="submit" class="btn btn-primary">{{ $editing ? 'Simpan' : 'Tambah' }}</button>
                    </div>
                </form>
            </div>
        @endif

        <x-confirm-dialog title="Hapus Kendaraan"
            message="Apakah Anda yakin ingin menghapus kendaraan ini? Tindakan ini tidak bisa dibatalkan."
            method="delete" confirmText="Hapus" type="error" />
    </div>
</div>
