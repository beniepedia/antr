<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 px-4 py-6 pb-24">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-purple-200/30 to-pink-200/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-blue-200/30 to-cyan-200/30 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-md mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('customer.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-800">Tambah Kendaraan</h1>
            <div></div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
            <form wire:submit="save" class="space-y-6">
                <!-- Vehicle Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Kendaraan</label>
                    <select wire:model="vehicle_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih tipe kendaraan</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->type }} (Max {{ $vehicle->max_liters }}L)</option>
                        @endforeach
                    </select>
                    @error('vehicle_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- License Plate -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Plat</label>
                    <input type="text" wire:model="license_plate" placeholder="Contoh: B 1234 ABC"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent uppercase">
                    @error('license_plate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-xl font-medium hover:shadow-lg transition duration-300 transform hover:-translate-y-0.5">
                    Tambah Kendaraan
                </button>
            </form>
        </div>
    </div>
</div>