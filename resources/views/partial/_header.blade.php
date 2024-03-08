<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1"/>

    <!-- CSRF Token -->
    <meta name="csrf-token"
          content="{{ csrf_token() }}"/>

    <title>@yield('title', 'Dashboard') | {{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/before_load.js') }}"></script>
    <!-- Scripts -->
    {{--<script type="application/javascript" src="{{ asset('js/adminlte.min.js') }}"></script>--}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch"
          href="//fonts.gstatic.com"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"/>
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"/>

    <!-- overlayScrollbars -->
    <link rel="stylesheet"
          href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}"
          rel="stylesheet"/>

    @stack('css')
  </head>
  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed @yield('body-class')">

    @yield('jsconfig')

    <div class="wrapper">
