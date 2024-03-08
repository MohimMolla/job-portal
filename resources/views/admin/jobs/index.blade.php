<x-main>
  @section('body-class', 'sidebar-collapse')
  @section('title', 'Jobs')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">@yield('title')</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">All Jobs</li>
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
        <div class="col-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <div class="row">
                <div class="col-lg-10">
                  Showing jobs
                </div>
                <div class="col-lg-2 text-right">
                  <a href="{{ route('admin.jobs.create') }}" title="Add New Job" class="btn btn-outline-primary"><i
                      class="fa fa-plus"></i></a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table class="datatable table table-bordered table-striped text-sm">
                <thead>
                  <tr>
                    <th>#</th>
                    <th widith="25%">Job Title</th>
                    <th width="10%">Category</th>
                    <th width="15%">Created By</th>
                    <th width="10%">Deadline</th>
                    <th width="15%">Salary (Month)</th>
                    <th width="5%">Status</th>
                    <th width="5%" class="text-right">Applied</th>
                    <th width="15%" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($jobs as $job)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->category->name }}</td>
                    <td>{{ $job->user->name }}</td>
                    <td>{{ date('jS M, y', strtotime($job->deadline)) }}</td>
                    <td>Rs. {{ $job->monthly_salary_min . ' - Rs. ' . $job->monthly_salary_max }}</td>
                    <td>{{ $job->status ? "Active" : "Deactive" }}</td>
                    <td class="text-right">{{ $job->applications_count }}</td>
                    <td class="text-center">
                      <div class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('admin.jobs.show', $job->id) }}" class="btn btn-sm btn-info" title="View Details">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-success btn-sm ml-2" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <form class="toggle-status-form" action="{{ route('admin.jobs.toggle-status', $job->id) }}"
                          method="post">
                          @csrf
                          @method('PUT')
                          <button type="submit"
                            class="btn {{ $job->status ? "btn-danger" : "btn-primary" }} btn-sm ml-2"
                            title="{{ $job->status ? "Deactivate" : "Activate" }}">
                            @if ($job->status)
                            <i class="fas fa-ban"></i>
                            @else
                            <i class="fas fa-check-circle"></i>
                            @endif
                          </button>
                        </form>
                        @if (auth()->user()->hasRole('superadmin'))
                        <form class="delete-form" action="{{ route('admin.jobs.destroy', $job->id)}}" method="post"
                          onsubmit="confirmDelete(this, event);">
                          @csrf
                          @method('delete')
                          <button type="submit" class="btn btn-danger btn-sm ml-2" title="Delete">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                        @endif
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->

  @push('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
