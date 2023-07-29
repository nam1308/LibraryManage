<!-- Sidenav -->
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start z-index-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand text-center m-0" href=" {{ route('dashboard') }} ">
            <img src="{{ asset('img/users/logos/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white"></span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white @if( Route::currentRouteName() == 'admin.users' || Route::currentRouteName() == 'admin.users.show' ) active bg-gradient-primary @endif " href="{{ route('admin.users') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">
                            <i class="fas fa-users"></i>
                        </i>
                    </div>
                    <span class="nav-link-text ms-1">Người dùng</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white @if( Route::currentRouteName() == 'admin.books' || Route::currentRouteName() == 'admin.books.details') active bg-gradient-primary @endif" href="{{ route('admin.books') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">
                            <i class="fas fa-book"></i>
                        </i>
                    </div>
                    <span class="nav-link-text ms-1">Sách</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white @if( Route::currentRouteName() == 'admin.categories') active bg-gradient-primary @endif" href="{{ route('admin.categories') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">
                            <i class="fas fa-list-alt"></i>
                        </i>
                    </div>
                    <span class="nav-link-text ms-1">Thể loại</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white @if( Route::currentRouteName() == 'admin.borrowers') active bg-gradient-primary @endif" href="{{ route('admin.borrowers') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">
                            <i class="fas fa-shopping-cart"></i>
                        </i>
                    </div>
                    <span class="nav-link-text ms-1">Quản lý sách mượn</span>
                </a>
            </li>
        </ul>
    </div>

</aside>
