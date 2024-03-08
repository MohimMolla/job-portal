<x-main>
  @section('title', 'Job Categories')
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
          <category-table></category-table>
        </div>
        <div class="col-lg-5">
          <category-form></category-form>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->

  <div class="modal fade" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" id="editForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="col-form-label text-secondary">Category Name</label>
              <input type="text" name="name" class="form-control" required autofocus />
            </div>
            {{-- /name field --}}
            <div class="mb-3">
              <label for="description" class="col-form-label text-secondary">Description</label>
              <textarea name="description" class="form-control"></textarea>
            </div>
            {{-- /description field --}}
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close
            </button>
            <button id="editBtn" type="submit" class="btn btn-primary">Save changes
            </button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  @section('jsconfig')
  <script>
    window.app = {
          url: {
              paginate: '{{ route('admin.categories.paginate', '') }}',
              store: '{{ route('admin.categories.store', '') }}',
              show: '{{ route('admin.categories.show', '') }}',
              update: '{{ route('admin.categories.update', '') }}',
              delete: '{{ route('admin.categories.destroy', '') }}',
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
