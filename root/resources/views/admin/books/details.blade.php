@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.navbar', ['user' => 'Quản lý sách', 'urlUser' => route('admin.books'),
 'name' => isset($book->name) ? "$book->name" : '', 'url' =>  isset($book) ? route('admin.books.details', $book->id) : ''
])
    <div class="container-fluid py-4 ">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-0">
                        <div class="bg-gradient-primary border-radius-lg p-3 d-flex align-items-center justify-content-between">
                            <h5 class="mb-0" style="color: #fff;">
                                Chi tiết sách
                            </h5>
                            @if($isSoftDeleted)
                                <div class="text-right">
                                    <button href="#" id="btn-delete" class="btn btn-edit-book btn-light m-0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#delete-modal"
                                            data-source="detail"
                                            data-id="{{$id}}"
                                    >Xóa
                                    </button>
                                    <button href="#" class="btn btn-edit-book btn-light m-0" data-bs-toggle="modal"
                                            data-bs-target="#edit-book"
                                            data-source="detail"
                                            data-id="{{$id}}"
                                    >Thêm mới
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <section style="margin-left: 10%" class="p-4 ml-5">
                            <h1 class="display-5 fw-normal">{{$book->name}}</h1>
                            <div class="row gx-4 gx-lg-5 align-items-center">
                                <div class="col-md-3  position-relative">
                                    <img class="card-img-top mb-5 mb-md-0 w-100"
                                         src="{{ isset($book->image) ? URL::asset('storage/'.$book->image) : '' }}"
                                         alt="...">
                                </div>
                                <div class="col-md-8 p-1">
                                    <div class="fs-6 mt-2">Mã sách: <span class="text-success"> {{$book->book_cd}}
                                    </div>
                                    <div class="fs-6 mt-2">Danh mục : <span class="text-success">{{$cateToShow}}</span>
                                    </div>
                                    <div class="fs-6 mt-2">Tác giả : <span class="text-success">{{$book->author}}</span>
                                    </div>
                                    <div class="fs-6 mt-2">Số lượng : <span class="text-success">  {{$book->quantity }}
                                            | Đã mượn {{$borrowTotal}} </span></div>
                                    <div class="fs-6 mt-2">Trạng thái: <span
                                                class="text-success {{ isset($book->deleted_at) ? 'text-danger' : ($book->quantity > $borrowTotal ? 'text-success' : 'text-danger') }}">
                                        {{ $book->deleted_at ? 'Đã xóa' : ($book->quantity > $borrowTotal ? 'Đang còn' : 'Đã hết') }} </span>
                                    </div>
                                    <div class="fs-6 mt-2">Đánh giá : <span
                                                class="text-success"> {{$reflectionTotal}} </span></div>
                                    <div class="fs-6 mt-2">Mô tả : <span
                                                class="text-success"> {{$book->description}} </span></div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <hr class="border-primary border">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-11 overflow-x-auto">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-secondary text-center font-weight-bolder">
                                        <str>STT</str>
                                    </th>
                                    <th class="text-secondary text-center font-weight-bolder">
                                        <str>Người tặng</str>
                                    </th>
                                    <th class="text-secondary text-center font-weight-bolder">
                                        <str>Số lượng</str>
                                    </th>
                                    <th class="text-secondary text-center font-weight-bolder">
                                        <str>Ghi chú</str>
                                    </th>
                                    <th class="text-secondary text-center font-weight-bolder">
                                        <str>Ngày cập nhật</str>
                                    </th>
                                    <th class="text-secondary text-center font-weight-bolder"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($users) > 0)
                                    @foreach($users as $key => $user)
                                        <tr>
                                            <td class="text-center">{{ ++$key }}</td>
                                            <td class="text-center">{{ $user->name }}</td>
                                            <td class="text-center"> {{$user->quantity}}</td>
                                            <td class="text-center"></td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($user->userBookUpdate)->format('d-m-Y') }}</td>
                                            <td class="text-right">
                                                @if($isSoftDeleted)
                                                    <div class="d-flex pe-3 justify-content-end">
                                                        <button class="btn btn-sm btn-info btn-edit-book openEditModal mb-0 m-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit-book"
                                                                data-id="{{$id}}"
                                                                data-user-id="{{$user->userBook}}"
                                                        >
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button href="#" id="btn-delete-giver"
                                                                class="btn m-0 btn--book btn-sm btn-danger mb-0 m-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-giver-modal"
                                                                data-id="{{$user->userBook}}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="8">Không có dữ liệu</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        @if (count($users) > 0)
                            @include('admin.users.paginate')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.components.books.edit-modal')
    @include('admin.components.books.delete-modal')
    @include('admin.components.books.delete-giver-modal')
@endsection
@push('scripts')
    <script src="{{asset('js/admin/books/edit.js')}}"></script>
    <script src="{{asset('js/admin/books/delete.js')}}"></script>
    <script src="{{asset('js/admin/books/delete-giver.js')}}"></script>
    <script src="{{asset('js/admin/books/upload-image.js')}}"></script>
    <script type="text/javascript">
        $('.modal#edit-book').on('shown.bs.modal', function () {
            $('.uploadFile_content').addClass('d-none');
        });
    </script>
@endpush
