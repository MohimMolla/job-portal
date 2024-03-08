<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token"
          content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Jobs') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet" />

    @stack('css')
    @yield('jsconfig')
  </head>

  <body class="bg--light-gray @yield('bodyclass')">
    <nav class="bg-white navbar navbar-expand-md navbar-light">
      <div class="container">
        <a class="navbar-brand" href="{{ route('welcome') }}">
          @if(!request()->is('job/*'))
            <img src="{{ asset('img/logo.png') }}" width="50px" alt="Brand Logo">
          @else
            {{ config('app.name') }}
          @endif
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
                                                                            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="ml-auto navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('welcome') }}"><i class="fas fa-briefcase"></i> Jobs <span
                                              class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('img/avatar.jpg') }}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                  <img src="{{ asset('img/avatar.jpg') }}" class="img-circle elevation-2" alt="User Image">

                  <p>
                  {{ auth()->user()->name }}
                  <small>Member since {{ date('M. Y', strtotime(auth()->user()->created_at)) }}</small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  @if(auth()->user()->hasRole('user'))
                    <a href="{{ route('user.profile.index') }}" class="btn btn-default btn-flat">Profile</a>
                  @endif
                  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                              class="float-right btn btn-default btn-flat">Sign out</a>
                </li>
              </ul>
              <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                @csrf
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav> <!-- /.navbar -->

    <main id="app" role="main" class="mt-2 main">

      {{ $slot }}

    </main><!-- /.container -->

    @if(!request()->is('job/*'))
    <footer class="py-4 footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            &copy; 2020 - {{ config('app.name') }}
          </div>
          <div class="col-lg-4">
            Designed and developed with <a href="https://laravel.com/" target="_blank">Laravel</a>
            <i class="mx-2 fa fa-heart"></i>
            <a href="https://getbootstrap.com/" target="_blank">Bootstrap</a>
          </div>
        </div>
      </div>
    </footer> <!-- /.footer -->
    @endif


    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script type="application/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script type="application/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('js')
  </body>

</html>
