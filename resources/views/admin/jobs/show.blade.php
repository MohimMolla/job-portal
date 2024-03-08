<x-main>
  @section('body-class', 'sidebar-collapse')
  @section('title', Illuminate\Support\Str::limit($job->title, 70))
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('admin.jobs.index') }}">Jobs</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
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
        <div class="col-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ $job->title }}</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-wrench"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a href="{{ route('admin.jobs.edit', $job->id) }}" class="dropdown-item">Edit</a>
                    <a class="dropdown-divider"></a>
                    <a href="#" class="dropdown-item" onclick="event.preventDefault();
                      document.getElementById('toggleForm').submit();">
                      {{ $job->status ? "Dactivate" : "Activate" }}
                    </a>
                    @if (auth()->user()->hasRole('superadmin'))
                    <a href="#" onclick="event.preventDefault();
                    document.getElementById('deleteForm').submit();" class="dropdown-item">Delete</a>
                    <form id="deleteForm" method="POST" action="{{ route('admin.jobs.destroy', $job->id) }}">
                      @csrf
                      @method('DELETE')
                    </form>
                    @endif
                  </div>

                  <form id="toggleForm" method="POST" action="{{ route('admin.jobs.toggle-status', $job->id) }}">
                    @csrf
                    @method('PUT')
                  </form>



                </div>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="text-muted">{{ $job->company_name }}</div>
              <div class="text-muted">{{ $job->city->name }}</div>
              <div class="d-flex justify-content-between align-items-center">
                <div class="text-success">{{ $job->created_at->diffForHumans() }}</div>
              </div>

              <div class="job-box__html-content">
                {!! $job->description !!}
              </div>
              <div class="job-bottom-info">
                <div class="row">
                  <div class="col-md-6">
                    <ul>
                      <li><strong>Category:</strong> {{ $job->category->name }}</li>
                      <li><strong>Job Type:</strong> {{ renderJobType($job->type) }}</li>
                      <li><strong>Job Location:</strong> {{ $job->city->name }}</li>
                      <li><strong>Salary:</strong> Rs. {{ thousandsCurrencyFormat($job->monthly_salary_min) .' to ' .
                      thousandsCurrencyFormat($job->monthly_salary_max) }}</li>
                      <li><strong>Posted:</strong> {{ $job->created_at->diffForHumans() }}</li>
                    </ul>
                  </div>
                  <div class="col-md-6">
                    <ul>
                      <li><strong>Deadline Until:</strong> {!! date('j<\s\up>S</\s\up> F, Y', strtotime($job->deadline))
                        !!}</li>
                      <li><strong>Hiring Process:</strong> {{ renderHiringFromArray($job->hiring) }}</li>
                      <li><strong>Eligibility Criteria:</strong> {{ renderGender($job->gender) }}</li>
                      @if($job->experience_from && $job->experience_to)
                      <li><strong>Experience:</strong> {{ renderExperience($job->experience_from) . ' to ' .
                      renderExperience($job->experience_to) }}</li>
                      @endif
                      <li><strong>Status:</strong>: {{ $job->status ? 'Active': 'Inactive' }}</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card job-applications">
            <div class="card-header">
              <div class="card-title">Job Applicants</div>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body px-0">
              <div class="row m-0">
                @foreach ($job->applications as $appl)
                <div class="col-12 user">
                  <div class="row">
                    <div class="col-sm-2">
                      <img
                        src="{{ ($appl->user->profile->image == 'avatar.jpg') ? asset('img/avatar.jpg') : asset('/storage/avatar/' . $appl->user->profile->image) }}"
                        width="50" height="50" class="img-fluid img-circle img-bordered" alt="User Image">
                    </div>
                    <div class="col-sm-10">
                      <div class="text-secondary">
                        {{ $appl->user->name }}
                      </div>
                      <div class="text-secondary">
                        {{ $appl->user->email }}
                      </div>
                      <div class="text-secondary">
                        {{ $appl->user->profile->phone }}
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-sm-12">
                      <a class="btn btn-primary btn-sm mr-2" href="{{ asset('storage/resume/'.$appl->resume) }}"
                        download="">Download Resume</a>
                      <a class="btn btn-info btn-sm" href="{{ route('admin.user.show', $appl->user->id) }}">View Profile</a>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->

  @push('css')
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  @endpush

  @push('js')

  <!-- Toastr -->
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

  <!-- SweetAlert2 -->
  <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

  @if(session('success'))
  <script>
    toastr.info('{{ session('success') }}')
  </script>
  @endif
  @endpush

</x-main>
