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
                        <tr>
                            <td>#ANTRIAN001</td>
                            <td>Pembuatan KTP</td>
                            <td>15 Mei 2025</td>
                            <td><span class="badge badge-success">Selesai</span></td>
                            <td>10:30 AM</td>
                        </tr>
                        <tr>
                            <td>#ANTRIAN002</td>
                            <td>Pembuatan SIM</td>
                            <td>16 Mei 2025</td>
                            <td><span class="badge badge-warning">Dalam Proses</span></td>
                            <td>14:00 PM</td>
                        </tr>
                        <tr>
                            <td>#ANTRIAN003</td>
                            <td>Paspor</td>
                            <td>17 Mei 2025</td>
                            <td><span class="badge badge-error">Dibatalkan</span></td>
                            <td>09:00 AM</td>
                        </tr>
                        <tr>
                            <td>#ANTRIAN004</td>
                            <td>Surat Nikah</td>
                            <td>18 Mei 2025</td>
                            <td><span class="badge badge-success">Selesai</span></td>
                            <td>11:00 AM</td>
                        </tr>
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
                    <button class="btn">Pembuatan KTP</button>
                    <button class="btn btn-primary">Pembuatan SIM</button>
                    <button class="btn btn-secondary">Paspor</button>
                    <button class="btn btn-accent">Surat Nikah</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-2.5">Status Antrian</h5>
                <div class="flex flex-wrap gap-2">
                    <span class="badge">Total: {{ $dashboardData['total_users'] }}</span>
                    <span class="badge badge-primary">Selesai</span>
                    <span class="badge badge-secondary">Dalam Proses</span>
                    <span class="badge badge-accent">Menunggu</span>
                    <span class="badge badge-warning">Ditunda</span>
                    <span class="badge badge-error">Dibatalkan</span>
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
