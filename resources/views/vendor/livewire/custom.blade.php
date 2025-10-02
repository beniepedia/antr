@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-y-2">

        {{-- Kiri: Info Jumlah item --}}
        <div class="text-sm text-gray-700 dark:text-gray-400">
            <span>{!! __('Showing') !!}</span>
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            <span>{!! __('to') !!}</span>
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            <span>{!! __('of') !!}</span>
            <span class="font-medium">{{ $paginator->total() }}</span>
            <span>{!! __('results') !!}</span>
        </div>

        {{-- Kanan: FlyonUI Pagination --}}
        <div class="flex justify-end w-full sm:w-auto">

            {{-- Mobile: Previous / Current Input / Next --}}
            <div class="flex flex-1 justify-between sm:hidden items-center gap-x-2">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <button type="button" class="btn btn-soft btn-square" disabled aria-label="Previous Button">
                        <span class="icon-[tabler--chevron-left] size-5 rtl:rotate-180"></span>
                    </button>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        class="btn btn-soft btn-square" aria-label="Previous Button">
                        <span class="icon-[tabler--chevron-left] size-5 rtl:rotate-180"></span>
                    </button>
                @endif

                {{-- Current Page Input --}}
                <input type="number" min="1" max="{{ $paginator->lastPage() }}"
                    wire:keydown.enter="gotoPage($event.target.value)" class="input text-center"
                    value="{{ $paginator->currentPage() }}" disabled>

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        class="btn btn-soft btn-square" aria-label="Next Button">
                        <span class="icon-[tabler--chevron-right] size-5 rtl:rotate-180"></span>
                    </button>
                @else
                    <button type="button" class="btn btn-soft btn-square" disabled aria-label="Next Button">
                        <span class="icon-[tabler--chevron-right] size-5 rtl:rotate-180"></span>
                    </button>
                @endif
            </div>

            {{-- Desktop: full pagination --}}
            <div class="hidden sm:flex join">
                @if ($paginator->onFirstPage())
                    <button type="button" class="btn btn-soft btn-square join-item" disabled
                        aria-label="Previous Button">
                        <span class="icon-[tabler--chevron-left] size-5 rtl:rotate-180"></span>
                    </button>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        class="btn btn-soft btn-square join-item" aria-label="Previous Button">
                        <span class="icon-[tabler--chevron-left] size-5 rtl:rotate-180"></span>
                    </button>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="btn btn-soft btn-square join-item disabled">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <button type="button" aria-current="page"
                                    class="btn btn-soft join-item btn-square aria-[current='page']:text-bg-soft-primary">
                                    {{ $page }}
                                </button>
                            @else
                                <button type="button"
                                    wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    class="btn btn-soft join-item btn-square">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        class="btn btn-soft btn-square join-item" aria-label="Next Button">
                        <span class="icon-[tabler--chevron-right] size-5 rtl:rotate-180"></span>
                    </button>
                @else
                    <button type="button" class="btn btn-soft btn-square join-item" disabled aria-label="Next Button">
                        <span class="icon-[tabler--chevron-right] size-5 rtl:rotate-180"></span>
                    </button>
                @endif
            </div>

        </div>
    </div>
@endif
