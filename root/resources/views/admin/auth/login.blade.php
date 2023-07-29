@extends('admin.layouts.app', ['class' => 'bg-gradient-dark'])

@section('content')
    <div class="page-header align-items-start min-vh-100 bg-gradient-dark" >
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mx-3 z-index-2">
                    <img class="img-responsive" src="{{ asset('img/users/logos/logo_beyond.png') }}" style="width: 100%;" alt="">
                    </div>
                    <div class="card-body pt-2">
                    <form role="form" method="POST" action="{{ route('admin.login') }}" class="text-start">
                        @csrf
                        <div class="mb-2">
                            <label class="fw-bold m-0" for="email">
                                Email
                            </label>
                            <input id="email" type="text" class="form-control border border-black px-2" name="email" placeholder="Email" >
                            @error('email')
                                <span class="d-block invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label class="fw-bold m-0" for="password">
                                Mật khẩu
                            </label>
                            <div class="input-group input-group-outline password-toggle position-relative">
                                <input id="password" type="password" class="form-control border border-black px-2" name="password" placeholder="Mật khẩu" >
                                    <div class="input-group-append">
                                        <span class="input-group-text showpass mx-2"  onclick="togglePasswordVisibility('password')">
                                            <i class="far fa-eye-slash fw-bold"></i>
                                        </span>
                                    </div>
                                @error('password')
                                    <span class="d-block invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-check form-switch d-flex align-items-center mb-3">
                            <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                            <label class="form-check-label mb-0 ms-3" for="rememberMe">Ghi nhớ tôi</label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-danger w-100 mt-3 mb-2">Đăng nhập</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <footer class="footer position-absolute bottom-2 py-2 w-100">
        </footer>
    </div>
@endsection

@push('styles')
    <style>
        .password-toggle .showpass{
            z-index: 10;
        }
        .password-toggle .showpass:hover {
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript">
        $("input").keydown(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                $('button').click();
            }
        });
        
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
@endpush
