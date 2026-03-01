<!DOCTYPE html>
<html lang="id" class="light-style layout-navbar-fixed layout-menu-fixed " data-theme="theme-default"
  data-assets-path="{{ url('/assets') . '/' }}" data-template="vertical-menu-template-starter">
@include('layouts.header')

<body style="overflow-x: hidden;">
  @include('sweetalert::alert')
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      @include('layouts.mahasiswa.aside')
      <div class="layout-page">
        @include('layouts.mahasiswa.nav')
        <div class="content-wrapper">

          <div class="container-fluid flex-grow-1 container-p-y container-xxl">
            @yield('content')
          </div>
          <footer class="footer">
            <div
              class="container-fluid d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-1 container-p-x py-3">
              <div>
                <a href="/" target="_blank" class="footer-text fw-medium">DTEI Program Doktoral |
                  Universitas Negeri Malang | &copy; {{ date('Y') }}</a>
              </div>
              <div>
                Page generated in {{ round(microtime(true) - LARAVEL_START, 3) }} seconds.
              </div>
            </div>
          </footer>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <!--/ Layout container -->

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!--/ Layout wrapper -->
  @include('layouts.footer')
</body>

</html>
