<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl position-sticky blur shadow-blur left-auto mt-2 top-1 z-index-1 z-index-sticky"
     id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="{{ route('dashboard') }}">Trang chủ</a>
                </li>
                @if(isset($user))
                    <li class="breadcrumb-item text-sm {{ isset($user) ? '' : 'text-dark active' }}"
                        aria-current="page">
                        <a class="{{ isset($user) ? 'opacity-5 text-dark' : '' }}"
                           href="{{ @$urlUser }}">{{ $user }}</a>
                    </li>
                @endif
                @if(isset($name))
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                        <a href="{{ isset($url) ? @$url : '' }}">{{ isset($name) ? $name : '' }}</a>
                    </li>
                @endif
            </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="navbar-nav ms-md-auto pe-md-3 d-flex align-items-center justify-content-end">
                <li class="nav-item d-xl-none pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                        @if(Auth::guard('admin')->user()->unreadNotifications->count() > 0)
                            <span class="badge count-notifycation badge-danger text-danger fs-6 px-0   ">{{ Auth::guard('admin')->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
					<ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
						style="height: auto; max-height: 350px; overflow-x: hidden;"
						aria-labelledby="dropdownMenuButton">
						<a class="all-notifycation border-0 color-" role="button" href="{{ route('admin.markReadAll',auth()->guard('admin')->user()->id) }}" style="width: fit-content; display:block">
							<div class="p-2 border border-dark-subtle rounded-pill">
								<i class="fa fa-check" aria-hidden="true"></i>
								Đánh dấu tất cả đã đọc
							</div>
						</a>
                        @foreach (Auth::guard('admin')->user()->unreadNotifications as $notification)
						<form class="form-notifycation-admin" action="{{ route('admin.markRead', $notification->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="route" value="route">
							<li class="mb-2">
								<button class="dropdown-item border-radius-md" role="button" type="submit">
									<div class="d-flex py-1" style="width: 350px">
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
					</ul>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{ Auth::guard('admin')->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="">
                            <a class="dropdown-item border-radius-md" href="javascript:;"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal">
                                            <span class="font-weight-bold">Đăng xuất</span>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->