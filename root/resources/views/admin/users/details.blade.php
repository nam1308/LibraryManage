@extends('admin.layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('admin.layouts.navbars.navbar', ['user' => "Người dùng", 'urlUser' => route('admin.users'), 'name' => isset($data->name) ? "$data->name" : '', 'url' =>  isset($data) ? route('admin.users.show', $data->id) : ''])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4 mt-0">
                    <div class="card-body px-0 pb-2">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center pt-0">
                            <h4 class="mb-0">
                                {{ isset($data->name) ? $data->name : '' }}
                            </h4>
                            @if ($data->status == \App\Enums\UserEnums::STATUS_ACTIVE)
                                <div class="card-header-right d-flex align-items-center justify-content-end">
                                    <div class="open-edit m-3">
                                        <button type="button"
                                                class="btn btn-block btn bg-gradient-danger mb-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-open-edit"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                    <div class="open-changePassword">
                                        <button type="button"
                                                class="btn btn-block bg-gradient-danger mb-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-open-changePassword"
                                        >
                                            Đổi mật khẩu
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5 col-md-4 col-lg-3">
                                    <div class="bd-example bd-example-images">
                                        <label for="user_email mb-0">
                                            <strong>
                                                Avatar:
                                            </strong>
                                        </label>
                                        <div class="img_block">
                                            <img data-src=""
                                                 class="img-thumbnail rounded-circle"
                                                 alt=""
                                                 src="{{ isset($data->avatar) ? asset("storage/$data->avatar") : asset("storage/files/avatarnull.jpg")}}"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7 col-md-8 col-lg-9">
                                    <div class="row">
                                        <div class="col-12 col-md-7 col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label for="user_email mb-0">
                                                    <strong>
                                                        Email:
                                                    </strong>
                                                </label>
                                                <div>
                                                    <input type="email" class="form-control"
                                                           value="{{ isset($data->email) ? $data->email : '' }}"
                                                           disabled
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-5 col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label for="user_gender">
                                                    <strong>
                                                        Giới tính:
                                                    </strong>
                                                </label>
                                                <div>
                                                    <input type="text" class="form-control"
                                                           value="{{ isset($data->gender) ? @\App\Enums\UserEnums::GENDER[$data->gender] : '' }}"
                                                           disabled
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label for="user_department">
                                                    <strong>
                                                        Bộ phận:
                                                    </strong>
                                                </label>
                                                <div>
                                                    <input type="text" class="form-control"
                                                           value="{{ isset($data->department_id) ? @\App\Enums\UserEnums::DEPARTMENT[$data->department_id] : '' }}"
                                                           disabled
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-5 col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label for="user_birthday">
                                                    <strong>
                                                        Ngày sinh:
                                                    </strong>
                                                </label>
                                                <div>
                                                    <input type="text" class="form-control"
                                                           value="{{ isset($data->birthday) ? date("d-m-Y", strtotime($data->birthday)) : '' }}"
                                                           disabled
                                                           id="birthdayDetail"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-7 col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label for="user_read">
                                                    <strong>
                                                        Số sách đã đọc:
                                                    </strong>
                                                </label>
                                                <div>
                                                    <input type="number" class="form-control"
                                                           value="{{ isset($read) ? $read : '' }}" disabled
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-5 col-lg-6 mb-3">
                                            <div class="form-group">
                                                <label for="user_contribute">
                                                    <strong>
                                                        Số sách đóng góp:
                                                    </strong>
                                                </label>
                                                <div>
                                                    <input type="number" class="form-control"
                                                           value="{{ isset($contributed) ? $contributed : '' }}" disabled
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="user_address">
                                                    <strong>
                                                        Quê quán:
                                                    </strong>
                                                </label>
                                                <input type="text" class="form-control"
                                                       value="{{ isset($data->address) ? $data->address : '' }}"
                                                       disabled
                                                />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="user_note">
                                                    <strong>
                                                        Ghi chú:
                                                    </strong>
                                                </label>
                                                <textarea class="form-control"
                                                          rows="3" disabled>{{ isset($data->note) ? $data->note : '' }}
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.components.toast')
    @include('admin.components.users.edit-modal')
    @include('admin.components.users.changePassword-modal')
@endsection

@push('scripts')
    <script type="text/javascript">
        $("#birthday").val($("#birthdayDetail").val());
        formatDate($("#birthday"),$("#birthdayDetail").val(),new Date(), null);
    </script>
    <script src="{{asset('js/admin/users/upload-image.js')}}"></script>
@endpush
