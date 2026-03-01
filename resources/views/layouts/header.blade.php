<head>
  <meta charset="utf-8" />
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  {{-- favicon --}}
  <link rel="shortcut icon" href="{{ url('/assets/img/logos/logo-um.png') }}" />

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
  <link rel="stylesheet" href="{{ url('/assets/vendor/libs/animate-css/animate.css') }}" />
  <link rel="stylesheet" href="{{ url('/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ url('assets/vendor/libs/quill/typography.css') }}" />
  <link rel="stylesheet" href="{{ url('assets/vendor/libs/quill/katex.css') }}" />
  <link rel="stylesheet" href="{{ url('assets/vendor/libs/quill/editor.css') }}" />

  {{-- icons --}}
  <link rel="stylesheet" href="{{ url('/assets/vendor/fonts/tabler-icons.css') }}" />
  <link rel="stylesheet" href="{{ url('/assets/vendor/fonts/fontawesome.css') }}" />

  {{-- vendor --}}
  <link rel="stylesheet" href="{{ url('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

  {{-- helpers --}}
  <script src="{{ url('/assets/vendor/js/helpers.js') }}"></script>

  {{-- config --}}
  {{-- <script src="{{ url('/assets/vendor/js/template-customizer.js') }}"></script>  --}} {{-- uncomment this line if you want to use template customizer --}}
  <script src="{{ url('/assets/js/config.js') }}"></script>





  {{-- csrf --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script>
    function onImageError(img) {
      img.src = "https://ui-avatars.com/api/?name=" + "{{ Auth::user()->nama ?? Auth::guard('dosen')->user()->nama }}" +
        "&color=7F9CF5&background=EBF4FF";
    }

    function onImageErrorGuest(img) {
      img.src = "{{ URL::to('/') }}/assets/img/avatars/guest.jpg";
    }
  </script>

  {{-- custom css --}}
  @yield('styles')
</head>
