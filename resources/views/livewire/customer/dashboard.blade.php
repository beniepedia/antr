<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 px-4 py-6 pb-24">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Selamat datang, John Doe</h2>
            <p class="text-xs text-gray-600">Kelola antrian Anda hari ini</p>
        </div>
        <!-- Notification Dropdown -->
        <div class="relative group">
            <button
                class="w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:shadow-lg transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.5 4.5a1 1 0 011 1v3.586l2.707 2.707a1 1 0 01-1.414 1.414l-3-3A1 1 0 0110.5 8V5.5a1 1 0 011-1zm0 6a3.5 3.5 0 100 7 3.5 3.5 0 000-7z">
                    </path>
                </svg>
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

    <!-- Active Queue Card -->
    <div class="bg-white rounded-2xl shadow-xl border-0 p-8 mb-8 relative overflow-hidden">
        <div
            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full -mr-16 -mt-16 opacity-20">
        </div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Nomor Antrean Aktif</p>
                    <p
                        class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mt-2">
                        —</p>
                </div>
                <div
                    class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Status: Tidak ada antrean aktif
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
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Menunggu</span>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg">
        <div class="flex justify-around items-center py-3 px-4 relative">
            <a href="#" class="flex flex-col items-center text-blue-600">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span class="text-xs font-medium">Beranda</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-500 hover:text-blue-600">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
                <span class="text-xs font-medium">Antrian Saya</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-500 hover:text-blue-600">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs font-medium">Riwayat</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-500 hover:text-blue-600">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs font-medium">Profil</span>
            </a>
        </div>
    </div>
</div>
