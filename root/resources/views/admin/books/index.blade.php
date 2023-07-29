@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.navbar', ['user' => 'Quản lý sách', 'urlUser' => route('admin.books')])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-0">
                        <div class="bg-gradient-primary border-radius-lg p-3 d-flex align-items-center justify-content-between">
                            <h5 class="mb-0" style="color: #fff;">
                                Quản lý sách
                            </h5>
                            <div class="text-right">
                                <button href="#" class="btn btn-light m-0" data-bs-toggle="modal"
                                        data-bs-target="#create-book">Thêm mới
                                </button>
                                <button href="#" class="btn btn-light m-0 importFile" data-bs-toggle="modal"
                                    data-bs-target="#modal-form-import-file">Nhập file
                                </button>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row d-flex justify-content-between pb-2">
                                <div class="col-lg-5 px-4">

                                    <div id="user-group">
                                        <select id="category-list" data-placeholder="Danh mục sách" class="form-control border border-black px-2" name="user_id">
                                            <option value=""></option>
                                            <option class="" data-categories="" id="all" value=" ">
                                                Chọn tất cả
                                                ({{count($allBooks) > 100 ? '100+' : count($allBooks)}})
                                            </option>
                                            @foreach ($categories as $key => $cate)
                                                <option class="" value="{{ $cate->id }}" data-categories="{{ $cate->id }}">
                                                    {{$cate->name}}
                                                    ({{$cate->books_count > 100 ? '100+' : $cate->books_count}})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-3 align-content-center me-sm-1">
                                    <div class="form-search mt-1 px-3 d-flex input-group input-group-outline">
                                        <input id="search-book" type="text" class="form-control"
                                           placeholder="Tìm kiếm sách..." name="search" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="route-data" class="d-none"
                         data-url="{{ route('admin.books') }}"></div>
                    <div id="path-image" class="d-none" data-url="{{URL::asset('storage/files/')}}"></div>
                    <div class="table-responsive" id="table-book">
                        @include('admin.books.table_book')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.components.books.delete-modal')
    @include('admin.components.books.import-file-modal')
    @include('admin.components.books.create-modal')
    @include('admin.components.books.edit-modal')
@endsection
@push('scripts')
    <script src="{{asset('js/admin/books/edit.js')}}"></script>
    <script src="{{asset('js/admin/books/create.js')}}"></script>
    <script src="{{asset('js/admin/books/delete.js')}}"></script>
    <script src="{{asset('js/admin/books/importFile.js')}}"></script>
    <script src="{{asset('js/admin/books/list.js')}}"></script>
    <script src="{{asset('js/admin/books/upload-image.js')}}"></script>
@endpush
