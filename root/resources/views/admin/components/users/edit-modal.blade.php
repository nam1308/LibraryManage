@push('styles')
    <link href="{{ asset('css/admin/users/uploadImage.css') }}" rel="stylesheet" />
@endpush
<div class="modal modal-xl fade"
     id="modal-open-edit"
     tabindex="-1" role="dialog"
     aria-labelledby="modal-open-edit"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-" role="document">
        <div class="modal-content">

            <div class="modal-header" style="border-bottom: 0">
                <h5 class="modal-title" id="modal-title-default">Chỉnh sửa người dùng</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="updateUserForm">
                @csrf
                <input type="text" name="id" id="id" value="{{ isset($data) ? $data->id : '' }}" hidden="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4 col-xl-3">
                            <div class="form-group h-100">
                                <label for="user_avatar mb-0">
                                    <strong>
                                        Ảnh đại diện <span class="text-danger">*</span>
                                    </strong>
                                </label>
                                @include('admin.components.users.uploadImage-modal')
                                <p class="text-danger" id="avatar_err" role="alert"></p>
                            </div>
                        </div>
                        <div class="col-lg-8 col-xl-9">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group mb-3 input-group input-group-outline">
                                        <label for="user_name mb-0">
                                            <strong>
                                                Họ tên <span class="text-danger">*</span>
                                            </strong>
                                        </label>
                                        <input type="text" autocomplete="off"
                                               class="form-control mb-2 w-100 "
                                               id="name" name="name" placeholder="Họ tên"
                                               value="{{ isset($data) ? $data->name : '' }}"
                                        />
                                        <p class="text-danger" id="name_err" role="alert"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group mb-3 input-group input-group-outline">
                                        <label for="user_name mb-0">
                                            <strong>
                                                Mã người dùng <span class="text-danger">*</span>
                                            </strong>
                                        </label>
                                        <input type="text" autocomplete="off" class="form-control mb-2 w-100 "
                                               id="employee_id" name="employee_id" placeholder="Mã người dùng"
                                               value="{{ isset($data) ? $data->employee_id : '' }}"
                                        />
                                        <p class="text-danger" id="employee_id_err" role="alert"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group mb-3 input-group input-group-outline">
                                        <label for="user_email mb-0">
                                            <strong>
                                                Email <span class="text-danger">*</span>
                                            </strong>
                                        </label>
                                        <input type="email" autocomplete="off" class="form-control w-100 mb-2"
                                               id="email" name="email" placeholder="Email"
                                               value="{{ isset($data) ? $data->email : '' }}"
                                        />
                                        <p class="text-danger" id="email_err" role="alert"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group mb-3 input-group input-group-outline">
                                        <label for="user_gender mb-0">
                                            <strong>
                                                Giới tính <span class="text-danger">*</span>
                                            </strong>
                                        </label>
                                        <select class="form-control w-100 mb-2" name="gender" id="gender">
                                            @foreach (\App\Enums\UserEnums::GENDER as $key => $value)
                                                <option value="{{ $key }}"
                                                        @if(isset($data) && $data->gender == $key) selected @endif>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger" id="gender_err" role="alert"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group mb-3 input-group input-group-outline">
                                        <label for="user_birthday mb-0">
                                            <strong>
                                                Ngày sinh <span class="text-danger">*</span>
                                            </strong>
                                        </label>
                                        <input type="text" class="form-control w-100 mb-2" id="birthday" name="birthday"/>
                                        <p class="text-danger" id="birthday_err" role="alert"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group mb-3 input-group input-group-outline">
                                        <label for="user_department mb-0">
                                            <strong>
                                                Bộ phận <span class="text-danger">*</span>
                                            </strong>
                                        </label>
                                        <select class="form-control w-100 mb-2" id="department_id"
                                                name="department_id">
                                            @foreach (@\App\Enums\UserEnums::DEPARTMENT as $key => $value)
                                                <option value="{{ $key }}"
                                                        @if(isset($data) ? $data->department_id : '' == $key) selected @endif>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="text-danger" id="department_id_err" role="alert"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <div class="form-group mb-3 input-group input-group-outline">
                                        <label for="user_address mb-0">
                                              <strong>
                                                Quê quán
                                            </strong>
                                        </label>
                                        <input type="text" autocomplete="off" class="form-control w-100 mb-2"
                                               id="address" name="address" placeholder="Quê quán"
                                               value="{{ isset($data) ? $data->address : '' }}"
                                        />
                                        <p class="text-danger" id="address_err" role="alert"></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <div class="form-group input-group input-group-outline">
                                        <label for="user_note mb-0">
                                            <strong>
                                                Ghi chú
                                            </strong>
                                        </label>
                                        <textarea class="form-control w-100 mb-2"
                                                  id="note" name="note" autocomplete="off"
                                                  rows="5">{{  isset($data) ? $data->note : '' }}
                                        </textarea>
                                        <p class="text-danger" id="note_err" role="alert"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-center" style="border-top: 0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Hủy</button>
                    <button type="submit" class="btn bg-gradient-danger" id="submitEdit">Lưu</button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('scripts')
    <script src="{{asset('js/admin/users/edit.js')}}"></script>
@endpush
