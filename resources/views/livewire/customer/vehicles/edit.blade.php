  <div class="relative max-w-xl mx-auto pt-19">
      <!-- Header -->
      <x-mobile-header title="Edit Kendaraan" url="{{ route('customer.vehicles.index') }}" />

      <!-- Form Card -->
      <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
          <form wire:submit="save" class="space-y-6">
              <!-- Vehicle Type -->
              <div>
                  <label for="vehicle_id" class="block text-sm font-medium text-gray-700 mb-2">Tipe Kendaraan</label>
                  <div class="select">
                      <span class="icon-[tabler--car] text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
                      <select wire:model="vehicle_id" id="vehicle_id" class="grow uppercase">
                          <option value="">Pilih tipe kendaraan</option>
                          @foreach ($vehicles as $vehicle)
                              <option value="{{ $vehicle->id }}">{{ ucwords($vehicle->type) }}</option>
                          @endforeach
                      </select>
                  </div>
                  @error('vehicle_id')
                      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              <!-- License Plate -->
              <div>
                  <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-2">Nomor Plat</label>
                  <div class="input">
                      <span class="icon-[tabler--license] text-base-content/80 my-auto me-3 size-5 shrink-0"></span>
                      <input wire:model="license_plate" type="text" id="license_plate" class="grow uppercase"
                          placeholder="Contoh: B 1234 ABC" />
                  </div>
                  @error('license_plate')
                      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                  @enderror
              </div>

              <!-- Submit Button -->
              <button type="submit" class="btn btn-primary w-full">
                  <span wire:loading class="loading loading-spinner"></span>
                  Update Kendaraan
              </button>
          </form>
      </div>
  </div>
