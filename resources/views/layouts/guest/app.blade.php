<!DOCTYPE html>
<html lang="id" class="light-style layout-navbar-fixed layout-menu-fixed " data-theme="theme-default"
  data-assets-path="{{ url('/assets') . '/' }}" data-template="vertical-menu-template-starter">

<head>
  <meta charset="utf-8" />
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  {{-- favicon --}}
  <link rel="shortcut icon" href="{{ url('/assets/img/logos/logo-um.png') }}" />
  <link rel="apple-touch-icon"  href="{{ url('/assets/img/fav/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ url('/assets/img/fav/apple-touch-icon.png') }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">

  {{-- core css --}}
  <link rel="stylesheet" href="{{ url('/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ url('/assets/vendor/css/theme-default.css') }}"
    class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ url('/assets/css/demo.css') }}" />

  {{-- Libs --}}
  <link rel="stylesheet" href="{{ url('/assets/vendor/libs/node-waves/node-waves.css') }}" />
  <link rel="stylesheet" href="{{ url('assets/vendor/libs/animate-css/animate.css') }}" />
  <link rel="stylesheet" href="{{ url('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  {{-- icons --}}
  <link rel="stylesheet" href="{{ url('/assets/vendor/fonts/tabler-icons.css') }}" />
  <link rel="stylesheet" href="{{ url('/assets/vendor/fonts/fontawesome.css') }}" />

  {{-- vendor --}}
  <link rel="stylesheet" href="{{ url('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

  {{-- helpers --}}
  <script src="{{ url('/assets/vendor/js/helpers.js') }}"></script>

  {{-- config --}}
  <script src="{{ url('/assets/vendor/js/template-customizer.js') }}"></script>
  <script src="{{ url('/assets/js/config.js') }}"></script>

  {{-- custom css --}}
  @yield('styles')
</head>


<body>
  @yield('content')
  @include('layouts.footer')
</body>

</html>
