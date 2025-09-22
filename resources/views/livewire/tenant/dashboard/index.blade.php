<div>
    <div class="grid gap-4 lg:grid-cols-2 mb-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2.5">Selamat Datang</h5>
                <p>Halo, {{ $user->name }}! Selamat datang di dashboard Antrianku.</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2.5">Statistik</h5>
                <div class="flex flex-wrap gap-2">
                    <div class="alert alert-primary" role="alert">Antrian Saya: {{ $dashboardData['total_queues'] }}
                    </div>
                    <div class="alert alert-secondary" role="alert">Antrian Aktif:
                        {{ $dashboardData['active_queues'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-8">
        <div class="card-body">
            <h5 class="card-title mb-2.5">Antrian Terbaru</h5>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>ID Antrian</th>
                            <th>Layanan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Perkiraan Waktu</th>
                        </tr>
                    </thead>
                     <tbody>
                         @forelse($dashboardData['recent_queues'] as $queue)
                         <tr>
                             <td>{{ $queue['id'] }}</td>
                             <td>{{ $queue['service'] }}</td>
                             <td>{{ $queue['date'] }}</td>
                             <td>
                                 @if($queue['status'] == 'Selesai')
                                     <span class="badge badge-success">{{ $queue['status'] }}</span>
                                 @elseif($queue['status'] == 'Dipanggil')
                                     <span class="badge badge-warning">{{ $queue['status'] }}</span>
                                 @elseif($queue['status'] == 'Dibatalkan')
                                     <span class="badge badge-error">{{ $queue['status'] }}</span>
                                 @else
                                     <span class="badge">{{ $queue['status'] }}</span>
                                 @endif
                             </td>
                             <td>{{ $queue['time'] }}</td>
                         </tr>
                         @empty
                         <tr>
                             <td colspan="5" class="text-center">Belum ada antrian</td>
                         </tr>
                         @endforelse
                     </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2 mb-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2.5">Layanan Populer</h5>
                 <div class="flex flex-wrap gap-2">
                     @forelse($dashboardData['popular_services'] as $index => $service)
                         <button class="btn {{ $index == 0 ? 'btn-primary' : ($index == 1 ? 'btn-secondary' : ($index == 2 ? 'btn-accent' : '')) }}">{{ $service }}</button>
                     @empty
                         <p class="text-gray-500">Belum ada layanan populer</p>
                     @endforelse
                 </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2.5">Status Antrian</h5>
                 <div class="flex flex-wrap gap-2">
                     <span class="badge">Total: {{ $dashboardData['queue_status']['total'] }}</span>
                     <span class="badge badge-success">Selesai: {{ $dashboardData['queue_status']['completed'] }}</span>
                     <span class="badge badge-warning">Dipanggil: {{ $dashboardData['queue_status']['in_progress'] }}</span>
                     <span class="badge badge-accent">Menunggu: {{ $dashboardData['queue_status']['waiting'] }}</span>
                     <span class="badge badge-error">Dibatalkan: {{ $dashboardData['queue_status']['cancelled'] }}</span>
                 </div>
            </div>
        </div>
    </div>

    <div class="card mb-8">
        <div class="card-body">
            <h5 class="card-title mb-2.5">Informasi</h5>
            <div class="space-y-2">
                <div class="alert alert-primary" role="alert">Jadwal layanan hari ini: 08:00 - 16:00 WIB</div>
                <div class="alert alert-primary alert-soft" role="alert">
                    Terima kasih telah menggunakan layanan Antrianku. Nikmati kemudahan antrian tanpa ribet!
                </div>
                <div class="alert alert-primary alert-outline" role="alert">
                    Perhatian! Pastikan data Anda selalu up-to-date untuk menghindari kendala dalam pelayanan.
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-2.5">Buat Antrian Baru</h5>
            <div>
                <button type="button" class="btn btn-primary">
                    Buat Antrian
                </button>
                <div id="basic-modal" class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 hidden"
                    role="dialog" tabindex="-1">
                    <div class="modal-dialog overlay-open:opacity-100 overlay-open:duration-300">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Buat Antrian Baru</h3>
                                <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3"
                                    aria-label="Close" data-overlay="#basic-modal">
                                    <span class="icon-[tabler--x] size-4"></span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Form untuk membuat antrian baru akan muncul di sini. Anda dapat memilih layanan yang
                                tersedia dan menjadwalkan waktu kedatangan Anda.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-soft btn-secondary" data-overlay="#basic-modal">
                                    Batal
                                </button>
                                <button type="button" class="btn btn-primary">Simpan Antrian</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
