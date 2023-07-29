@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.navbar', ['user' => "Thể loại", 'urlUser' => route('admin.categories')])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-0">
                        <div class="bg-gradient-primary border-radius-lg p-3 d-flex align-items-center justify-content-between">
                            <h5 class="mb-0" style="color: #fff;">
                                Thể loại
                            </h5>

                            <div class="text-right">
                                <a href="#" id="btn-create" class="btn btn-light m-0" data-bs-toggle="modal" data-bs-target="#create-update-modal"
                                    data-action="{{ route('admin.categories.store') }}"
                                >
                                    Thêm mới
                                </a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row d-flex justify-content-between pb-2">
                                <div class="col-lg-5 px-4">
                                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                        <li class="nav-item">
                                            <a data-status=""
                                                class="nav-link link-status mb-0 px-0 py-1 active"
                                                data-bs-toggle="tab" href="#profile-tabs-simple" role="tab"
                                                aria-controls="profile" aria-selected="true"
                                            >
                                                Tất cả
                                            </a>
                                        </li>
                                        @foreach(App\Enums\CategoryEnums::STATUS as $key=>$value)
                                            <li class="nav-item">
                                                <a class="nav-link link-status mb-0 px-0 py-1"
                                                    data-status="{{ $key }}" data-bs-toggle="tab"
                                                    href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard"
                                                    aria-selected="false"
                                                >
                                                    {{ $value }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-lg-3 align-content-center me-sm-1">
                                    <div class="form-search mt-1 px-3 d-flex input-group input-group-outline">
                                        <input id="search" type="text" class="form-control"
                                            placeholder="Tìm kiếm thể loại..."
                                            name="search" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="route-data" class="d-none" data-url="{{ route('admin.categories') }}"></div>
                    <div class="table-responsive" id="table">
                        @include('admin.categories.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.components.categories.create-update-modal')
    @include('admin.components.categories.delete-modal')
@endsection

@push('scripts')
    <script src="{{asset('js/admin/categories/list.js')}}"></script>
    <script src="{{asset('js/admin/categories/modal.js')}}"></script>
@endpush


