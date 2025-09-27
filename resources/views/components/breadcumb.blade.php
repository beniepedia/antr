@props(['links' => []])

<div class="breadcrumbs">
    <ul class="">
        @foreach ($links as $link)
            @if (!@$loop->last)
                <li>
                    <a href="{{ $link['url'] }}">
                        {{ $link['label'] }}
                    </a>
                </li>
                <li class="breadcrumbs-separator rtl:-rotate-[40deg]">/</li>
            @else
                <li aria-current="page"> {{ $link['label'] }}</li>
            @endif
        @endforeach
    </ul>
</div>
