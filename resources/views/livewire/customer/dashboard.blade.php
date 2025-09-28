<div class="relative max-w-2xl mx-auto">

    <!-- Welcome Header -->
    <div
        class="bg-gradient-to-r from-green-300 via-teal-300 to-cyan-300 rounded-b-3xl shadow-md px-6 py-9 mb-6 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h2 class="text-3xl font-bold mb-2">
                        @php
                            $hour = now()->hour;
                            $greeting =
                                $hour < 12
                                    ? 'Selamat Pagi'
                                    : ($hour < 15
                                        ? 'Selamat Siang'
                                        : ($hour < 18
                                            ? 'Selamat Sore'
                                            : 'Selamat Malam'));
                        @endphp
                        {{ $greeting }}
                    </h2>
                    <p class="text-2xl opacity-90 mb-1 font-bold">John Doe</p>
                    <p class="text-sm opacity-75">
                        {{ now()->locale('id')->dayName }}, {{ now()->format('d M Y') }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <!-- Notification Button -->
                    <div class="relative group">
                        <button
                            class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white/30 transition border border-white/30">
                            <span class="icon-[tabler--bell] size-6 text-white"></span>
                            <span
                                class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-white/10 rounded-full"></div>
    </div>
    <div class="relative  px-3">
        <!-- Combined Queue Card -->
        <div class="bg-base-100 rounded-2xl shadow-md p-8 mb-6 relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full -mr-16 -mt-16 opacity-20 animate-pulse">
            </div>
            <div class="relative z-10">
                <div class="flex items-start justify-between ">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Antrian Anda</p>
                        <p class="text-6xl font-extrabold text-purple-500 mt-2">
                            0010</p>
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="">
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium">ANTRIAN SAAT INI:</span>
                                    </div>
                                    <span class="text-2xl font-bold text-green-700">0001</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="flex-shrink-0 mt-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 gap-4 mb-8">
            <a href="{{ route('customer.queues.create') }}" wire:navigate
                class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-800">Ambil Tiket</p>
                <p class="text-xs text-gray-500 mt-1">Baru</p>
            </a>
            <a href="{{ route('customer.vehicles.index') }}" wire:navigate
                class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-lg transition duration-300 transform hover:-translate-y-1 block">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2">
                        </path>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-800">Kelola Kendaraan</p>
                <p class="text-xs text-gray-500 mt-1">Tambah & edit kendaraan</p>
            </a>
        </div>

        <!-- Announcements Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                        </path>
                    </svg>
                    Pengumuman
                </h3>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Terbaru</span>
            </div>
            <div class="space-y-3">
                <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                    <p class="text-sm font-medium text-gray-800">Sistem Antrean Online Sekarang Tersedia</p>
                    <p class="text-xs text-gray-600 mt-1">Nikmati kemudahan mengambil nomor antrean dari rumah. Update
                        terbaru telah dirilis dengan fitur notifikasi real-time.</p>
                </div>
                <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-800">Jadwal Operasional Diperpanjang</p>
                    <p class="text-xs text-gray-600 mt-1">Mulai minggu depan, layanan antrean akan beroperasi hingga
                        pukul 8 malam untuk melayani lebih banyak pelanggan.</p>
                </div>
            </div>
        </div>

        <!-- Queue History -->
        <div class="bg-white rounded-2xl shadow-xl border-0 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Riwayat Antrean</h3>
                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua</button>
            </div>
            <div class="space-y-4">
                <!-- Placeholder for history items -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white text-xs font-bold">01</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Antrean #001</p>
                            <p class="text-xs text-gray-500">26 Sep 2025 • 10:30 AM</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Selesai</span>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center mr-4">
                            <span class="text-white text-xs font-bold">02</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Antrean #002</p>
                            <p class="text-xs text-gray-500">25 Sep 2025 • 2:15 PM</p>
                        </div>
                    </div>
                    <span
                        class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Menunggu</span>
                </div>
            </div>
            <form method="POST" action="{{ route('customer.logout') }}">
                @csrf
                <button type="submit" class="btn btn-text btn-error btn-block h-11 justify-start px-3 font-normal">
                    <span class="icon-[tabler--logout] size-5 mr-3"></span>
                    Logout
                </button>
            </form>
        </div>

    </div>
</div>
