<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('img/avatar.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        @if(auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('admin'))
        <li class="nav-item @if(request()->is('admin/dashboard')) menu-open @endif">
          <a href="{{ route('admin.dashboard') }}" class="nav-link @if(request()->is('admin/dashboard')) active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li
          class="nav-item  @if(request()->is('admin/jobs*') || request()->is('admin/categories*') || request()->is('admin/skills*')) menu-open @endif">
          <a href="{{ route('admin.jobs.index') }}"
            class="nav-link @if(request()->is('admin/jobs*') || request()->is('admin/categories*') || request()->is('admin/skills*')) active @endif">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>
              Jobs
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.categories.index') }}"
                class="nav-link @if(request()->is('admin/categories*')) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Job Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.skills.index') }}"
                class="nav-link @if(request()->is('admin/skills*')) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>Job Skill</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.jobs.index') }}"
                class="nav-link @if(request()->is('admin/settings*')) active @endif">
                <i class="far fa-circle nav-icon"></i>
                <p>All Jobs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.jobs.create') }}" class="nav-link">
                <i class="fas fa-edit nav-icon"></i>
                <p>Create Job</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Settings
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Logout</p>
              </a>
            </li>
          </ul>
        </li>
        @else
        <li class="nav-item @if(request()->is('user/dashboard')) menu-open @endif">
          <a href="{{ route('user.dashboard') }}" class="nav-link @if(request()->is('user/dashboard')) active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item @if(request()->is('user/settings*')) menu-open  @endif">
          <a href="#" class="nav-link @if(request()->is('user/settings*')) active  @endif">
            <i class="fas fa-cog nav-icon"></i>
            <p>
              Settings
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('user.profile.index') }}" class="nav-link @if(request()->is('user/settings*')) active  @endif">
                <i class="fas fa-user nav-icon"></i>
                <p>Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Logout</p>
              </a>
            </li>
          </ul>
        </li>
        @endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
