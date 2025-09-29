<div class="relative max-w-4xl mx-auto">
    <!-- Header -->
    <x-mobile-header title="Antrean Saya" url="{{ route('customer.dashboard') }}" />

    <!-- Queues List -->
    @if ($queues->count() > 0)
        <div class="grid grid-cols-2 gap-4 px-3">
            @foreach ($queues as $queue)
                <div
                    class="bg-white/90 backdrop-blur-sm rounded-lg shadow-md border border-white/20 p-4 hover:shadow-lg transition-shadow">
                    <div class="text-center mb-4">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-300 to-blue-400 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-white font-bold text-xl">{{ $queue->queue_number }}</span>
                        </div>
                        <p class="text-lg font-semibold text-gray-800">{{ strtoupper($queue->license_plate ?? 'Nomor Plat') }}</p>
                        <p class="text-sm text-gray-600">{{ $queue->customerVehicle->vehicle->type ?? 'Kendaraan' }} - {{ strtoupper($queue->license_plate ?? '') }}</p>
                        <p class="text-sm text-gray-500">{{ $queue->queue_date->format('d M Y') }}</p>
                    </div>
                    <div class="text-center">
                        <span
                            class="px-2 py-1 rounded-full text-xs font-medium inline-block mb-2
                            @if ($queue->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($queue->status == 'served') bg-green-100 text-green-800
                            @elseif($queue->status == 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($queue->status) }}
                        </span>
                        @if ($queue->checkin_time)
                            <span class="text-xs text-gray-500 block mb-2">Check-in:
                                {{ $queue->checkin_time->format('H:i') }}</span>
                        @endif
                        <button class="text-blue-500 hover:text-blue-700 text-sm"
                            onclick="toggleDetails({{ $queue->id }})">
                            Lihat Detail ▼
                        </button>
                        <div id="details-{{ $queue->id }}" class="hidden mt-2 text-left">
                            <p class="text-xs text-gray-600">Litur yang diminta:
                                {{ $queue->liters_requested ?? 'N/A' }} L</p>
                            @if ($queue->checkout_time)
                                <p class="text-xs text-gray-600">Check-out: {{ $queue->checkout_time->format('H:i') }}
                                </p>
                            @endif
                            @if ($queue->servedBy)
                                <p class="text-xs text-gray-600">Dilayani oleh: {{ $queue->servedBy->name ?? 'N/A' }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center flex flex-col items-center min-vh-100 py-19 px-2">
            <div class="mx-auto mb-10">
                <span class="icon-[tabler--clock] size-18 text-grey-50"></span>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada antrian</h3>
            <p class="text-gray-600 mb-6">Buat antrian untuk mendapatkan nomor antrian</p>
            <a href="{{ route('customer.queues.create') }}" class="btn btn-primary">
                <span class="icon-[tabler--plus] size-4.5 mr-2"></span>
                Buat Antrian
            </a>
        </div>
    @endif

    <x-fab-add :route="route('customer.queues.create')" />

    <script>
        function toggleDetails(id) {
            const details = document.getElementById('details-' + id);
            details.classList.toggle('hidden');
        }
    </script>
</div>
