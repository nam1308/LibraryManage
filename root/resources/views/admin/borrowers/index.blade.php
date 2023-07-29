@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.navbar', ['user' => 'Quản lý sách mượn', 'urlUser' => route('admin.borrowers')])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-0">
                        <div class="bg-gradient-primary border-radius-lg p-3 d-flex align-items-center justify-content-between">
                            <h5 class="mb-0" style="color: #fff;">
                                Quản lý sách mượn
                            </h5>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row d-flex justify-content-between pb-2">
                                <div class="col-lg-5 px-4">
                                    <div class="d-flex h-100 justify-content-center w-100 flex-column">
                                        <div id="borrowers-group">
                                            <select id="category_id-input" data-placeholder="Danh mục sách"
                                                    class="form-control border border-black px-2" name="user_id">
                                                <option value=""></option>
                                                <option class="" data-categories="" id="all" value=" ">
                                                    Chọn tất cả
                                                </option>
                                                @foreach ($categories as $key => $cate)
                                                    <option class="" value="{{ $key }}" data-categories="{{ $key }}">
                                                        {{$cate}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 align-content-center me-sm-1">
                                    <div class="form-search mt-1 px-3 d-flex input-group input-group-outline">
                                        <input id="search-borrowers" type="text" class="form-control"
                                               placeholder="Tìm kiếm sách..."
                                               name="search" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-between pb-2 pt-3">
                                <div class="col-lg-12 px-4">
                                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                        <li class="nav-item">
                                            <a data-status=""
                                               class="nav-link link-status-borrowers mb-0 px-0 py-1 active"
                                               data-bs-toggle="tab" href="#profile-tabs-simple" role="tab"
                                               aria-controls="profile" aria-selected="true">
                                                Tất cả
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link link-status-borrowers mb-0 px-0 py-1"
                                               data-status="0" data-bs-toggle="tab"
                                               href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                               aria-selected="false">
                                                Đang mượn
                                            </a>
                                        </li>
                                        <li class="nav-item pr-1">
                                            <a class="nav-link link-status-borrowers mb-0 px-0 py-1 "
                                               data-status="2" data-bs-toggle="tab"
                                               href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                               aria-selected="false">
                                                Gia hạn
                                            </a>
                                        </li>
                                        <li class="nav-item pr-1">
                                            <a class="nav-link link-status-borrowers mb-0 px-0 py-1"
                                               data-status="1" data-bs-toggle="tab"
                                               href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                               aria-selected="false">
                                                Đã trả
                                            </a>
                                        </li>
                                        <li class="nav-item pr-1">
                                            <a class="nav-link link-status-borrowers mb-0 px-0 py-1"
                                               data-status="3" data-bs-toggle="tab"
                                               href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                               aria-selected="false">
                                                Quá hạn
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="route-data" class="d-none"
                         data-url="{{ route('admin.borrowers') }}"></div>
                    <div id="path-image" class="d-none" data-url="{{URL::asset('storage/files/')}}"></div>
                    <div class="table-responsive" id="table-borrower">
                        @include('admin.borrowers.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/admin/borrowers/list.js')}}"></script>
@endpush
