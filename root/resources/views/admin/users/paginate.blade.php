@if($users->total() > 10)
    <div id="paginator_user" class="card-footer py-3">
        <ul class="pagination pagination-primary d-flex justify-content-center justify-content-end mb-0">
            <li class="page-item {{ ($users->currentPage() == 1) ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $users->url(1) }}"
                   aria-label="First">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item {{ ($users->currentPage() == 1) ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $users->url($users->currentPage() - 1) }}"
                   aria-label="Previous">
                    <span aria-hidden="true">&lsaquo;</span>
                </a>
            </li>
            @if($users->lastPage() > 0)
                @php
                    $dots = false;
                @endphp
                @for($page = 1; $page <= $users->lastPage(); $page++)
                    @if($page == 1 || $page == $users->lastPage() || abs($page - $users->currentPage()) <= 1)
                        @if($page == $users->currentPage())
                            <li class="page-item active">
                                <span class="page-link text-white">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $users->url($page) }}">{{ $page }}</a>
                            </li>
                        @endif
                        @php
                            $dots = false;
                        @endphp
                    @else
                        @if(!$dots && $page < $users->currentPage() - 1)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            @php
                                $dots = true;
                            @endphp
                        @endif
                        @if(!$dots && $page > $users->currentPage() + 1)
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

            <li class="page-item {{ ($users->currentPage() == $users->lastPage()) ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $users->url($users->currentPage() + 1) }}"
                   aria-label="Next">
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            </li>
            <li class="page-item {{ ($users->currentPage() == $users->lastPage()) ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $users->url($users->lastPage()) }}"
                   aria-label="Last">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <input type="hidden" id="currentPage" name="currentPage" value="{{ $users->currentPage() }}">
        </ul>
    </div>
@else
    <div id="paginator_user" class="card-footer py-2"></div>
@endif