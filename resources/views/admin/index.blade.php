<x-main>
  @section('title', 'Admin Dashboard')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">@yield('title')</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <main class="content">
    <section class="info-1">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm=6 col-md-3">
            <a class="text-secondary" href="{{ route('admin.jobs.index') }}">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-briefcase"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Active Jobs</span>
                  <span class="info-box-number">

                    <div class="text-lg">{{ $jobCount }}</div>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.inf-box -->
          </div>
          <div class="col-12 col-sm=6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-file-pdf"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Application received</span>
                <span class="info-box-number">

                  <div class="text-lg">{{ $applicationsCount }}</div>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.inf-box -->
          </div>
          <div class="col-12 col-sm=6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Registered Users</span>
                <span class="info-box-number">

                  <div class="text-lg">{{ $userCount }}</div>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.inf-box -->
          </div>
          <div class="col-12 col-sm=6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-lock"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Registered Admin</span>
                <span class="info-box-number">

                  <div class="text-lg">{{ $adminCount }}</div>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.inf-box -->
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- /.content -->
</x-main>
