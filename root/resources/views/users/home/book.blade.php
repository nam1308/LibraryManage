<div class="container">
    <div class="row">
  
        <style>
            .product {
                position: relative;
            }

            .product-new-tag {
                position: absolute;
                top: 10px;
                left: 10px;
                background-color: #ff0000;
                color: #fff;
                padding: 5px;
                font-weight: bold;
                border-radius: 3px;
                z-index: 1;
            }

            .zoom a {
                transition: transform 0.5s ease;
            }

            .zoom:hover a {
                transform: scale(1.05);
            }
            .zoom a img {
                width: 100%;
                height: 70%;
            }
        </style>

        @if(count($books) > 0)
                @foreach($books as $book)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-6 zoom">
                        <a href="{{URL::to('book/details/'.$book->id)}}" class="card p-4" style="height: 400px; cursor: pointer;">
                            <img src="{{ asset('storage/'.$book->image) }}" style="object-fit: scale-down;">
                            @if(now()->diffInDays($book->created_at) < config('constants.DEFAULT_NEW_BOOK'))
                                <span class="product-new-tag">New</span>
                            @endif 
                            
                            <div class="mt-1 d-flex" style="font-weight: 400; font-size: 13px; color:#727272">
                                
                                @if($book->quantity > config('constants.DEFAULT_MIN_NUMBER')  && ($book->quantity - $book->borrowers_count) > config('constants.DEFAULT_MIN_NUMBER'))                  
                                    Số lượng còn: <div style="font-weight: 500 !important; font-size: 14px !important; color:#828282; padding:0 5px 0 5px;">
                                        {{$book->quantity - $book->borrowers_count}}
                                    </div> quyển
                                @else
                                    <div class="" style="color: red; font-weight: 500; font-size: 14px">
                                        Tạm thời chưa có sách 
                                    </div>
                                @endif
                                
                            </div>

                            <div class="d-flex" style="font-weight: 400; font-size: 13px; color:#727272">
                                @if(count($book->borrowers) > config('constants.DEFAULT_MAX_NUMBER'))
                                    Có : <div style="font-weight: 500 !important; font-size: 14px !important; color:#828282; padding:0 5px 0 5px;">
                                        100+ 
                                    </div> lượt xem
                                @else
                                    Có : <div style="font-weight: 500 !important; font-size: 14px !important; color:#828282; padding:0 5px 0 5px;">
                                        {{ count($book->borrowers) }}
                                    </div> lượt xem 
                                @endif
                            </div>
                            <div class="m-1">
                                <div style="font-weight: 500">
                                    {{Illuminate\Support\Str::limit($book->name, $limit = 20, $end = '...')}} - {{Illuminate\Support\Str::limit($book->author, $limit = 20, $end = '...')}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
        @else
            <h3 class="text-center m4">Không có dữ liệu</h3>
        @endif
    </div>

    @if(count($books) > 0 && $books->lastPage() > 1)
        @include('users.home.paginate')
    @endif
</div>