<style>
  .ccs_text{
    font-size: 16px;
    font-weight: 400;
  }
</style>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0  fixed-start  bg-gradient-dark" style="z-index:1021 !important" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand text-center m-0" href="/">
        <img src="{{ asset('img/users/logos/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white @if( Route::currentRouteName() == 'home') active bg-gradient-primary @endif" href="/">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10"><i class="fa fa-search-plus" aria-hidden="true"></i></i>
            </div>
            <span class="nav-link-text ms-1 ccs_text">Trang chủ</span>
          </a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link text-white @if( Route::currentRouteName() == 'user.show') active bg-gradient-primary @endif " href="{{route('user.show')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10"><i class="fa fa-user-circle" aria-hidden="true"></i></i>
            </div>
            <span class="nav-link-text ms-1 ccs_text">Trang cá nhân</span>
          </a>
        </li>


        <li class="nav-item">
          <a class="nav-link text-white @if( Route::currentRouteName() == 'history') active bg-gradient-primary @endif " href="{{route('history')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <span class="material-icons">
                account_balance
              </span>
            </div>
            <span class="nav-link-text ms-1 ccs_text">Lịch sử mượn trả</span>
          </a>
        </li>
      </ul>
    </div>    
</aside>  
