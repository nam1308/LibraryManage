<!-- Modal -->
<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="changePasswordLabel"  data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="changePasswordLabel">Thay đổi mật khẩu</h1>
            </div>
            <form method="POST" class="form-inline needs-validation" id="formChangePass" enctype="multipart/form-data">
                @csrf
                <div class="modal-body form-inline">
                    <div class="col-md-12 form-group input-group mb-2">
                        <label style="margin-bottom: 4px; margin-top: 10px; font-weight: bold;">Mật khẩu hiện tại<span class="text-danger">*</span></label>
                        <div class="input-group input-group-outline password-toggle position-relative">
                            <input name="current_password" type="password" class="form-control border border-info p-2 password-toggle"
                                placeholder="Mật khẩu hiện tại" id="passCurrent">
                            <div class="input-group-append">
                                <span class="input-group-text showpass"  onclick="togglePasswordVisibility('passCurrent')">
                                    <i class="far fa-eye-slash closeEye"></i>
                                </span>
                            </div>
                            <div class="invalid-feedback print-error-msg" style="display:none" id="current_password"></div>
                        </div>
                    </div>

                    <div class="col-md-12 form-group input-group mb-2">
                        <label style="margin-bottom: 4px; margin-top: 10px; font-weight: bold;">Mật khẩu mới<span class="text-danger">*</span></label>
                        <div class="input-group input-group-outline password-toggle position-relative">
                            <input name="new_password" type="password" class="form-control border border-info p-2 password-toggle"
                                placeholder="Mật khẩu mới" id="newPass">
                            <div class="input-group-append">
                                <span class="input-group-text showpass"  onclick="togglePasswordVisibility('newPass')">
                                    <i class="far fa-eye-slash closeEye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="invalid-feedback print-error-msg" style="display:none" id="new_password"></div>
                    </div>   

                    <div class="col-md-12 form-group input-group mb-4">
                        <label style="margin-bottom: 4px; margin-top: 10px; font-weight: bold;">Xác nhận mật khẩu mới<span class="text-danger">*</span></label>
                        <div class="input-group input-group-outline password-toggle position-relative">
                            <input name="new_password_confirmation" type="password"
                            class="form-control border border-info p-2 password-toggle" placeholder="Xác nhận mật khẩu mới"
                            id="confirmNewPass">
                            <div class="input-group-append">
                                <span class="input-group-text showpass"  onclick="togglePasswordVisibility('confirmNewPass')">
                                    <i class="far fa-eye-slash closeEye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="invalid-feedback print-error-msg" style="display:none" id="new_password_confirmation">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closeModalChangePass">Đóng</button>
                    <button type="button" class="btn btn-danger" id="changePass">Lưu</button>
                </div>  
            </form> 
        </div>
    </div>
</div>

<style>
    .password-toggle {
        position: relative;
    }
    .password-toggle .form-control {
        padding-right: 45px;
    }
    .password-toggle .showpass {
        position: absolute;
        top: 21px;
        transform: translateY(-50%);
        right: 2px;
        padding: 7px;
        z-index: 20;
        background-color: #fff;
    }
    .password-toggle .showpass:hover {
        cursor: pointer;
    }
    .input-group {
        display: flex;
        flex-direction: row;
        align-items: center;
    }
    .input-group-append {
        margin-left: -1px;
        display: flex;
        align-items: center;
    }
    </style>

@push('js')
    <script>
        $("#changePass").click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('user.changePassword') }}",
                data: $('#formChangePass').serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data && data['status'] == 2){
                        location.reload();
                    }else {
                        showToastSuccess(data);
                        $("#closeModalChangePass").click();
                    }
                },
                error: function(data) {
                    printErrorMsg(data.responseJSON.errors);
                }
            });
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $("#" + key).text(value[0]);
            });
        }

        const closeModalChangePass = document.getElementById('closeModalChangePass');
        closeModalChangePass.addEventListener('click', clearForm);

        function togglePasswordVisibility(inputId) {
            const input = $('#' + inputId);
            const icon = input.parent().find('i');
            const type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);
            if (type === 'password') {
                icon.removeClass('fa-eye');
                icon.addClass('fa-eye-slash');
            } else {
                icon.removeClass('fa-eye-slash');
                icon.addClass('fa-eye');
            }
        }

        function clearForm() {
            const myForm = document.getElementById('formChangePass');
            myForm.reset();
            $('.showpass').find('i.fa-eye').removeClass('fa-eye').addClass('fa-eye-slash');
            $('#passCurrent, #newPass, #confirmNewPass').attr('type','password');
            jQuery($('.print-error-msg')).hide();
        }
    </script>
@endpush
