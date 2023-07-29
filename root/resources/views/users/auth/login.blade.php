<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('img/users/anh_logo.png') }}">
    <title>Miichisoft</title>
    <meta charset="utf-8">
    <link id="pagestyle" href="{{ asset('css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
   @include('users.components.toast')
  <div class="login-page bg-light">
      <div class="container">
          <div class="row">
              <div class="col-lg-10 offset-lg-1" style="max-width: 900px; margin: 0 auto;">
                  <img class="img-responsive" src="{{ asset('img/users/logos/logo_beyond.png') }}" style="width: 32%;" alt="">
                  <div class="bg-white shadow rounded">
                      <div class="row">
                          <div class="col-md-7 pe-0">
                              <div class="form-left h-100 py-5 px-5">
                                <form role="form" class="text-start" method="POST" action="{{ route('authLogin') }}">
                                    @csrf
                                      <label style="margin-bottom: 4px; font-weight: bold;">Tên đăng nhập<span class="text-danger">*</span></label>
                                      <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" placeholder="Nhập tài khoản" name="email" value="{{ old('email') }}">
                                                  @error('email')
                                                      <span class="d-block invalid-feedback" role="alert">
                                                          <strong>{{ $message }}</strong>
                                                      </span>
                                                  @enderror
                                      </div>
                                      <label style="margin-bottom: 4px; margin-top: 10px; font-weight: bold;">Mật khẩu<span class="text-danger">*</span></label>
                                      <div class="input-group input-group-outline password-toggle position-relative">
                                            <input type="password" class="form-control mb-1 w-100 z-index-10" placeholder="Nhập mật khẩu" id="password" name="password">
                                            <div class="input-group-append">
                                                <span class="input-group-text showpass" onclick="togglePasswordVisibility('password')">
                                                    <i class="far fa-eye-slash"></i>
                                                </span>
                                            </div>
                                            @error('password')
                                                <span class="d-block invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                      </div>
                                      <div class="form-check form-switch d-flex align-items-center mb-3 mt-3">
                                        <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMe" checked>
                                        <label class="form-check-label mb-0 ms-3" for="rememberMe" style="font-weight: bold;">Duy trì đăng nhập</label>
                                      </div>
                                      <div class="text-center">
                                        <button type="submit" class="btn bg-danger w-100 my-4 mb-2 text-white">Đăng Nhập</button>
                                        <a href="{{route('forgot.password')}}">Quên mật khẩu?</a>
                                      </div>
                                    </form>
                              </div>
                          </div>
                          <div class="col-md-5 ps-0 d-none d-md-block" style="background-image: url({{ asset('img/users/book.jpeg') }}); border: 3px solid #fff; background-size: cover;" >           
                              <div class="form-right h-100  text-white text-center pt-5"> 
                                   
                              </div>
                          </div>
                      </div>
                  </div>
                  <p class="text-end text-secondary mt-3">Copyright © 2023 Team Division X</p>
              </div>
          </div>
      </div>
  </div>

  <style>
    a {
        text-decoration: none;
    }
    .login-page {
        width: 100%;
        height: 100vh;
        display: inline-block;
        display: flex;
        align-items: center;
    }
    .form-right i {
        font-size: 100px;
    }
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

    <script>
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
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    @stack('js')
    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
</body>
</html>
