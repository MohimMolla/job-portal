<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('home') }}" class="nav-link"><i class="fa fa-home"></i> Home</a>
    </li>
    @if (auth()->user()->hasRole('user'))
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('welcome') }}" class="nav-link"><i class="fas fa-briefcase"></i> Jobs</a>
    </li>
    @endif
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Full Screen Button -->
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
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
            class="btn btn-default btn-flat float-right">Sign out</a>
        </li>
      </ul>
    </li>
  </ul>
  <form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
  </form>
</nav>
<!-- /.navbar -->
