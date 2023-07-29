
@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.navbar', ['user' => "Người dùng", 'urlUser' => route('admin.users')])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-0">
                        <div class="bg-gradient-primary border-radius-lg p-3 d-flex align-items-center justify-content-between">
                            <h5 class="mb-0" style="color: #fff;">
                                Người dùng
                            </h5>

                            <div class="text-right">
                                <button href="#" class="btn btn-light m-0" data-bs-toggle="modal"
                                        data-bs-target="#modal-form">Thêm mới
                                </button>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row d-flex justify-content-between pb-2">
                                <div class="col-lg-5 px-4">
                                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                        <li class="nav-item">
                                            <a data-status=""
                                               class="nav-link link-status-user mb-0 px-0 py-1 active"
                                               data-bs-toggle="tab" href="#profile-tabs-simple" role="tab"
                                               aria-controls="profile" aria-selected="true">
                                                Tất cả
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link link-status-user mb-0 px-0 py-1"
                                               data-status="1" data-bs-toggle="tab"
                                               href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                               aria-selected="false">
                                                Đang hoạt động
                                            </a>
                                        </li>
                                        <li class="nav-item pr-1">
                                            <a class="nav-link link-status-user mb-0 px-0 py-1 "
                                               data-status="2" data-bs-toggle="tab"
                                               href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                               aria-selected="false">
                                                Đã khóa
                                            </a>
                                        </li>
                                        <li class="nav-item pr-1">
                                            <a class="nav-link link-status-user mb-0 px-0 py-1"
                                               data-status="0" data-bs-toggle="tab"
                                               href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                               aria-selected="false">
                                                Đã xoá
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 align-content-center me-sm-1">
                                    <div class="form-search mt-1 px-3 d-flex input-group input-group-outline">
                                        <input id="search-user" type="text" class="form-control"
                                               placeholder="Tìm kiếm user..."
                                               name="search" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="route-data" class="d-none"
                         data-url="{{ route('admin.users') }}"></div>
                    <div id="path-image" class="d-none" data-url="{{URL::asset('storage/files/')}}"></div>
                    <div class="table-responsive" id="table-user">
                        @include('admin.users.table_user')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.components.users.unblock-modal')
    @include('admin.components.users.block-modal')
    @include('admin.components.users.create-modal')
    @include('admin.components.users.delete-modal')
    @include('admin.components.users.edit-modal')
@endsection

@push('scripts')
    <script src="{{asset('js/admin/users/list.js')}}"></script>
    <script src="{{asset('js/admin/users/delete.js')}}"></script>
    <script src="{{asset('js/admin/users/create.js')}}"></script>
    <script src="{{asset('js/admin/users/table.js')}}"></script>
    <script src="{{asset('js/admin/users/upload-image.js')}}"></script>
@endpush


