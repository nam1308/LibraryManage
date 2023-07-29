<!-- Modal -->
<div class="modal fade" id="changeInfo" tabindex="-1" aria-labelledby="changeInfoLabel" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="changeInfoLabel">Thay đổi thông tin tài khoản</h1>
            </div>
            <form class="form-inline" id="formChangeInfo" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <img class="rounded-circle mt-5" width="150px" height="150px" id="preImg"
                            @if (empty($data->avatar))
                            src="{{ asset('img/avatar/avatar-default.jpg') }}"
                            @else
                            src="{{ asset('storage/' . $data->avatar) }}" @endif>
                            <i class="user-avatar-default"></i>
                            <span class="font-weight-bold">{{ $data->name }}</span>
                            <div class="mb-3" id="subFile">
                                <label for="imgInp" role="button" class="d-block w-100 text-center bg-primary text-white rounded-3 p-2">Chọn ảnh để thay đổi</label>
                                <input id="imgInp"type="file" accept="image/png, image/jpeg, image/gif" name="avatar" class="d-none">
                                <div class="invalid-feedback print-error-msg" style="display:none" id="avatar">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 border-right">
                        <div class="p-3 py-5">
                            <div class="row mt-2">
                                <div class="col-md-8">
                                    <label class="labels">Họ tên</label><span class="text-danger"> *</span>
                                    <input type="text" class="form-control border border-info p-2" name="name"
                                        placeholder="Họ tên" value="{{ $data->name }}">
                                    <div class="invalid-feedback print-error-msg" style="display:none" id="name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">Ngày sinh</label><span class="text-danger"> *</span>
                                    <input type="text" class="form-control border border-info p-2" id="birthdayInput" name="birthday" value="{{ date_format($data->birthday, 'd-m-Y') }}">
                                    <div class="invalid-feedback print-error-msg" style="display:none" id="birthday">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-8">
                                    <label class="labels">Email</label><span class="text-danger"> *</span>
                                    <input type="email" class="form-control border border-info p-2" name="email"
                                        placeholder="Email" value="{{ $data->email }}">
                                    <div class="invalid-feedback print-error-msg" style="display:none" id="email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">Giới tính</label><span class="text-danger"> *</span>
                                    <select class="form-select form-control border border-info p-2" name="gender"
                                        aria-label=".form-select-sm ">
                                        @foreach (App\Enums\UserEnums::GENDER as $key => $value)
                                            <option value="{{ $key }}" @selected($key == $data->gender)>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback print-error-msg" style="display:none" id="gender">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-8">
                                    <label class="labels">Mã nhân viên</label><span class="text-danger"> *</span>
                                    <input type="text" class="form-control border border-info p-2"
                                        value="{{ $data->employee_id }}" disabled readonly>
                                    <div class="invalid-feedback print-error-msg" style="display:none" id="employee_id">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">Phòng ban</label><span class="text-danger"> *</span>
                                    <input type="text" class="form-control border border-info p-2"
                                        value="{{ App\Enums\UserEnums::DEPARTMENT[$data->department_id] }}" disabled readonly>
                                    <div class="invalid-feedback print-error-msg" style="display:none" id="department">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Quê quán</label>
                                    <input type="text" class="form-control border border-info p-2" name="address"
                                        placeholder="Quê quán" value="{{ $data->address }}">
                                    <div class="invalid-feedback print-error-msg" style="display:none" id="address">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Ghi chú</label>
                                    <textarea type="text" class="form-control border border-info p-2" name="note" placeholder="Ghi chú">{{ $data->note }}</textarea>
                                    <div class="invalid-feedback print-error-msg" style="display:none" id="note">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="CloseModalChangeInfo">Đóng</button>
                    <button type="button" class="btn btn-danger" id="submitInfo">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
    <script>
        formatDate($("#birthdayInput"), $("#birthdayInput").val(), new Date(), null);
        $("#submitInfo").click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var form = $('#formChangeInfo')[0];
            var data = new FormData(form);

            $.ajax({
                type: "POST",
                url: "{{ route('user.update') }}",
                data: data,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    if(data && data['status'] == 2){
                        location.reload();
                    }else {
                        $("#CloseModalChangeInfo").click();
                        showToastSuccess(data);
                        setTimeout(location.reload.bind(location), 2000);
                    }
                },
                error: function(data) {
                    printErrorMsg(data.responseJSON.errors);
                }
            });
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").html('');
            $.each(msg, function(key, value) {
                $("#" + key).text(value[0]);
            });
            $(".print-error-msg").css('display', 'block');
        }



        const CloseModalChangeInfo = document.getElementById('CloseModalChangeInfo');
        CloseModalChangeInfo.addEventListener('click', clearForm);

    function clearForm() {
        const myForm = document.getElementById('formChangeInfo');
        myForm.reset();
        preImg.src='{{ asset("storage/".$data->avatar) }}';
        jQuery($('.print-error-msg')).hide();
    };

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                preImg.src = URL.createObjectURL(file)
            }
        };
    </script>
@endpush
