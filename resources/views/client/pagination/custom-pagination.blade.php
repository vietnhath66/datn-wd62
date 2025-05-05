@if ($paginator->hasPages())
    <div class="flex-c-m flex-w w-full p-t-38">

        @if ($paginator->onFirstPage())
            <span class="flex-c-m how-pagination1 trans-04 m-all-7 disabled" aria-disabled="true">
                <i class="fa fa-angle-left"></i>
            </span>
        @else
            <a class="flex-c-m how-pagination1 trans-04 m-all-7" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <i class="fa fa-angle-left"></i>
            </a>
        @endif


        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="flex-c-m how-pagination1 trans-04 m-all-7 disabled"
                    aria-disabled="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="flex-c-m how-pagination1 trans-04 m-all-7 active-pagination1"
                            href="{{ $url }}" aria-current="page">
                            {{ $page }}
                        </a>
                    @else
                        <a class="flex-c-m how-pagination1 trans-04 m-all-7" href="{{ $url }}">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="flex-c-m how-pagination1 trans-04 m-all-7" href="{{ $paginator->nextPageUrl() }}" rel="next">
                <i class="fa fa-angle-right"></i>
            </a>
        @else
            <span class="flex-c-m how-pagination1 trans-04 m-all-7 disabled" aria-disabled="true">
                <i class="fa fa-angle-right"></i>
            </span>
        @endif
    </div>
@endif
