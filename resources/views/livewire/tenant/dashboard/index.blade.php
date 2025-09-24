<div>
    <!-- Welcome and Subscription Row -->
    <div class="grid gap-4 lg:grid-cols-2 mb-8">
        <!-- Welcome Section -->
        <div class="card bg-gradient-to-r from-blue-400 to-purple-500 text-white">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ $user->name }}!</h1>
                        <p class="text-blue-100">Kelola antrian Anda dengan mudah di dashboard Antrianku.</p>
                    </div>
                    <div class="hidden md:block">
                        <span class="icon-[tabler--cube] size-16 opacity-20" style="filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3)); transform: perspective(500px) rotateY(-10deg);"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Status -->
        <div class="card border-none">
            <div class="card-body">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="card-title text-sm md:text-xl">Status Langganan</h5>
                    <div class="flex items-center gap-2">
                        <button type="button" class="btn btn-primary btn-xs hidden md:inline-flex">
                            <span class="icon-[tabler--arrow-up] size-3"></span>
                            Upgrade
                        </button>
                        <span class="icon-[tabler--crown] size-6 {{ $dashboardData['subscription'] ? ($dashboardData['subscription']['status'] == 'active' ? 'text-success' : 'text-warning') : 'text-gray-400' }}"></span>
                    </div>
                </div>
                @if($dashboardData['subscription'])
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <p class="text-sm text-gray-600">Paket</p>
                            <p class="font-semibold">{{ $dashboardData['subscription']['plan_name'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="badge {{ $dashboardData['subscription']['status'] == 'active' ? '' : 'badge-warning' }}" style="{{ $dashboardData['subscription']['status'] == 'active' ? 'background-color: #1e7e34; color: white; border: none;' : '' }}">
                                {{ $dashboardData['subscription']['status'] == 'active' ? 'Aktif' : ucfirst($dashboardData['subscription']['status']) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Mulai</p>
                            <p class="font-semibold">{{ $dashboardData['subscription']['start_date'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Berakhir</p>
                            <p class="font-semibold">{{ $dashboardData['subscription']['end_date'] }}</p>
                        </div>
                    </div>
                    @if($dashboardData['subscription']['days_remaining'] >= 0)
                        <div class="mt-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span>Hari Tersisa</span>
                                <span>{{ round($dashboardData['subscription']['days_remaining']) }} / {{ $dashboardData['subscription']['total_days'] }} hari</span>
                            </div>
                            @php
                                $progressPercent = round(min(100, max(0, ($dashboardData['subscription']['days_remaining'] / $dashboardData['subscription']['total_days']) * 100)));
                                $progressClass = $dashboardData['subscription']['days_remaining'] > ($dashboardData['subscription']['total_days'] * 0.7) ? 'bg-success' : ($dashboardData['subscription']['days_remaining'] > ($dashboardData['subscription']['total_days'] * 0.3) ? 'bg-warning' : 'bg-error');
                                $progressStyle = $progressClass === 'bg-success' ? 'background-color: #1e7e34 !important;' : '';
                            @endphp
                            <div class="progress h-4" role="progressbar" aria-label="{{ $progressPercent }}% Progressbar" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar {{ $progressClass }} font-normal" style="width: {{ $progressPercent }}%; {{ $progressStyle }}">{{ $progressPercent }}%</div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-error mt-4">
                            <span class="icon-[tabler--alert-triangle] size-4"></span>
                            Langganan telah berakhir. Perpanjang untuk melanjutkan layanan.
                        </div>
                    @endif
                    <div class="mt-4 md:hidden">
                        <button type="button" class="btn btn-primary w-full">
                            <span class="icon-[tabler--arrow-up] size-4"></span>
                            Upgrade Paket
                        </button>
                    </div>
                @else
                    <div class="text-center py-8">
                        <span class="icon-[tabler--crown-off] size-12 text-gray-400 mb-2 block"></span>
                        <p class="text-gray-500">Tidak ada langganan aktif</p>
                        <p class="text-sm text-gray-400">Hubungi admin untuk berlangganan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Announcement Banner -->
    <div class="card bg-gradient-to-r from-yellow-100 to-orange-100 border-yellow-300 mb-8">
        <div class="card-body">
            <div class="flex items-center gap-3">
                <span class="icon-[tabler--megaphone] size-8 text-yellow-600"></span>
                <div>
                    <h6 class="font-bold text-yellow-800">Pengumuman Penting</h6>
                    <p class="text-yellow-700 text-sm">Sistem antrian akan mengalami maintenance pada tanggal 25 September 2025 pukul 22:00 - 24:00 WIB. Mohon maaf atas ketidaknyamanannya.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Statistics -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="card bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200 hover:shadow-lg transition-shadow duration-300">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-title text-blue-600 font-medium">Total Antrian</div>
                        <div class="stat-value text-3xl font-bold text-blue-800">{{ $dashboardData['total_queues'] }}</div>
                        <div class="stat-desc text-blue-500 text-sm">Semua antrian yang dibuat</div>
                    </div>
                    <div class="stat-figure">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="icon-[tabler--list] size-6 text-white"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-orange-50 to-orange-100 border-orange-200 hover:shadow-lg transition-shadow duration-300">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-title text-orange-600 font-medium">Antrian Aktif</div>
                        <div class="stat-value text-3xl font-bold text-orange-800">{{ $dashboardData['active_queues'] }}</div>
                        <div class="stat-desc text-orange-500 text-sm">Sedang menunggu atau dipanggil</div>
                    </div>
                    <div class="stat-figure">
                        <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center">
                            <span class="icon-[tabler--clock] size-6 text-white"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-purple-50 to-purple-100 border-purple-200 hover:shadow-lg transition-shadow duration-300">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-title text-purple-600 font-medium">Total Pelanggan</div>
                        <div class="stat-value text-3xl font-bold text-purple-800">{{ $dashboardData['total_users'] }}</div>
                        <div class="stat-desc text-purple-500 text-sm">Pelanggan terdaftar</div>
                    </div>
                    <div class="stat-figure">
                        <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                            <span class="icon-[tabler--users] size-6 text-white"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-green-50 to-green-100 border-green-200 hover:shadow-lg transition-shadow duration-300">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="stat-title text-green-600 font-medium">Antrian Selesai</div>
                        <div class="stat-value text-3xl font-bold text-green-800">{{ $dashboardData['queue_status']['completed'] }}</div>
                        <div class="stat-desc text-green-500 text-sm">Berhasil dilayani</div>
                    </div>
                    <div class="stat-figure">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <span class="icon-[tabler--check] size-6 text-white"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Visit Chart -->
    <div class="card mb-8">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h5 class="card-title text-sm md:text-xl">Grafik Kunjungan Pelanggan</h5>
                <span class="icon-[tabler--chart-bar] size-6 text-primary"></span>
            </div>
            <div id="customer-visit-chart" class="w-full h-64"></div>
        </div>
    </div>

    <!-- Information and Tips -->
    <div class="card mb-8">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h5 class="card-title text-sm md:text-xl">Informasi & Tips</h5>
                <span class="icon-[tabler--info-circle] size-6 text-info"></span>
            </div>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div class="alert alert-primary">
                    <span class="icon-[tabler--clock] size-5"></span>
                    <div>
                        <h4 class="font-bold">Jadwal Layanan</h4>
                        <div class="text-xs">Hari ini: 08:00 - 16:00 WIB</div>
                    </div>
                </div>
                <div class="alert alert-success alert-soft">
                    <span class="icon-[tabler--heart] size-5"></span>
                    <div>
                        <h4 class="font-bold">Terima Kasih!</h4>
                        <div class="text-xs">Nikmati kemudahan antrian tanpa ribet</div>
                    </div>
                </div>
                <div class="alert alert-warning alert-outline">
                    <span class="icon-[tabler--alert-triangle] size-5"></span>
                    <div>
                        <h4 class="font-bold">Penting!</h4>
                        <div class="text-xs">Pastikan data Anda selalu up-to-date</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Queues -->
    <div class="card mb-8">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h5 class="card-title text-sm md:text-xl">Antrian Terbaru</h5>
                <span class="icon-[tabler--clock-play] size-6 text-primary"></span>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>ID Antrian</th>
                            <th>Layanan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Waktu Check-in</th>
                        </tr>
                    </thead>
                     <tbody>
                         @forelse($dashboardData['recent_queues'] as $queue)
                         <tr>
                             <td class="font-mono">{{ $queue['id'] }}</td>
                             <td>{{ $queue['service'] }}</td>
                             <td>{{ $queue['date'] }}</td>
                             <td>
                                 @if($queue['status'] == 'Selesai')
                                     <span class="badge badge-success gap-1">
                                         <span class="icon-[tabler--check] size-3"></span>
                                         {{ $queue['status'] }}
                                     </span>
                                 @elseif($queue['status'] == 'Dipanggil')
                                     <span class="badge badge-warning gap-1">
                                         <span class="icon-[tabler--bell] size-3"></span>
                                         {{ $queue['status'] }}
                                     </span>
                                 @elseif($queue['status'] == 'Dibatalkan')
                                     <span class="badge badge-error gap-1">
                                         <span class="icon-[tabler--x] size-3"></span>
                                         {{ $queue['status'] }}
                                     </span>
                                 @elseif($queue['status'] == 'Menunggu')
                                     <span class="badge badge-info gap-1">
                                         <span class="icon-[tabler--clock] size-3"></span>
                                         {{ $queue['status'] }}
                                     </span>
                                 @else
                                     <span class="badge gap-1">
                                         <span class="icon-[tabler--question-mark] size-3"></span>
                                         {{ $queue['status'] }}
                                     </span>
                                 @endif
                             </td>
                             <td>{{ $queue['time'] }}</td>
                         </tr>
                         @empty
                         <tr>
                             <td colspan="5" class="text-center py-8">
                                 <div class="flex flex-col items-center gap-2">
                                     <span class="icon-[tabler--inbox] size-12 text-gray-400"></span>
                                     <p class="text-gray-500">Belum ada antrian</p>
                                 </div>
                             </td>
                         </tr>
                         @endforelse
                     </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2 mb-8">
        <!-- Popular Services -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="card-title text-sm md:text-xl">Layanan Populer</h5>
                    <span class="icon-[tabler--star] size-6 text-yellow-500"></span>
                </div>
                @if(count($dashboardData['popular_services']) > 0)
                    <div class="space-y-3">
                        @foreach($dashboardData['popular_services'] as $index => $service)
                            <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary text-primary-content rounded-full flex items-center justify-center font-bold text-center">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">{{ $service }}</p>
                                </div>
                                <span class="icon-[tabler--chevron-right] size-4 text-gray-400"></span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <span class="icon-[tabler--chart-pie] size-12 text-gray-400 mb-2 block mx-auto"></span>
                        <p class="text-gray-500">Belum ada data layanan populer</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Queue Status Overview -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="card-title text-sm md:text-xl">Status Antrian</h5>
                    <span class="icon-[tabler--chart-bar] size-6 text-primary"></span>
                </div>
                <div class="space-y-4">
                    @php
                        $total = $dashboardData['queue_status']['total'];
                        $completedPercent = $total > 0 ? round(($dashboardData['queue_status']['completed'] / $total) * 100) : 0;
                        $inProgressPercent = $total > 0 ? round(($dashboardData['queue_status']['in_progress'] / $total) * 100) : 0;
                        $waitingPercent = $total > 0 ? round(($dashboardData['queue_status']['waiting'] / $total) * 100) : 0;
                        $cancelledPercent = $total > 0 ? round(($dashboardData['queue_status']['cancelled'] / $total) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Selesai</span>
                            <span>{{ $dashboardData['queue_status']['completed'] }} ({{ $completedPercent }}%)</span>
                        </div>
                        <progress class="progress progress-success" value="{{ $completedPercent }}" max="100"></progress>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Dipanggil</span>
                            <span>{{ $dashboardData['queue_status']['in_progress'] }} ({{ $inProgressPercent }}%)</span>
                        </div>
                        <progress class="progress progress-warning" value="{{ $inProgressPercent }}" max="100"></progress>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Menunggu</span>
                            <span>{{ $dashboardData['queue_status']['waiting'] }} ({{ $waitingPercent }}%)</span>
                        </div>
                        <progress class="progress progress-info" value="{{ $waitingPercent }}" max="100"></progress>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Dibatalkan</span>
                            <span>{{ $dashboardData['queue_status']['cancelled'] }} ({{ $cancelledPercent }}%)</span>
                        </div>
                        <progress class="progress progress-error" value="{{ $cancelledPercent }}" max="100"></progress>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Quick Actions -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h5 class="card-title text-sm md:text-xl">Aksi Cepat</h5>
                <span class="icon-[tabler--zap] size-6 text-warning"></span>
            </div>
            <div class="flex flex-wrap gap-4">
                <button type="button" class="btn btn-primary btn-lg gap-2" data-overlay="#basic-modal">
                    <span class="icon-[tabler--plus] size-5"></span>
                    Buat Antrian Baru
                </button>
                <button type="button" class="btn btn-outline btn-secondary gap-2">
                    <span class="icon-[tabler--eye] size-5"></span>
                    Lihat Semua Antrian
                </button>
                <button type="button" class="btn btn-outline btn-accent gap-2">
                    <span class="icon-[tabler--settings] size-5"></span>
                    Pengaturan
                </button>
            </div>

            <!-- Modal for creating new queue -->
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
                            <p class="mb-4">Form untuk membuat antrian baru akan muncul di sini. Anda dapat memilih layanan yang tersedia dan menjadwalkan waktu kedatangan Anda.</p>
                            <div class="alert alert-info">
                                <span class="icon-[tabler--info-circle] size-4"></span>
                                Pastikan semua informasi diisi dengan benar untuk menghindari kesalahan.
                            </div>
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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dummy data for customer visits
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const shortMonths = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGS', 'SEP', 'OKT', 'NOV', 'DES'];
            const visits = [120, 150, 180, 200, 250, 300, 280, 320, 350, 400, 380, 420]; // Dummy data

            const options = {
                series: [{
                    name: 'Kunjungan',
                    data: visits
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false, // Default vertical
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: months, // Default long names
                    labels: {
                        rotate: 0
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Kunjungan'
                    }
                },
                colors: ['#3B82F6'],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + ' kunjungan';
                        }
                    }
                },
                responsive: [{
                    breakpoint: 768,
                    options: {
                        plotOptions: {
                            bar: {
                                horizontal: true // Horizontal on mobile
                            }
                        },
                        xaxis: {
                            categories: shortMonths, // Short names on mobile
                            labels: {
                                rotate: -45
                            }
                        }
                    }
                }]
            };

            const chart = new ApexCharts(document.querySelector("#customer-visit-chart"), options);
            chart.render();

            // Re-render on resize
            window.addEventListener('resize', function() {
                chart.updateOptions({
                    plotOptions: {
                        bar: {
                            horizontal: window.innerWidth >= 768 ? true : false
                        }
                    },
                    xaxis: {
                        categories: window.innerWidth >= 768 ? months : shortMonths,
                        labels: {
                            rotate: window.innerWidth >= 768 ? 0 : -45
                        }
                    }
                });
            });
        });
    </script>
</div>
