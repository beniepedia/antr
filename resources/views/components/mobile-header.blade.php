@props([
    'title' => '',
    'url' => '',
])

<div class="fixed top-0 left-0 right-0 z-50 flex items-center gap-6 px-3 h-14 bg-base-100 shadow-sm">
    @if ($url)
        <!-- Tombol Back -->
        <a href="{{ $url }}" class="text-blue-600 hover:text-blue-800" wire:navigate>
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
    @endif
    <!-- Judul -->
    <h1 class="flex-1 text-center text-xl font-semibold">
        {{ $title }}
    </h1>


</div>
