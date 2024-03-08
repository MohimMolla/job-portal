<x-main>
  @section('title', $user->name . '\'s Profile')
  @section('jsconfig')
  <script>
    window.app = {}
  </script>
  @endsection

  @push('css')
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  @endpush

  @push('js')
  <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
  @endpush

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="mb-2 row">
        <div class="col-sm-6">
          <h1 class="m-0">@yield('title', 'Welcome')</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">User profile</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img
                  src="{{ $user->profile->image == 'avatar.jpg' ? asset('img/avatar.jpg') : asset('storage/avatar/'. $user->profile->image) }}"
                  alt="User profile picture" class="profile-user-img img-fluid img-circle" />
              </div>
              <h3 class="text-center profile-username">{{ $user->name }}</h3>
              <p class="text-center text-muted">{{ $user->profile->jobrole }}</p>
              <div class="text-center text-muted">{{ renderJobType($user->profile->job_type) }}</div>
              <div class="text-center text-muted">Experience: {{ renderExperience($user->profile->experience) }}</div>
              <div class="text-center text-muted">
                <div class="fa fa-phone mr-2"></div> {{ $user->profile->phone }}
              </div>
            </div>
            <!-- ./card-body -->
          </div>
          <!-- ./card -->
          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">About Me</h3>
            </div>
            <!-- ./card-header -->
            <div class="card-body">
              <strong><i class="mr-1 fa fa-book"></i> Education</strong>

              <p class="text-muted">{{ $user->profile->education }}</p>

              <strong><i class="mr-1 fas fa-map-marker-alt"></i>Job Locations</strong>

              <p class="text-muted">
                {{ join(', ', renderNames($locations, json_decode($user->profile->location, true), 'id', 'name')) }}</p>

              <hr />

              <strong><i class="mr-1 fas fa-pencil-alt"></i> Skills</strong>

              <p class="text-muted">
                {{ join(', ', renderNames($skills, json_decode($user->profile->skills, true), 'id', 'name')) }}</p>

              <hr />

              <strong><i class="mr-1 far fa-file-alt"></i> About</strong>

              <p class="text-muted">
                {{ $user->profile->about }}
              </p>
            </div>
            <!-- ./card-body -->
          </div>
          <!-- ./card -->
        </div>

        <div class="col-md-8">
          @if (!empty($user->profile->cv) || !is_null($user->profile->cv))
          @php
          $allowed_exts = ['pdf', 'jpg', 'jpeg'];
          $cv = $user->profile->cv;
          $ext = explode('.', $cv)[1];
          @endphp
          @if(in_array($ext, $allowed_exts))
          <iframe src="{{ asset('storage/cv/' . $user->profile->cv) }}" width="100%" height="100%"
            frameborder="0"></iframe>
          @else
          <div class="card">
            <div class="card-body">
              <h3>We're unable to process the {{ '.'.$ext }} document at the moment please download to view with
                external application.</h3>
              <p><a class="btn btn-primary" href="{{ asset('storage/cv/' . $user->profile->cv) }}">Download</a></p>
            </div>
          </div>
          @endif
          @else
          <p>User didn't uploaded his/her profile</p>
          @endif
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</x-main>
