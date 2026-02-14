@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            {{-- Previous Page Button (for Mobile) --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-light-grey border border-gray-300 cursor-default rounded-md">
                    &laquo; Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-dark-grey bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    &laquo; Previous
                </a>
            @endif
            {{-- Next Page Button (for Mobile) --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-dark-grey bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Next &raquo;
                </a>
            @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-light-grey border border-gray-300 cursor-default rounded-md">
                    Next &raquo;
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                {{-- Detail Halaman --}}
                <p class="text-sm text-gray-700 leading-5">
                    Showing
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                {{-- Pagination Links --}}
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            {{-- Tombol Ellipsis (Separator) --}}
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default">{{ $element }}</span>
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    {{-- TOMBOL AKTIF (GANTI WARNA DISINI) --}}
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-primary border border-primary cursor-default rounded-md">
                                            {{ $page }}
                                        </span>
                                    </span>
                                @else
                                    {{-- TOMBOL NON-AKTIF (GANTI WARNA DISINI) --}}
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-dark-grey bg-white border border-gray-300 hover:bg-light-grey">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </span>
            </div>
        </div>
    </nav>
@endif