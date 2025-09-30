  <!-- Bottom Navigation -->
  <div class="fixed bottom-3 left-3 right-3 bg-white/80 backdrop-blur-md shadow z-30 rounded-xl">
      <div class="flex justify-around items-center py-4 relative">
          <a href="{{ route('customer.dashboard') }}" class="flex flex-col items-center" wire:current="text-primary"
              wire:navigate>
              <svg class="w-7 h-7 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                  </path>
              </svg>
              <span class="text-xs font-medium">Beranda</span>
          </a>
          <a href="{{ route('customer.queues.index') }}"
              class="flex flex-col items-center text-gray-500 hover:text-blue-600" wire:navigate>
              <svg class="w-7 h-7 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                  </path>
              </svg>
              <span class="text-xs font-medium">Antrian Saya</span>
          </a>
          <a href="#" class="flex flex-col items-center text-gray-500 hover:text-blue-600">
              <svg class="w-7 h-7 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-xs font-medium">Riwayat</span>
          </a>
          <a href="{{ route('customer.profile') }}" class="flex flex-col items-center text-gray-500 hover:text-blue-600"
              wire:navigate>
              <span class="icon-[tabler--user] size-7 mb-1"></span>
              <span class="text-xs font-medium">Profil</span>
          </a>
      </div>
  </div>
