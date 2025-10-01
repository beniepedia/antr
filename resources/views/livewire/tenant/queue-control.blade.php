<div class="space-y-6 max-w-md">
    <!-- Header -->
    <div class="flex justify-center items-center">
        <div>
            <h1 class="text-3xl font-bold">Kontrol Antrian</h1>
            <p class="text-base-content/70">Kelola antrian pelanggan secara real-time</p>
        </div>
    </div>

    <!-- Main Control Cards -->
    <div class="grid gap-3 grid-cols-1 md:grid-cols-2">
        <!-- Current Queue Card -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="card-title">Antrian Saat Ini</h5>
                    <span class="icon-[tabler--clock] size-6 text-primary"></span>
                </div>

                @if ($currentQueue)
                    <div class="card bg-gradient-to-r from-green-400 to-green-600 text-white mb-4 border-none">
                        <div class="card-body p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-2xl font-bold">
                                        {{ str_pad($currentQueue->queue_number, 3, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-cyan-100 text-sm">Dipanggil</div>
                                </div>
                                <span class="icon-[tabler--volume-2] size-8 opacity-80"></span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium">Pelanggan:</span>
                            <span class="text-sm">{{ $currentQueue->customer->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium">Jenis Kendaraan:</span>
                            <span class="text-sm">{{ $currentQueue->customerVehicle->vehicle->type ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium">Plat Nomor:</span>
                            <span class="text-sm">{{ $currentQueue->customerVehicle->license_plate ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium">Liter Diminta:</span>
                            <span class="text-sm">{{ $currentQueue->liters_requested }} L</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium">Waktu Check-in:</span>
                            <span
                                class="text-sm">{{ $currentQueue->checkin_time ? $currentQueue->checkin_time->format('H:i') : '-' }}</span>
                        </div>
                    </div>

                     <div class="flex flex-col sm:flex-row gap-2">
                         <button wire:click="recallCurrent" class="btn btn-primary btn-lg flex-1">
                             <span class="icon-[tabler--volume-2] size-5"></span>
                             Panggil
                         </button>
                         <button wire:click="completeCurrent" class="btn btn-success btn-lg flex-1">
                             <span class="icon-[tabler--check] size-5"></span>
                             Lanjut
                         </button>
                         <button wire:click="skipCurrent" class="btn btn-warning btn-lg flex-1">
                             <span class="icon-[tabler--player-skip-forward] size-5"></span>
                             Skip
                         </button>
                     </div>
                @else
                    <div class="text-center py-12">
                        <div class="avatar mb-4">
                            <div class="size-16 rounded-full bg-base-200">
                                <div class="size-full flex items-center justify-center">
                                    <span class="icon-[tabler--clock-off] size-6 text-base-content/50"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="font-semibold text-base-content/70">Tidak ada antrian aktif</h6>
                        <p class="text-sm text-base-content/50">Antrian yang sedang dipanggil akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Waiting Queues Card -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="card-title">Antrian Menunggu</h5>
                    <span class="icon-[tabler--list] size-6 text-success"></span>
                </div>

                @if ($waitingQueues->count() > 0)
                    <div class="space-y-2 mb-6">
                        @foreach ($waitingQueues as $queue)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3 bg-base-100 rounded-lg">
                                <div class="flex items-center space-x-3 mb-2 sm:mb-0">
                                    <div class="text-lg font-bold text-primary">
                                        {{ str_pad($queue->queue_number, 3, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="text-sm">
                                        <div class="font-medium">{{ $queue->customer->name ?? 'N/A' }}</div>
                                        <div class="text-base-content/70">
                                            {{ $queue->customerVehicle->license_plate ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button wire:click="callNext" class="btn btn-primary btn-lg w-full">
                        <span class="icon-[tabler--volume-2] size-5"></span>
                        Panggil Antrian Berikutnya
                    </button>
                @else
                    <div class="text-center py-12">
                        <div class="avatar mb-4">
                            <div class="size-16 rounded-full bg-base-200">
                                <div class="size-full flex items-center justify-center">
                                    <span class="icon-[tabler--list] size-6 text-base-content/50"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="font-semibold text-base-content/70">Antrian kosong</h6>
                        <p class="text-sm text-base-content/50">Tidak ada antrian yang menunggu</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between mb-6">
                <h5 class="card-title">Statistik Hari Ini</h5>
                <span class="icon-[tabler--chart-bar] size-6 text-info"></span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <span class="icon-[tabler--clock] size-8"></span>
                    </div>
                    <div class="stat-title">Menunggu</div>
                    <div class="stat-value text-warning">
                        {{ \App\Models\Queue::where('tenant_id', auth('tenant')->user()->tenant_id)->where('status', 'waiting')->count() }}
                    </div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-info">
                        <span class="icon-[tabler--volume-2] size-8"></span>
                    </div>
                    <div class="stat-title">Dipanggil</div>
                    <div class="stat-value text-info">
                        {{ \App\Models\Queue::where('tenant_id', auth('tenant')->user()->tenant_id)->where('status', 'called')->count() }}
                    </div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-success">
                        <span class="icon-[tabler--check] size-8"></span>
                    </div>
                    <div class="stat-title">Selesai</div>
                    <div class="stat-value text-success">
                        {{ \App\Models\Queue::where('tenant_id', auth('tenant')->user()->tenant_id)->where('status', 'completed')->whereDate('created_at', today())->count() }}
                    </div>
                </div>

                <div class="stat">
                    <div class="stat-figure text-error">
                        <span class="icon-[tabler--x] size-8"></span>
                    </div>
                    <div class="stat-title">Dibatalkan</div>
                    <div class="stat-value text-error">
                        {{ \App\Models\Queue::where('tenant_id', auth('tenant')->user()->tenant_id)->where('status', 'cancelled')->whereDate('created_at', today())->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
