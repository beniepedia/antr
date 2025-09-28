<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Ambil Tiket Antrean</h2>
            <p class="text-gray-600 mt-2">Pilih kendaraan dan jumlah liter yang dibutuhkan</p>
        </div>

        <form wire:submit="takeTicket" class="space-y-6">
            <div>
                <label for="vehicle" class="label-text">Pilih Kendaraan</label>
                <select wire:model.live="selected_vehicle_id" id="vehicle" class="select">
                    <option value="">-- Pilih Kendaraan --</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->type }} (Max: {{ $vehicle->max_liters }}L)</option>
                    @endforeach
                </select>
                @error('selected_vehicle_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="liters" class="label-text">Jumlah Liter</label>
                <input wire:model.live="liters_requested" type="number" id="liters" min="1" class="input" placeholder="Masukkan jumlah liter">
                @error('liters_requested') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary w-full">Ambil Tiket</button>
        </form>

        @if($vehicles->isEmpty())
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                <p class="text-yellow-800 text-sm">Anda belum memiliki kendaraan terdaftar. <a href="{{ route('customer.vehicles.create') }}" class="font-medium underline">Tambah kendaraan</a> terlebih dahulu.</p>
            </div>
        @endif
    </div>
</div>
