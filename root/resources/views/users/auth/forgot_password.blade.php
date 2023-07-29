<!DOCTYPE html>
<html lang="en">
@include('users.header.header')
<body>
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100" style="background-color: #C6DBD6">
            <span class="mask opacity-6" style="background-color:  #fdefd5;"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card-body">
                            <img class="img-responsive" src="{{ asset('img/users/logos/logo_beyond.png') }}" style="width: 100%; " alt="">
                        </div>
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-body">
                                <p style="font-weight: 500; text-align: center;" id="forgot-error"></p>
                                <p style="font-weight: 500; text-align: center;" id="forgot-success"></p>
                                <form class="text-start" method="post" id="forgotForm">
                                    @csrf
                                    <h6 class="text-center">NHẬP EMAIL ĐỂ LẤY LẠI MẬT KHẨU</h6>
                                    <p class="text-center" style="font-weight: 500; text-align: center;" id="forgot-email"></p>
                                    <div class="input-group input-group-outline my-3">
                                        <input type="text" class="form-control" id="users-email" name="email" placeholder="VD: Miichisoft@gmail.com">
                                    </div>
                                    <div class="text-center mb-3">
                                        <label class="mb-0" for="">Lưu ý: Email phải trùng với tài khoản của bạn.</label>
                                    </div>
                                    <div class="text-center">
                                        <button id="btnGetPassword" type="submit" class="btn bg-danger w-100 my-4 mb-2 text-white">Lấy Lại Mật Khẩu</button>
                                    </div>
                                </form>

                                <!-- Modal back to login -->
                                <div id="loginModal" class="modal" style="position: fixed; z-index: 99;">
                                    <div class="modal-content text-center col-lg-4 col-md-8">
                                        <h6>Mật khẩu mới đã được gửi tới Email của bạn!</h6>
                                        <p style="color: black;">Quay lại trang đăng nhập?</p>
                                        <button id="backToLoginBtn" class="btn bg-danger w-100 my-4 mb-2 text-white">QUAY LẠI</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <!-- AJAX Forgot -->
    <script>
        $("#forgotForm").submit(function(event) {
            event.preventDefault();
            var formdata = $(this).serialize();
            $.ajax({
                url: "/forgot-password",
                type: "POST",
                data: formdata,
                success: function(resp) {
                    if (resp.type == "error") {
                        $(".loader").hide();
                        $.each(resp.errors, function(i, error) {
                            $("#forgot-" + i).css('color', 'red');
                            $("#forgot-" + i).html(error);
                        });
                    } else if (resp.type == "success") {
                        $("#forgot-email").hide();
                        $(".loader").hide();
                        $("#forgot-success").css('color', 'green');
                        $("#forgot-success").html(resp.message);

                        // Hiển thị modal quay về đăng nhập
                        $('#loginModal').show();
                        // Xử lý sự kiện nút "Quay lại"
                        $("#backToLoginBtn").click(function() {
                            window.location.href = "/login";
                        });
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
        });
    </script>

    <!-- Style modal back to login -->
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
        }
        #btnGetPassword:hover {
            background-color: #880000 !important;
        }
        #backToLoginBtn:hover {
            background-color: #880000 !important;
        }
    </style>

</body>

</html>