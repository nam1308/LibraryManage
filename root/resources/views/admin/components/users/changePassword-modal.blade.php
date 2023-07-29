<div class="modal modal-changePassword modal-lg fade"
     id="modal-open-changePassword"
     tabindex="-1"
     role="dialog"
     aria-labelledby="modal-open-changePassword"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" style="border-bottom: none;">
                <h5 class="modal-title font-weight-normal">Thay đổi mật khẩu</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="changPasswordForm" method="POST" action="{{ route('admin.users.changePassword',$data->id) }}">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-1"></div>
                        <div class="col-lg-10">
                            <div class="form-group mb-4">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="user_new_password">
                                            <strong>
                                                Mật khẩu mới :
                                            </strong>
                                        </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-outline password_content password-toggle position-relative">
                                            <input type="password" autocomplete="off" class="form-control mb-1 w-100"
                                                   id="user_new_password" name="user_new_password"
                                            />
                                            <div class="showpass position-absolute"
                                                 onclick="togglePasswordVisibility('user_new_password')"
                                            >
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </div>
                                            <p class="text-danger mb-0" id="user_new_password_err"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-1"></div>
                        <div class="col-12 col-lg-1"></div>
                        <div class="col-lg-10">
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="user_confirm_password">
                                            <strong>
                                                Mật khẩu mới :
                                                <br>
                                                (Xác Nhận)
                                            </strong>
                                        </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-outline password_content password-toggle position-relative">
                                            <input type="password" autocomplete="off" class="form-control mb-1 w-100"
                                                   id="user_confirm_password" name="user_confirm_password"
                                            />
                                            <div class="showpass position-absolute"
                                                 onclick="togglePasswordVisibility('user_confirm_password')"
                                            >
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </div>
                                            <p class="text-danger mb-0" id="user_confirm_password_err"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-1"></div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-center" style="border-top: none;">
                    <button type="submit" class="btn btn bg-gradient-danger">Lưu</button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('styles')
    <style>
        .password-toggle .showpass{
            top: 0px;
            right: 5px;
            padding: 7px;
            z-index: 10;
        }
        .password-toggle .showpass:hover {
            cursor: pointer;
        }
        .password-toggle #user_new_password,
        .password-toggle #user_confirm_password{
            padding-right: 40px !important;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#modal-open-changePassword').on('hidden.bs.modal', function () {
                $('#changPasswordForm')[0].reset();
                $('.text-danger').text('');
                $('.showpass').find('i.fa-eye').removeClass('fa-eye').addClass('fa-eye-slash');
                $('#user_confirm_password, #user_new_password').attr('type','password');
            });

            $('#changPasswordForm').submit(function(event) {
                event.preventDefault();
                var pattern = /^(?=.*\d)(?=.*[!@#$%^&*_+=()\-{}[\]|\\\|:;"'<>,.?/~`$£€¥₹])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
                var new_pass = $('#user_new_password').val();
                var confirm_pass = $('#user_confirm_password').val();

                var isValid = true;

                if (!pattern.test(new_pass)) {
                    $('#user_new_password_err').text('Mật khẩu tối thiểu 8 ký tự, chữ cái, chữ số và ký tự đặc biệt.');
                    isValid = false;
                } else {
                    $('#user_new_password_err').text('');
                }

                if (new_pass !== confirm_pass) {
                    $('#user_confirm_password_err').text('Mật khẩu không trùng khớp.');
                    isValid = false;
                } else {
                    $('#user_confirm_password_err').text('');
                }

                if (isValid) {
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'PUT',
                        data: $(this).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $("#modal-open-changePassword").modal('hide');
                                showMessageToast(response, "bg-success");
                                setTimeout(()=> location.reload(), 2000);
                            } else {
                                showMessageToast(response, "bg-warning");
                                setTimeout(function () { $("#messageToast").removeClass("show"); }, 2000);
                            }
                        },
                        error: function(xhr, status, error) { },
                    });
                }
            });
        });

        function togglePasswordVisibility(inputId) {
            const input = $('#' + inputId);
            const icon = input.next().find('i');
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
    </script>
@endpush

