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
                  <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6">
                      <div class="flex items-center justify-between">
                          <div class="flex items-center">
                              <div
                                  class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-4">
                                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                      viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2">
                                      </path>
                                  </svg>
                              </div>
                              <div>
                                  <p class="text-lg font-semibold text-gray-800">{{ $vehicle->type }}</p>
                                  <p class="text-sm text-gray-600">Plat: {{ $vehicle->pivot->license_plate }}</p>
                                  <p class="text-xs text-gray-500">Kapasitas: {{ $vehicle->max_liters }}L</p>
                              </div>
                          </div>
                          <div class="flex space-x-2">
                              <button class="text-gray-400 hover:text-gray-600">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                      </path>
                                  </svg>
                              </button>
                              <button class="text-red-400 hover:text-red-600">
                                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                      </path>
                                  </svg>
                              </button>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
      @else
          <!-- Empty State -->
          <div class="text-center bg-amber-100">
              <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2">
                      </path>
                  </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada kendaraan</h3>
              <p class="text-gray-600 mb-6">Tambahkan kendaraan Anda untuk memudahkan proses antrean</p>
              <a href="{{ route('customer.vehicles.create') }}"
                  class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                  Tambah Kendaraan Pertama
              </a>
          </div>
      @endif
  </div>
