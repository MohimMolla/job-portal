<x-main>
  @section('title', 'Profile')
  @section('jsconfig')
  <script>
    window.app = {
        url: {
          showProfile: "{{ route('user.profile.showProfile') }}",
          storage: "{{ asset('/storage/') }}",
          imageAsset: "{{ asset('/') }}",
          changePassword: "{{ route('user.profile.changePassword') }}",
          updateProfile: "{{ route('user.profile.store') }}"
        },
        skills: @json($skills),
        locations: @json($locations),
        jobTypes: [
          { id: 1, text: 'Full Time' },
          { id: 2, text: 'Part Time' },
          { id: 3, text: 'Contract' },
          { id: 4, text: 'Internship' },
          { id: 5, text: 'Office' },
        ],
        experiences: [
          { id: 0, text: '0 (Freshers)' },
          { id: 6, text: '06 Months' },
          { id: 12, text: '1 Year' },
          { id: 18, text: '1.5 Years' },
          { id: 24, text: '2 Years' },
          { id: 30, text: '2.5 Years' },
          { id: 30, text: '3 Years' },
          { id: 500, text: '3+ Years' },
        ]
      }
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
            <li class="breadcrumb-item active"><a href="{{ route('user.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Profile</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <profile-display></profile-display>
    </div>
  </section>
  <!-- /.content -->
</x-main>
