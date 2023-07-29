@extends('users.layout.master')
@section('content')
    @auth
    @include('users.navbar.navbar', ['user' => "Lịch sử mượn trả sách", 'urlUser' => route('history')])
    <div class="row">
      <div class="col-12">
        <div class="card" style="">
            <div class="col-12">
                    
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="col-lg-5 ">
                                    <div class="nav-wrapper position-relative end-0">
                                        <ul class="nav nav-pills nav-fill" role="tablist">
                                            <li class="nav-item">
                                                <a data-status=""
                                                class="nav-link link-status-borrower mb-0 px-0 py-1  active"
                                                data-bs-toggle="tab" href="#profile-tabs-simple" role="tab"
                                                aria-controls="profile" aria-selected="true">
                                                    Tất cả
                                                </a>
                                            </li>
                                            <li class="nav-item pr-1">
                                                <a class="nav-link link-status-borrower mb-0 px-0 py-1"
                                                data-status="0" data-bs-toggle="tab"
                                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                                aria-selected="false">
                                                    Đang mượn
                                                </a>
                                            </li>
                                            <li class="nav-item pr-1">
                                                <a class="nav-link link-status-borrower mb-0 px-0 py-1 "
                                                data-status="2" data-bs-toggle="tab"
                                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                                aria-selected="false">
                                                    Gia hạn
                                                </a>
                                            </li>
                                            <li class="nav-item pr-1">
                                                <a class="nav-link link-status-borrower mb-0 px-0 py-1 "
                                                data-status="1" data-bs-toggle="tab"
                                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                                aria-selected="false">
                                                    Đã trả
                                                </a>
                                            </li>
                                            <li class="nav-item pr-1">
                                                <a class="nav-link link-status-borrower mb-0 px-0 py-1"
                                                data-status="3" data-bs-toggle="tab"
                                                href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                                aria-selected="false">
                                                    Quá hạn
                                                </a>
                                            </li>
                                        </ul>
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
                    
                    
                    
                        <div id="route-data" class="d-none"
                            data-url="{{ route('history') }}"></div>
                        <div id="path-image" class="d-none" data-url="{{URL::asset('storage/files/')}}"></div>
                        <div class="table-responsive" id="table-user">
                            @include('users.table_history_user')
                        </div>
                
                </div>
            </div>
        </div>
    </div>
    @else
            <h3 class="text-center mt-8">Bạn cần đăng nhập để thực hiện các chức năng khác!</h3>
    @endauth
@endsection

@push('js')

    <script>
         $(document).ready(function(){
            $('#search').on('keyup', function(e){
                var search = $('#search').val();
                var status = $('.link-status-borrower.active').data('status');
                var data = {
                    'search': search,
                    'status': status
                };

                fetch_user_data(data);
            })

            $('a.link-status-borrower').on('click', function (e) {
                e.preventDefault();
                var search = $('#search').val();
                var status = $(this).data('status');
                var data = {
                    'search': search,
                    'status': status
                };
                
                fetch_user_data2(data);
            });
        })

        function sendAjaxRequest(url, data) {
            $.ajax({
                url: url,
                type: "GET",
                data: data,
                success: function (data) {
                    if(data && data['status'] == 2){
                        showToastFail(data);
                        setTimeout(() => location.reload(), 2000);
                    }else {
                        $('#table-user').html(data);
                    }
                },
                error: function (xhr, status, error) {
                    alert("Đã xảy ra lỗi: " + error);
                }
            });
        }

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
                        $('#table-user').html(data);
                        scrollTopPaginate();
                    }
                },
                error: function (xhr, status, error) {
                    alert("Đã xảy ra lỗi: " + error);
                }
            });
        });

        var debounce;
        function fetch_user_data(data) {
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                $.ajax({
                    url: "{{ route('history') }}",
                    method: "GET",
                    data: data,
                    success: function(data) {
                        if(data && data['status'] == 2){
                            location.reload();
                        }else {
                            $('#table-user').html(data);
                            scrollTopPaginate();
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("Đã xảy ra lỗi: " + error);
                    }
                });
            }, 1000);
        }

        function fetch_user_data2(data) {
                $.ajax({
                    url: "{{ route('history') }}",
                    method: "GET",
                    data: data,
                    success: function(data) {
                        if(data && data['status'] == 2){
                            location.reload();
                        }else {
                            $('#table-user').html(data);
                            scrollTopPaginate();
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("Đã xảy ra lỗi: " + error);
                    }
                });
        }
    </script>
@endpush