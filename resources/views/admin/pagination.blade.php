<style type="text/css">
    .activepagination{
            border-color: #6c757d;
            background-color: #6c757d;
            color: #fff;
            border-radius: 50%;
    }
</style>
@if ($paginator->hasPages())
    <div class="col-md-12 text-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="disabled btn btn-default pagination-button"><span>&laquo;</span></button>
        @else
            <a  href="{{ $paginator->previousPageUrl() }}" rel="prev"><button class="btn btn-default pagination-button">&laquo;</button></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <button  class="btn btn-default pagination-button disabled"><span>{{ $element }}</span></button>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="btn btn-default pagination-button activepagination"><span>{{ $page }}</span></button>
                    @else
                        <a  href="{{ $url }}"><button class="btn btn-default pagination-button">{{ $page }}</button></a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a  href="{{ $paginator->nextPageUrl() }}" rel="next"><button class="btn btn-default pagination-button">&raquo;</button></a>
        @else
            <button class="btn btn-default pagination-button disabled"><span>&raquo;</span></button>
        @endif
    </div>
@endif