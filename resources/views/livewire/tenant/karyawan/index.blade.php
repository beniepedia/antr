<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Karyawan</h1>
        <a href="/karyawan/create" class="btn btn-primary">
            <span class="icon-[tabler--plus] size-4 mr-2"></span>
            Tambah Karyawan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>ID Karyawan</th>
                    <th>Jabatan</th>
                    <th>Shift</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawan as $k)
                    <tr>
                        <td>{{ $k->name }}</td>
                        <td>{{ $k->email }}</td>
                        <td>{{ $k->profile?->employee_id ?? '-' }}</td>
                        <td>
                            <span
                                class="badge badge-outline">{{ \App\Enums\PositionEnum::tryFrom($k->profile?->position ?? 'operator')?->label() ?? 'Operator' }}</span>
                        </td>
                        <td>{{ $k->profile?->shift ? ucfirst($k->profile->shift) : '-' }}</td>
                        <td>
                            <span
                                class="badge {{ $k->profile?->status == 'active' ? 'badge-success' : 'badge-warning' }}">
                                {{ $k->profile?->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>{{ $k->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="flex gap-2">
                                <a href="/karyawan/{{ $k->id }}/edit" class="btn btn-sm btn-outline btn-info">
                                    <span class="icon-[tabler--edit] size-4"></span>
                                </a>
                                <button wire:click="delete({{ $k->id }})"
                                    class="btn btn-sm btn-outline btn-error"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?')">
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

</div>
