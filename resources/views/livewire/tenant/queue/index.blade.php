<div class="space-y-2">
    <!-- Breadcrumb -->
    <x-breadcumb :links="[
        ['url' => route('tenant.dashboard'), 'label' => 'Dashboard'],
        ['url' => '#', 'label' => 'Manajemen Antrian'],
    ]" />

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Antrian</h1>
        </div>

        <!-- Filters -->
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="form-control w-full sm:w-auto">
                <label class="label">
                    <span class="label-text">Status</span>
                </label>
                <select wire:model.live="filterStatus" class="select select-bordered select-sm w-full">
                    <option value="">Semua Status</option>
                    <option value="waiting">Menunggu</option>
                    <option value="called">Dipanggil</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                    <option value="expired">Kadaluarsa</option>
                </select>
            </div>

            <div class="form-control w-full sm:w-auto">
                <label class="label">
                    <span class="label-text">Tanggal</span>
                </label>
                <input type="date" wire:model.live="filterDate" class="input input-bordered input-sm w-full" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>No. Antrian</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Liter Diminta</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Dilayani Oleh</th>
                        <th>Waktu Check-in</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->queues as $queue)
                        <tr>
                            <td>
                                <span
                                    class="font-bold text-lg">{{ str_pad($queue->queue_number, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>{{ $queue->customer->name ?? 'N/A' }}</td>
                            <td>{{ $queue->customerVehicle->vehicle->type ?? 'N/A' }} - {{ $queue->customerVehicle->license_plate ?? 'N/A' }}</td>
                            <td>{{ $queue->liters_requested }} L</td>
                            <td>{{ $queue->queue_date->format('d M Y') }}</td>
                            <td>
                                <span
                                    class="badge {{ match ($queue->status) {
                                        'waiting' => 'badge-warning',
                                        'called' => 'badge-info',
                                        'completed' => 'badge-success',
                                        'cancelled' => 'badge-error',
                                        'expired' => 'badge-neutral',
                                        default => 'badge-ghost',
                                    } }}">
                                    {{ match ($queue->status) {
                                        'waiting' => 'Menunggu',
                                        'called' => 'Dipanggil',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                        'expired' => 'Kadaluarsa',
                                        default => 'Unknown',
                                    } }}
                                </span>
                            </td>
                            <td>
                                {{ $queue->servedBy ? $queue->servedBy->name : '-' }}
                            </td>
                            <td>{{ $queue->checkin_time ? $queue->checkin_time->format('H:i') : '-' }}</td>
                            <td>
                                <div class="flex gap-2">
                                    @if ($queue->status === 'waiting')
                                        <button wire:click="callQueue({{ $queue->id }})"
                                            class="btn btn-xs btn-outline btn-info">
                                            <span class="icon-[tabler--phone] size-3"></span>
                                            Panggil
                                        </button>
                                    @endif

                                    @if (in_array($queue->status, ['waiting', 'called']))
                                        <button wire:click="completeQueue({{ $queue->id }})"
                                            class="btn btn-xs btn-outline btn-success">
                                            <span class="icon-[tabler--check] size-3"></span>
                                            Selesai
                                        </button>
                                    @endif

                                    @if ($queue->status !== 'completed' && $queue->status !== 'cancelled')
                                        <button wire:click="cancelQueue({{ $queue->id }})"
                                            class="btn btn-xs btn-outline btn-error"
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan antrian ini?')">
                                            <span class="icon-[tabler--x] size-3"></span>
                                            Batal
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                @if ($filterStatus || $filterDate)
                                    Tidak ada antrian dengan filter yang dipilih.
                                @else
                                    Belum ada antrian.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($this->queues->count() > 0)
            <div class="mt-4 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Total antrian: {{ $this->queues->total() }}
                </div>
                <div>
                    {{ $this->queues->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
