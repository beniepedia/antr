<div class="max-w-xl mx-auto pt-19">
    <!-- Header -->
    <x-mobile-header title="Ambil Antrian" url="{{ route('customer.dashboard') }}" />

    <div class="px-3">
        <div class="bg-white rounded-xl shadow-md p-8">
            <div class="text-center mb-6">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="icon-[tabler--ticket] size-8 text-base-100"></span>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Ambil Tiket Antrian</h2>
                <p class="text-gray-600 mt-2">Pilih kendaraan dan jumlah liter yang dibutuhkan</p>
            </div>

            <form wire:submit.prevent="takeTicket" class="space-y-6">
                <div>
                    <label for="vehicle" class="label-text">Pilih Kendaraan Anda</label>
                    <select wire:model.live="selected_customer_vehicle_id" id="vehicle" class="select select-lg">
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach ($customerVehicles as $cv)
                            <option value="{{ $cv->id }}">{{ ucfirst($cv->vehicle->type ?? 'Kendaraan') }}
                                ({{ $cv->license_plate }})
                            </option>
                        @endforeach
                    </select>
                    @error('selected_customer_vehicle_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="liters" class="label-text">Jumlah Liter</label>
                    <input wire:model.live="liters_requested" type="number" id="liters" min="1"
                        class="input input-lg" placeholder="Masukkan jumlah liter">
                    <div class="helper-text">
                        Jumlah maksimal pengisian tidak boleh melebihi batas yang sudah ditentukan.
                    </div>
                    @error('liters_requested')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-full">Ambil Tiket</button>
            </form>

            @if ($customerVehicles->isEmpty())
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <p class="text-yellow-800 text-sm">Anda belum memiliki kendaraan terdaftar. <a
                            href="{{ route('customer.vehicles.create') }}" class="font-medium underline">Tambah
                            kendaraan</a> terlebih dahulu.</p>
                </div>
            @endif
        </div>
    </div>
</div>
