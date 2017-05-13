@if ($paginator->hasPages())
    <ul>
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li><a href="#">Trang trước</a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Trang trước</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Trang sau</a></li>
        @else
            <li><a href="#">Trang sau</a></li>
        @endif
    </ul>
@endif
