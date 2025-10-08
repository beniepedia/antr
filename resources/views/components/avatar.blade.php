@props(['size' => '10'])

<div
    class="flex items-center justify-center rounded-full text-white font-semibold uppercase {{ $color() }} w-{{ $size }} h-{{ $size }}">
    <span class="text-sm">{{ $initial() }}</span>
</div>
