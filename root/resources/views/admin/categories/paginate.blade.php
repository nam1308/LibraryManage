<ul class="pagination pagination-primary d-flex justify-content-center justify-content-end mb-0">
    <li class="page-item {{ ($categories->currentPage() == 1) ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $categories->url(1) }}"
            aria-label="First">
            <span aria-hidden="true">&laquo;</span>
        </a>
    </li>
    <li class="page-item {{ ($categories->currentPage() == 1) ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $categories->url($categories->currentPage() - 1) }}"
            aria-label="Previous">
            <span aria-hidden="true">&lsaquo;</span>
        </a>
    </li>
    @if($categories->lastPage() > 0)
        @php
            $dots = false;
        @endphp
        @for($page = 1; $page <= $categories->lastPage(); $page++)
            @if($page == 1 || $page == $categories->lastPage() || abs($page - $categories->currentPage()) <= 1)
                @if($page == $categories->currentPage())
                    <li class="page-item active">
                        <span class="page-link text-white">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $categories->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
                @php
                    $dots = false;
                @endphp
            @else
                @if(!$dots && $page < $categories->currentPage() - 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    @php
                        $dots = true;
                    @endphp
                @endif
                @if(!$dots && $page > $categories->currentPage() + 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    @php
                        $dots = true;
                    @endphp
                @endif
            @endif
        @endfor
    @endif

    <li class="page-item {{ ($categories->currentPage() == $categories->lastPage()) ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $categories->url($categories->currentPage() + 1) }}"
            aria-label="Next">
            <span aria-hidden="true">&rsaquo;</span>
        </a>
    </li>
    <li class="page-item {{ ($categories->currentPage() == $categories->lastPage()) ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $categories->url($categories->lastPage()) }}"
            aria-label="Last">
            <span aria-hidden="true">&raquo;</span>
        </a>
    </li>
</ul>
