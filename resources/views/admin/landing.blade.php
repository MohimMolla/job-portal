<x-front>
  @section('jsconfig')
  <script>
    window.app = {
      url: {
        ajaxSearch: "{{ route('ajax.job.search') }}",
        search: "{{ route('search')}}",
      }
    }

    function submitForm() {
      let route = window.app.url;

      let link = route.search + '?' + searchData;
      window.location.href = link;
    }
  </script>
  @endsection

  @push('js')
  <script>
    $(document).ready(function () {
        $('#searchForm').on('submit', function (evt) {
          alert('submit form called');
          evt.preventDefault();
          return false;
        });

        $('#searchBtn').on('click', submitForm);
      });
  </script>
  @endpush

  <section class="mt-5 searchbar">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card card-outline card-secondary">
            <div class="card-header">
              <h3 class="card-title">Admin Section</h3>
            </div>
            <div class="card-body">
              <p>
              Welcome <strong>{{ auth()->user()->name }}</strong>
              </p>
              <p>
              Visit this <a href="{{ route('admin.dashboard') }}">link</a> to access dashboard
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-front>
