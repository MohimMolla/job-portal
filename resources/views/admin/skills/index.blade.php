<x-main>
  @section('title', 'Job Skills')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="mb-2 row">
        <div class="col-sm-6">
          <h1 class="m-0">@yield('title')</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
        <div class="col-lg-7">
          <skill-table></skill-table>
        </div>
        <div class="col-lg-5">
          <skill-form></skill-form>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->

  @section('jsconfig')
  <script>
    window.app = {
          url: {
              paginate: '{{ route('admin.skills.paginate', '') }}',
              store: '{{ route('admin.skills.store', '') }}',
              show: '{{ route('admin.skills.show', '') }}',
              update: '{{ route('admin.skills.update', '') }}',
              delete: '{{ route('admin.skills.destroy', '') }}',
          },
      }
  </script>
  @endsection

  @push('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">
  <!-- SweetAlert2 -->
  @endpush

  @push('js')
  @if(session('success'))
  <script>
    toastr.info('{{ session('success') }}')
  </script>
  @endif
  @endpush
</x-main>
