<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title', 'Welcome') | {{ config('app.name', 'Laravel') }}</title>

    <script type="application/javascript" src="{{ asset('js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    @stack('css')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body class="hold-transition @yield('body-class')">
    <div id="app">
      {{ $slot }}

      <!-- jQuery -->
      <script type="application/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
      <!-- Bootstrap 4 -->
      <script type="application/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <!-- AdminLTE App -->
      <script type="application/javascript" src="{{ asset('js/adminlte.min.js') }}" defer></script>
      @stack('js')
    </div>
  </body>
</html>
