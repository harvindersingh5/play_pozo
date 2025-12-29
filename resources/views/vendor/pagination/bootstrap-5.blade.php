@if ($paginator->hasPages())
    <nav>
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a></li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $window = 3; // Number of links to show on each side of the current page
            @endphp

            @if ($currentPage > $window + 1)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            @foreach (range(1, $lastPage) as $page)
                @if ($page == 1 || $page == $lastPage || ($page >= $currentPage - $window && $page <= $currentPage + $window))
                    <li class="page-item {{ $page == $currentPage ? 'active' : '' }}" aria-current="{{ $page == $currentPage ? 'page' : null }}">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @elseif (($page == $currentPage - ($window + 1) && $page > 1) || ($page == $currentPage + ($window + 1) && $page < $lastPage))
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endforeach

            @if ($currentPage < $lastPage - $window)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
@endif