<div id="paginator_user" class="card-footer py-3">
    <ul class="pagination pagination-primary d-flex justify-content-center justify-content-end mb-0">
        <li class="page-item {{ ($books->currentPage() == 1) ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $books->url(1) }}"
               aria-label="First">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item {{ ($books->currentPage() == 1) ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $books->url($books->currentPage() - 1) }}"
               aria-label="Previous">
                <span aria-hidden="true">&lsaquo;</span>
            </a>
        </li>
        @if($books->lastPage() > 0)
            @php
                $dots = false;
            @endphp
            @for($page = 1; $page <= $books->lastPage(); $page++)
                @if($page == 1 || $page == $books->lastPage() || abs($page - $books->currentPage()) <= 1)
                    @if($page == $books->currentPage())
                        <li class="page-item active">
                            <span class="page-link text-white">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $books->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                    @php
                        $dots = false;
                    @endphp
                @else
                    @if(!$dots && $page < $books->currentPage() - 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        @php
                            $dots = true;
                        @endphp
                    @endif
                    @if(!$dots && $page > $books->currentPage() + 1)
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

        <li class="page-item {{ ($books->currentPage() == $books->lastPage()) ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $books->url($books->currentPage() + 1) }}"
               aria-label="Next">
                <span aria-hidden="true">&rsaquo;</span>
            </a>
        </li>
        <li class="page-item {{ ($books->currentPage() == $books->lastPage()) ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $books->url($books->lastPage()) }}"
               aria-label="Last">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <input type="hidden" id="currentPage" name="currentPage" value="{{ $books->url($books->currentPage()) }}">
    </ul>
</div>
