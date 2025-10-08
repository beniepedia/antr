<div class="space-y-2">
    <x-breadcumb :links="[['url' => route('tenant.dashboard'), 'label' => 'Dashboard'], ['url' => '#', 'label' => 'Karyawan']]" />

    <div class="bg-base-100 rounded-lg shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-xl font-bold">Manajemen Karyawan</h1>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4">
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Cari karyawan..." class="input">
                <a href="{{ route('tenant.karyawan.create') }}" wire:navigate class="btn btn-primary whitespace-nowrap">
                    <span class="icon-[tabler--plus] size-4 mr-2"></span>
                    Tambah Karyawan
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>ID Karyawan</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawan as $k)
                        <tr>
                            <td>
                                @if ($k->profile?->avatar)
                                    <img src="{{ asset('storage/' . $k->profile->avatar) }}" alt="Avatar"
                                        class="w-10 h-10 object-cover rounded-full">
                                @else
                                    <x-avatar name="{{ substr($k->name, 0, 1) }}" size="10" />
                                @endif
                            </td>
                            <td>{{ $k->name }}</td>
                            <td>{{ $k->email }}</td>
                            <td>{{ $k->profile?->employee_id ?? '-' }}</td>
                            <td>
                                <span class="badge badge-warning badge-soft">
                                    {{ \App\Enums\PositionEnum::from($k->profile->position ?? '')->label() }}
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge badge-soft {{ $k->profile?->status == 'active' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $k->profile?->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>{{ $k->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('tenant.karyawan.show', $k->id) }}"
                                        class="btn btn-sm btn-outline btn-primary" wire:navigate>
                                        <span class="icon-[tabler--eye] size-4"></span>
                                    </a>
                                    <a href="{{ route('tenant.karyawan.edit', $k->id) }}"
                                        class="btn btn-sm btn-outline btn-info" wire:navigate>
                                        <span class="icon-[tabler--edit] size-4"></span>
                                    </a>
                                    <button @click="$dispatch('open-confirmation', { id: {{ $k->id }} })"
                                        class="btn btn-sm btn-outline btn-error">
                                        <span class="icon-[tabler--trash] size-4"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Belum ada karyawan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $karyawan->links() }}
        </div>

        <x-confirm-dialog title="Hapus Karyawan"
            message="Apakah Anda yakin ingin menghapus karyawan ini? Tindakan ini tidak bisa dibatalkan."
            method="delete" confirmText="Hapus" type="success" />
    </div>
</div>
