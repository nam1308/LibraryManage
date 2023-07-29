<nav class="navbar navbar-main navbar-expand-lg position-sticky px-0 mx-4 shadow-none border-radius-xl z-index-sticky"
    id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-3 text-dark" href="javascript:;">
                        <svg width="12px" height="12px" class="mb-1" viewBox="0 0 45 40" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1716.000000, -439.000000)" fill="#252f40" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(0.000000, 148.000000)">
                                            <path
                                                d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z">
                                            </path>
                                            <path
                                                d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="/">Trang chủ</a></li>
                @if (isset($user))
                    <li class="breadcrumb-item text-sm {{ isset($user) ? '' : 'text-dark active' }}"
                        aria-current="page">
                        <a class="{{ isset($user) ? 'opacity-5 text-dark' : '' }}"
                            href="{{ @$urlUser }}">{{ $user }}</a>
                    </li>
                @endif
                @if (isset($name))
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                        <a href="{{ isset($url) ? @$url : '' }}">{{ isset($name) ? $name : '' }}</a>
                    </li>
                @endif
            </ol>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                @auth
                <li class="nav-item dropdown d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 " id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer fs-5"></i>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="badge badge-danger text-danger fs-6 px-0" id="totalNotifi">{{ Auth::user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" style="height: auto;
                    max-height: 350px;
                    overflow-x: hidden;"
                    aria-labelledby="dropdownMenuButton" id="notification">
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <a role="button" href="{{ route('markReadAll',auth()->user()->id) }}" style="width: fit-content; display:block" id="markReadAll">
                                <div class="p-2 border border-dark-subtle rounded-pill">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    Đánh dấu tất cả đã đọc
                                </div>
                            </a>
                        @else
                            <div class="text-sm font-weight-normal mb-1 text-center" style="width: 350px">
                                <span>Hiện tại chưa có thông báo nào.</span>
                            </div>
                        @endif
                      @foreach (Auth::user()->unreadNotifications as $notification)
                      <form action="{{ route('markRead', $notification->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="bookId" value="{{ $notification->data['bookId'] }}">
                          <li class="mb-2" >
                              <button class="dropdown-item border-radius-md" href="" role="button" type="submit">
                                  <div class="d-flex py-1 contentNotifi" style="width: 350px">
                                      <div class="my-auto">
                                          <img src="{{ asset('storage/' . $notification->data['bookImage']) }}" class="avatar avatar-sm me-3" style="border-radius: 0px !important">
                                      </div>
                                      <div class="d-flex flex-column justify-content-center">
                                          <h6 class="text-sm font-weight-normal mb-1">
                                              <span class="font-weight-bold">{{ $notification->data['title'] }}</span>
                                          </h6>
                                          <div class="text-sm font-weight-normal mb-1">
                                            <span style="white-space: pre-line">{{ $notification->data['content'] }}</span>
                                          </div>
                                          <p class="text-xs text-secondary mb-0">
                                              <i class="fa fa-clock me-1"></i>
                                             {{ $notification->created_at }}
                                          </p>
                                      </div>
                                  </div>
                              </button>
                          </li>
                        </form>
                      @endforeach
                        <p class="text-xs text-secondary mb-0">
                            
                        </p>
                    </ul>
                  </li>
                @endauth
                <li class="nav-item px-3">
                    <h6 class="font-weight-bolder mb-0">
                        @auth
                            {{ Auth::user()->name }}
                        @endauth
                    </h6>
                </li>
                <li class="nav-item dropdown pe-2">
                    @auth
                        <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="true">
                            <img class="avatar avatar-xs" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4" aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="{{ route('authlogout') }}">
                                    <div class="d-flex align-items-center py-1">
                                        <div class="my-auto">
                                            <span class="material-icons">
                                                face
                                            </span>
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="text-sm font-weight-normal mb-0">
                                                Đăng xuất
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    @else
                        <a href="{{ route('auth.login') }}">Đăng nhập</a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>
@push('js')
    <script>
        $('#markReadAll').click(function (e) { 
            e.preventDefault();
            var href = $(this).attr('href');
            $.ajax({
                type: "GET",
                url: href,
                success: function (response) {
                    $('#totalNotifi').remove();
                    $('#notification').empty();
                    $('#notification').append(
                        '<div class="text-sm font-weight-normal mb-1 text-center" style="width: 350px;">'+
                            '<span>Hiện tại chưa có thông báo nào.</span>'+
                        '</div>'
                    );
                },

                error: function (response) {
                    let data={
                        title: 'Thông báo',
                        message: 'Đã có lỗi khi đánh dấu thông báo.',
                    };
                    showToastFail(data);
                }
            });
        });
    </script>
@endpush