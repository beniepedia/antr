@props([
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin?',
    'method' => 'delete',
    'confirmText' => 'Ya',
    'type' => 'danger', // danger | warning | success
])

@php
    $colors = [
        'danger' => ['bg' => 'bg-red-100', 'icon' => 'text-red-600', 'btn' => 'bg-red-600 hover:bg-red-700'],
        'warning' => [
            'bg' => 'bg-yellow-100',
            'icon' => 'text-yellow-600',
            'btn' => 'bg-yellow-500 hover:bg-yellow-600',
        ],
        'success' => ['bg' => 'bg-green-100', 'icon' => 'text-green-600', 'btn' => 'bg-green-600 hover:bg-green-700'],
    ];
    $c = $colors[$type] ?? $colors['danger'];
@endphp

<div x-data="{
    show: false,
    id: null,
    confirmAction(itemId) {
        this.id = itemId;
        this.show = true;
    }
}" @open-confirmation.window="confirmAction($event.detail.id)">
    <template x-if="show">
        <!-- Backdrop -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-show="show"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <!-- Modal -->
            <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-xl p-6 text-center relative" x-show="show"
                x-transition:enter="transition ease-out duration-200 transform"
                x-transition:enter-start="scale-90 opacity-0" x-transition:enter-end="scale-100 opacity-100"
                x-transition:leave="transition ease-in duration-150 transform"
                x-transition:leave-start="scale-100 opacity-100" x-transition:leave-end="scale-90 opacity-0">
                <!-- Ikon -->
                <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-full {{ $c['bg'] }} mb-4">
                    <span class="icon-[tabler--alert-triangle] {{ $c['icon'] }} size-10"></span>
                </div>

                <!-- Judul -->
                <h2 class="text-xl font-bold text-gray-800 mb-2">
                    {{ $title }}
                </h2>

                <!-- Pesan -->
                <p class="text-gray-600 mb-6">
                    {{ $message }}
                </p>

                <!-- Tombol -->
                <div class="flex justify-center gap-3">
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                        @click="show = false">Batal</button>

                    <button class="px-4 py-2 text-white rounded-lg transition shadow-sm {{ $c['btn'] }}"
                        @click="$wire.call('{{ $method }}', id); show = false">{{ $confirmText }}</button>
                </div>

                <!-- Tombol close pojok kanan -->
                <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-600" @click="show = false">
                    <span class="icon-[tabler--x] size-5"></span>
                </button>
            </div>
        </div>
    </template>
</div>
