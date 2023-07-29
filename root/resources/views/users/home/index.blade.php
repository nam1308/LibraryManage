@extends('users.layout.master')
@section('content')
    @include('users.navbar.navbar', ['user' => "Tra cứu sách", 'urlUser' => route('home')])
    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="col-12">
                    <div class="card-header">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between" >
                                <div class="col-lg-5 " style="margin-left:18px; margin-bottom:20px;">
                                    <div id="user-group">
                                        <select
                                            id="category-list"
                                            data-placeholder="Danh mục sách"
                                            class="form-control border border-black px-2"
                                            name="user_id"
                                            style="max-width: 200px"
                                        >
                                            <option value=""></option>
                                            <option
                                                class="link-status-borrower active"
                                                value="all"
                                                data-categories=""
                                            >
                                                Chọn tất cả ({{$count}})
                                            </option>
                                            @foreach ($categories as $key => $cate)
                                                <option
                                                    class="link-status-borrower"
                                                    value="{{ $cate->id }}"
                                                    data-categories="{{ $cate->id }}"
                                                >
                                                    {{$cate->name}}
                                                    ({{$cate->books_count > 100 ? '100+' : $cate->books_count}})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 align-content-center ">
                                    <div class="form-search mt-1 px-3 d-flex input-group input-group-outline">
                                        <input id="search" type="text" class="form-control"
                                               placeholder="Tìm kiếm nhanh..."
                                               name="search" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div id="route-data" class="d-none"
                        data-url="{{ route('home') }}"></div>
                    <div id="path-image" class="d-none" data-url="{{URL::asset('storage/files/')}}"></div>
                    <div class="table-responsive" id="table-book">
                        @include('users.home.book')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        let debounceTimer;
        const urlSearch = $('#route-data').data('url');

        function debounce(func, delay) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(func, delay);
        }

        function sendAjaxRequest(url, data) {
            $.ajax({
                url: url,
                type: "GET",
                data: data,
                success: function (data) {
                    if(data && data['status'] == 2){
                        location.reload();
                    }else {

                        $('#table-book').html(data);
                    }
                },
                error: function (xhr, status, error) {
                    alert("Đã xảy ra lỗi: " + error);
                }
            });
        }

        // lấy sự kiện người dùng click phần lọc ngừoi dùng
        $('#category-list').on('change', function(e) {
            e.preventDefault();
            handleSearch();
        });

        // sự kiện tìm kiếm live-search
        $('#search').on('keyup', function (e) {
            e.preventDefault();
            debounce(handleSearch, 1000);
        });

        // hàm xử lý tìm kiếm
        function handleSearch() {
            let search = $('#search').val();
            let categories = $('#category-list').find(':selected').data('categories');
            let data = {
                'search': search,
                'categories': categories
            };
            sendAjaxRequest(urlSearch, data);
        }

        $('#category-list').select2();
    });
    
    // phân trang ajax
    $(document).on('click', '#paginator_user li a', function (e) {
        e.preventDefault();
        let urlPaginate = $(this).attr('href');
        $.ajax({
            url: urlPaginate,
            type: "GET",
            data: {},
            success: function (data) {
                if(data && data['status'] == 2){
                    location.reload();
                }else {
                    $('#table-book').fadeOut(200, function () {
                        $('#table-book').html(data);
                        $('#table-book').fadeIn(200);
                    });
                    scrollTopPaginate();
                }
            },
            error: function (xhr, status, error) {
                alert("Đã xảy ra lỗi: " + error);
            }
        });
    });
</script>
@endpush