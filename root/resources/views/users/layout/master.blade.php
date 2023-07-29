<!DOCTYPE html>
<html lang="en">

@include('users.header.header')

<body class="g-sidenav-show  bg-gray-200" style="height: 100%">
  @include('users.sidebar.sidebar')

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Toast -->
    @include('users.components.toast')
    <!--  Content -->
    @yield('content')
    <!-- Footer -->
    <div class="container-fluid mt-4" style="justify-content:end">     
      @include('users.footer.footer')
    </div>
  </main>
  <!-- Setting -->
  @include('users.setting.setting')
  <!--   Jquery   -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{asset('js/admin/select2.js')}}"></script>
  <script src="{{ asset('js/twitter-bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/moment.min.js') }}"></script>
  <script src="{{ asset('js/daterangepicker.min.js') }}"></script>
  <!--   Core JS Files   -->
  <script src="{{ asset('js/core/popper.min.js') }}"></script>
  <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('js/material-dashboard.min.js?v=3.1.0') }}"></script>
  <script src="{{ asset('js/common.js') }}"></script>
  @stack('js')
</body>

</html> 