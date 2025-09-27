<div> <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div
            class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-purple-200/30 to-pink-200/30 rounded-full blur-3xl">
        </div>
        <div
            class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-blue-200/30 to-cyan-200/30 rounded-full blur-3xl">
        </div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-indigo-100/20 to-purple-100/20 rounded-full blur-3xl">
        </div>
    </div>
    <div class="relative z-10">
        <!-- Header -->
        <div class="flex items-center justify-end mb-6">
            <!-- Notification Dropdown -->
            <div class="relative group">
                <button
                    class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:shadow-lg transition">
                    <span class="icon-[tabler--bell] size-5 text-gray-600"></span>
                </button>

                <!-- Dropdown -->
                <div
                    class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-800">Notifikasi</h3>
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition">
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Antrian #001 telah dipanggil</p>
                                    <p class="text-xs text-gray-500 mt-1">2 menit yang lalu</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition">
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Antrian Anda telah selesai</p>
                                    <p class="text-xs text-gray-500 mt-1">1 jam yang lalu</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Pengingat: Antrian dalam 30 menit</p>
                                    <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-t border-gray-200 text-center">
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua
                            Notifikasi</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-4 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <div>
                        <h2 class="text-lg text-gray-800 flex items-center">
                            Selamat Datang! 👋
                        </h2>
                        <p class="text-xl font-semibold text-gray-700 mt-1">John Doe</p>
                    </div>
                </div>
                <div class="md:block">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Queue Card -->
        <div class="bg-white rounded-2xl shadow border-0 p-8 mb-6 relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full -mr-16 -mt-16 opacity-20">
            </div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Antrian Anda </p>
                        <p
                            class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mt-2">
                            #20</p>
                    </div>
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="badge badge-soft badge-warning badge-lg">Menunggu</span>
                </div>
            </div>
        </div>

        <!-- Current Queue Card -->
        <div class="bg-white rounded-2xl shadow border-0 p-6 mb-6 relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-400 to-blue-500 rounded-full -mr-12 -mt-12 opacity-20">
            </div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Antrian Saat Ini</p>
                        <p
                            class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 mt-2">
                            #1</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                            </path>
                        </svg>
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
            <div class="bg-white rounded-xl shadow-md p-6 text-center">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-800">Statistik</p>
                <p class="text-xs text-gray-500 mt-1">Lihat data</p>
            </div>
        </div>

        <!-- Announcements Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
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
