@extends('users.layout.master')
@section('content')
    @include('users.navbar.navbar', ['user' => $book->name])
    <section>
        <div class="container px-4 px-lg-5 my-5">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="display-5 fw-normal">{{ $book->name }}</h1>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 align-items-center ms-3">
                <div class="col-md-4 position-relative">
                    <img class="card-img-top mb-5 mb-md-0 w-100" src="{{ asset('storage/' . $book->image) }}" alt="...">
                    @if ($checkNewBook < config('constants.DEFAULT_NEW_BOOK'))
                        <span class="badge bg-danger text-white position-absolute"
                            style="top: 0.5rem; right: 0.5rem">New</span>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="fs-6">Tác giả: <span class="text-success">{{ $book->author }}</span></div>
                    <div class="fs-6 mb-3">Thể loại:
                        <span class="text-success">
                           {{ $cateToShow }}
                        </span>
                    </div>
                    <div class="fs-5">
                        <div class="fs-6">
                            <span class="text-dark">Số lượng sách đang còn <span
                                    class="text-success">{{ $book->quantity - $book->borrowers_count}}</span> cuốn.</span>
                        </div>
                    </div>
                    <div class="fs-5 mb-3 d-flex">
                        <!-- Product reviews-->
                        <div class="small text-warning me-2">
                            <div class="fa fa-star"></div>
                            <div class="fa fa-star"></div>
                            <div class="fa fa-star"></div>
                            <div class="fa fa-star"></div>
                            <div class="fa fa-star"></div>
                        </div>
                        <div class="small me-2"><span style="font-weight: bold;">({{ $reflectionTotal }} Nhận xét)</span></div>
                        <div class="small " style="border-left: 2px solid #344767">
                            <span class="ms-2 small">Đã mượn {{ $totalBorrow }}+</span>
                        </div>
                    </div>
                    <p class="lead">{{ $book->description }}</p>
                    <div class="row mt-6">
                        <div class="col-md-4">
                            <a href="{{ route('home') }}">
                                <button class="btn btn-warning flex-shrink-0 w-100" type="button">
                                    Quay lại
                                </button>
                            </a>
                        </div>
                        @if ($checkBookBorrowing)
                            <div class="col-md-4">
                                <button class="btn flex-shrink-0 btn-primary w-100" data-bs-toggle="modal"
                                    data-bs-target="#returnBookModal" type="button">
                                    Trả sách
                                </button>
                                @include('users.books.return_modal')
                            </div>
                            <div class="col-md-4">
                                <button class="btn flex-shrink-0 btn-primary w-100" type="button" data-bs-toggle="modal"
                                    data-bs-target="#bookRenewal">
                                    Gia hạn
                                </button>
                            </div>
                            @include('users.books.renewal_modal')
                        @else
                            @if($book->quantity > config('constants.DEFAULT_MIN_NUMBER')  && ($book->quantity - $book->borrowers_count) > config('constants.DEFAULT_MIN_NUMBER'))
                                <div class="col-md-4">
                                    <button class="btn flex-shrink-0 btn-primary w-100" type="button"
                                        data-book-id="{{ $book->id }}" type="button" data-bs-toggle="modal"
                                        data-bs-target="#btnBorrow" data-bs-whatever="@mdo">
                                        Mượn sách
                                    </button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Borrrow Book -->
        @include('users.books.borrow_modal')
    </section>
    <section>
        <style>
            .link-vote:hover {
                background: #e91e63;
                border: 0px solid;
                border-radius: 10px;
                color: white;
            }
            .link-vote.active{
                background: #e91e63;
                border: 0px solid;
                border-radius: 10px;
                color: white;
            }
            .link-vote{
                border: 0px solid;
                border-radius: 10px;
            }
            .review-btn.heart-hover {
                background-color: #f8d7da;
            }
            .review-btn.heart-hover .heart-icon {
                color: red;
            }
            .link-vote.active span i {
                color: #ffc107;
            }
        </style>
        <div class="container border-bottom mt-6">
            <div class="d-flex ">
                <div class="fs-4 p-2 text-dark">Đánh Giá - Nhận Xét Từ Khách Hàng</div>
                <div class=" p-2 ms-auto">
                    @auth
                        <div class="d-flex" data-bs-toggle="modal" data-bs-target="#reflectionModal">
                            <button class="btn btn-lg btn-outline-secondary rounded-pill me-3 font-weight-bold review-btn" type="button">
                                THÊM PHẢN HỒI
                            <span class="heart-icon"><i class="fas fa-heart"></i></span>
                            </button>
                        </div>
                    @endauth
                </div>
            </div>
            <div class="row d-flex px-3">
                <div class="col-lg-3 text-center border-end">
                    
                    <div>
                        <span class="product-rating fs-1">{{ $avgStar }}</span><span>/5 
                            <i class="fa fa-star stars fs-5 text-warning"></i></span>
                    </div>
                    <div class="rating-text">
                        <span>{{ $reflectionTotal }} Nhận xét</span>
                    </div>
                </div>
                <div class=" py-5 col-lg-9">
                    <div id="paginator_user" class="d-flex d-flex-row row fs-4 align-items-center text-center">
                        <div class="item-filter px-2 border-end col-lg-2 ">
                            <a class="nav-link link-vote mb-0 px-0 py-1 active" data-vote="all" data-bs-toggle="tab"
                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                aria-selected="false">
                                <span class="p-1">Tất cả</span>
                            </a>
                        </div>

                        <div class="item-filter px-2 border-end col-lg-2">
                            <a class="nav-link link-vote mb-0 px-0 py-1" data-vote="1" data-bs-toggle="tab"
                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                aria-selected="false">
                                <span class="p-1">1</span>
                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                            </a>
                        </div>

                        <div class="item-filter px-2 border-end col-lg-2" role="button">
                            <a class="nav-link link-vote mb-0 px-0 py-1" data-vote="2" data-bs-toggle="tab"
                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                aria-selected="false">
                                <span class="p-1">2</span>
                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                            </a>
                        </div>

                        <div class="item-filter px-2 border-end col-lg-2" role="button">
                            <a class="nav-link link-vote mb-0 px-0 py-1" data-vote="3" data-bs-toggle="tab"
                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                aria-selected="false">
                                <span class="p-1">3</span>
                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                            </a>
                        </div>

                        <div class="item-filter px-2 border-end col-lg-2" role="button">
                            <a class="nav-link link-vote mb-0 px-0 py-1" data-vote="4" data-bs-toggle="tab"
                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                aria-selected="false">
                                <span class="p-1">4</span>
                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                            </a>
                        </div>

                        <div class="item-filter px-2 border-end col-lg-2" role="button">
                            <a class="nav-link link-vote mb-0 px-0 py-1" data-vote="5" data-bs-toggle="tab"
                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                aria-selected="false">
                                <span class="p-1">5</span>
                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="route-data" class="d-none" data-url="{{ route('book.details', $book->id) }}"></div>
        <div id="table-reflections">
            @include('users.books.show_reflection')
        </div>
    </section>
{{-- Modal-Reflection --}}
@include('users.books.reflection_modal')
{{-- Edit-Modal-Reflection --}}
@include('users.books.edit_reflection_modal')
@endsection
@auth
    @push('js')

    <script>
        $(document).ready(function() {

            $('a.link-vote').on('click', function(e) {
                e.preventDefault();
                $('a.link-vote').removeClass("active");
                $(this).addClass("active");
                var vote = $(this).data('vote');
                var data = {
                    'vote': vote,
                };
                const stars = document.querySelectorAll('.link-vote');
                stars.forEach(star => {
                star.addEventListener('click', () => {
                    stars.forEach(star => {
                        star.classList.remove('active');
                    });
                    
                    star.classList.add('active');
                    });
                });
                fetch_reflection_data(data);
            });
        });

        function fetch_reflection_data(data) {
            
                $.ajax({
                    url: "{{ route('book.details', $book->id) }}",
                    method: "GET",
                    data: data,
                    success: function(data) {
                        if(data && data['status'] == 2){
                            location.reload();
                        }else {
                            $('#table-reflections').fadeOut(70, function() {
                                $('#table-reflections').html(data);
                                $('#table-reflections').fadeIn(70);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Đã xảy ra lỗi: " + error);
                    }
                });
            }
        
            const button = document.querySelector('.review-btn');

            button.addEventListener('mouseover', () => {
                button.classList.add('heart-hover');
            });

            button.addEventListener('mouseout', () => {
                button.classList.remove('heart-hover');
            });
    </script>
    @endpush
@endauth

