@push('styles')
    <link href="{{asset('css/admin/books/form.css')}}" rel="stylesheet"/>
@endpush
<div class="modal fade" id="create-book" tabindex="-1" data-bs-backdrop="static" aria-labelledby="create-modal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create-modal">Thêm sách</h1>
                <button type="button" class="btn-close btn-close-create text-dark" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route('admin.books.create')}}" id="create-book-form"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-3 d-flex align-items-center">
                            <div style="width: 100%;" id="avatar-group" class="mb-4">
                                <label class="fw-bold" id="avatar-label" for="avatar-input">
                                    Ảnh sách
                                    <span class="text-danger">*</span>
                                </label>
                                @include('admin.components.books.uploadImage-modal')
                                <span class="text-danger" id="image-error"></span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-9">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div id="name-group" class=" mb-4">
                                        <label class="fw-bold" id="user-label" for="name-input">
                                            Tên sách
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="name-input" data-placeholder="Tên sách"
                                                class="form-control border border-black px-2 custom_select2 "
                                                name="name">
                                            <option value=""></option>
                                            @foreach ($listBooks as $book_cd => $name)
                                                <option value="{{$name}}">{{$name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="name-error"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div id="book_cd-group" class=" mb-4">
                                        <label class="fw-bold" id="book_cd-label" for="book_cd-input">
                                            Mã sách
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="book_cd-input" data-placeholder="Mã sách"
                                                class="form-control border border-black px-2 custom_select2 "
                                                name="book_cd">
                                            <option value=""></option>
                                            @foreach ($listBooks as $book_cd => $name)
                                                <option value="{{$book_cd}}">{{$book_cd}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="book_cd-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div id="quantity-group" class=" mb-4">
                                        <label class="fw-bold" id="quantity-label" for="quantity-input">
                                            Số lượng
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input id="quantity-input" autocomplete="off" type="text"
                                               class="form-control border border-black px-2" name="quantity"
                                               placeholder="Số lượng">
                                        <span class="text-danger" id="quantity-error"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div id="user-group" class=" mb-4">
                                        <label class="fw-bold" id="user-label" for="user-input">
                                            Người đóng góp
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="user_id-input" data-placeholder="Người đóng góp"
                                                class="form-control border border-black px-2 custom_select2 "
                                                name="user_id">
                                            <option value=""></option>
                                            @foreach ($userActives as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="user_id-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div id="author-group" class=" mb-4">
                                        <label class="fw-bold" id="author-label" for="author-input">
                                            Tác giả
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input id="author-input" autocomplete="off" type="text"
                                               class="form-control border border-black px-2" name="author"
                                               placeholder="Tác giả">
                                        <span class="text-danger" id="author-error"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div id="category-group" class="mb-4">
                                        <label class="fw-bold" id="category-label" for="category-input">
                                            Loại
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="category-input" data-placeholder="Chọn loại sách"
                                                class="form-control border border-black px-2 custom_select2 "
                                                name="categories[]" multiple="multiple">
                                            @foreach ($cateActives as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="categories-error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div id="description-group" class=" mb-4">
                                            <label class="fw-bold" for="description-input">Mô tả sách</label>
                                            <span class="text-danger">*</span>
                                            <textarea id="description-input" autocomplete="off"
                                                      class="form-control border border-black px-2"
                                                      name="description" rows="3" placeholder="Mô tả sách"></textarea>
                                            <span class="text-danger" id="description-error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-cancel-create btn-outline-secondary"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            Hủy
                        </button>
                        <button type="submit" id="create_book" class="btn bg-gradient-danger">Tạo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

