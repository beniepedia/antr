  <div class="relative max-w-2xl mx-auto">

      <!-- Header -->
      <div class="flex items-center justify-start gap-6 mb-6">
          <a href="{{ route('customer.dashboard') }}" class="text-blue-600 hover:text-blue-800">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
          </a>
          <h1 class="text-xl font-bold text-gray-800">Kendaraan Saya</h1>
      </div>

      <!-- Vehicles List -->
      @if ($vehicles->count() > 0)
          <div class="space-y-4">
              @foreach ($vehicles as $vehicle)
                  <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 px-3 py-4">
                      <div class="flex items-center justify-between">
                          <div class="flex items-center">
                              <div
                                  class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-4">
                                  <span class="icon-[tabler--car] text-white size-6"></span>
                              </div>
                              <div>
                                  <p class="text-lg font-semibold text-gray-800">
                                      {{ strtoupper($vehicle->pivot->license_plate) }}
                                  </p>
                                  <p class="text-sm text-gray-600">{{ ucfirst($vehicle->type) }}</p>
                              </div>
                          </div>

                          <div class="flex space-x-2">
                              <a href="{{ route('customer.vehicles.edit', $vehicle->pivot->id) }}"
                                  class="text-gray-400 hover:text-gray-600">
                                  <span class="icon-[tabler--edit] size-5"></span>
                              </a>
                              <button class="text-red-400 hover:text-red-600">
                                  <span class="icon-[tabler--trash] size-5"></span>
                              </button>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
      @else
          <!-- Empty State -->
          <div class="text-center flex flex-col items-center  min-vh-100 py-19 px-2">
              <div class="mx-auto mb-10">
                  <span class="icon-[tabler--carousel-horizontal] size-18 text-grey-50"></span>
              </div>
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada kendaraan</h3>
              <p class="text-gray-600 mb-6">Tambahkan kendaraan Anda untuk memudahkan proses antrean</p>
              <a href="{{ route('customer.vehicles.create') }}" class="btn btn-primary">
                  <span class="icon-[tabler--plus] size-4.5 mr-2"></span>
                  Tambah Kendaraan
              </a>
          </div>
      @endif

      <x-fab-add :route="route('customer.vehicles.create')" />
  </div>
