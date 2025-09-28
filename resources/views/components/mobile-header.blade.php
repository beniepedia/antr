@props([
    'title' => '',
    'url' => '#',
])

<div class="flex items-center gap-6 mb-8 mt-6 px-3">
    <a href="{{ $url }}" class="text-blue-600 hover:text-blue-800" wire:navigate>
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </a>
    <h1 class="text-xl font-semibold absolute left-1/2 transform -translate-x-1/2">{{ $title }}
    </h1>
</div>
