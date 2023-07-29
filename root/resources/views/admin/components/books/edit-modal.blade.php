@push('styles')
    <link href="{{asset('css/admin/books/form.css')}}" rel="stylesheet"/>
@endpush
<div class="modal fade" id="edit-book" tabindex="-1" data-bs-backdrop="static" aria-labelledby="edit-book"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit-book">Chỉnh sửa sách</h1>
                <button type="button" class="btn-close btn-close-edit text-dark" data-bs-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route('admin.books.update')}}" id="edit-book-form"
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
                                <span class="text-danger" id="edit-image-error"></span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-9">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div id="name-group-edit" class="mb-4">
                                        <label class="fw-bold">
                                            Tên sách
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input id="name-input-edit" autocomplete="off" data-placeholder="Tên sách"
                                               type="text" class="form-control border border-black px-2 "
                                               name="name">
                                        <span class="text-danger" id="edit-name-error"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div id="book_cd-group-edit" class=" mb-4">
                                        <label class="fw-bold">
                                            Mã sách
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input id="book_cd-input-edit" autocomplete="off" data-placeholder="Mã sách"
                                               type="text" class="form-control border border-black px-2 "
                                               name="book_cd">
                                        <span class="text-danger" id="edit-book_cd-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-quantity-user">
                                <div class="col-12 col-lg-6">
                                    <div id="quantity-group-edit" class="mb-4">
                                        <label class="fw-bold">
                                            Số lượng
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input id="quantity-input-edit" autocomplete="off" type="text"
                                               class="form-control border border-black px-2" name="quantity"
                                               placeholder="Số lượng">
                                        <span class="text-danger" id="edit-quantity-error"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div id="user-group-edit" class="mb-4">
                                        <label class="fw-bold">
                                            Người đóng góp
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="user_id-input-edit" data-placeholder="Người đóng góp"
                                                class="form-control border border-black px-2 custom_select2_edit "
                                                name="user_id">
                                            @foreach ($userActives as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="edit-user_id-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div id="author-group-edit" class=" mb-4">
                                        <label class="fw-bold">
                                            Tác giả
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input id="author-input-edit" autocomplete="off" type="text" value=""
                                               class="form-control border border-black px-2" name="author"
                                               placeholder="Tác giả">
                                        <span class="text-danger" id="edit-author-error"></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div id="category-group-edit" class="mb-4">
                                        <label class="fw-bold">
                                            Loại
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="category-input-edit" data-placeholder="Chọn loại sách"
                                                class="form-control border border-black px-2 custom_select2_edit "
                                                name="categories[]" multiple="multiple">
                                            @foreach ($cateActives as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="edit-categories-error"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div id="description-group-edit" class=" mb-4">
                                            <label class="fw-bold" for="description-input">Mô tả sách</label>
                                            <span class="text-danger">*</span>
                                            <textarea id="description-input-edit" autocomplete="off"
                                                      class="form-control border border-black px-2"
                                                      name="description" rows="3" placeholder="Mô tả sách"></textarea>
                                            <span class="text-danger" id="edit-description-error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($isDetail))
                        <input id="isDetail" type="hidden" value="{{$isDetail}}" class="form-control" name="isDetail">
                    @endif
                    <input type="hidden" name="user-book-id" class="user-book-id">
                    <input type="hidden" name="id" class="d-none id-input">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-cancel-edit btn-outline-secondary"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            Hủy
                        </button>
                        <button type="submit" class="btn bg-gradient-danger" id="submitEditBook">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
