<div id="paginator_user" class="card-footer py-3">
    <ul class="pagination pagination-primary d-flex justify-content-center justify-content-end mb-0">
        <li class="page-item {{ ($books->currentPage() == 1) ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $books->url($books->currentPage() - 1) }}"
               aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        @if($books->lastPage() > 0)
            @php
                $dots = false;
            @endphp
            @for($page = 1; $page <= $books->lastPage(); $page++)
                @if($page == 1 || $page == $books->lastPage() || ($page >= $books->currentPage() - 1 && $page <= $books->currentPage() + 1))
                    @if($page == $books->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
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
                    @if(!$dots && ($page > 1 && $page < $books->lastPage()))
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
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</div>