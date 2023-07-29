@foreach ($reflections as $reflection)
    <div class="row p-5 pt-5 border-bottom">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-4 icon icon-lg icon-shape bg-secondary shadow-success text-center rounded-circle">
                    <i class="material-icons opacity-10">person</i>
                </div>
                <div class="col-lg-8 pt-2">
                    <div class="row">
                        <div class="col-lg-12">
                             <div class="col-lg-12">
                                @if($reflection->is_hidden == config('constants.USER_NAME_HIDDEN_FALSE') || empty($reflection->users))
                                    <span class="text-dark">Người dùng ẩn danh</span>
                                @else
                                    <span class="text-dark">{{ $reflection->users->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-8 d-flex pb-3 fs-5">
                    @switch($reflection->vote)
                    @case(1)
                        <span class="text-dark">Rất không hài lòng</span>
                        @break
                    @case(2)
                        <span class="text-dark">Không hài lòng</span>
                        @break
                    @case(3)
                        <span class="text-dark">Bình thường</span>
                        @break
                    @case(4)
                        <span class="text-dark">Hài lòng</span>
                        @break
                    @default
                        <span class="text-dark">Cực kì hài lòng</span>
                    @endswitch
                    <div class="small text-warning ms-2">
                        @for ($i = 0; $i < $reflection->vote; $i++)
                            <div class="fa fa-star"></div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="reflection-content d-block">
                <p class="fs-5">
                    {{ $reflection->content }}
                </p>
            </div>
            <div class="d-flex justify-content-between">
                <div class="p-2 border border-info rounded-3" role="button">
                    <span class=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Hữu ích
                        (5)</span>
                </div>
                @auth
                    @if (auth()->user()->id == $reflection->user_id)
                        <div class="p-2 px-3 border border-danger rounded-3 link-vote ms-3" role="button" data-bs-toggle="modal" id="btnEditReflection"
                            data-action="{{ route('book.reflection.edit', ['reflection_id' => $reflection->id]) }}"
                            data-id="{{ $reflection->id }}"
                            onclick="getData({{ $reflection->id }})"
                            data-action-update="{{ route('book.reflection.update', ['reflection_id' => $reflection->id]) }}">
                            <span class=""><i class="fa fa-edit" aria-hidden="true"></i></span>
                        </div>
                    @endif
                @endauth
                <div class="p-2 text-dark">
                    <span>Được gửi vào: {{ date_format($reflection->updated_at, 'H:i:s d-m-Y') }}</span>
                </div>
            </div>
        </div>
    </div>
@endforeach
@if (count($reflections) > 0)
    @include('users.books.paginate')
@else
    @include('users.books.reflections_not_found')
@endif
