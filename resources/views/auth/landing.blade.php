<x-front>
  @section('jsconfig')
  <script>
    window.app = {
      url: {
        ajaxSearch: "{{ route('ajax.job.search')}}",
        search: "{{ route('search')}}",
      }
    }
  </script>
  @endsection

  @push('js')
  <script>

  </script>
  @endpush

  <section class="searchbar">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div id="searchForm" action="{{ route('search') }}" method="GET">
            <div class="card card-outline card-primary">
              <div class="text-center card-header">
                <h2>Search for your next job</h2>
              </div>
              <div class="card-body bg-light-sky">
                <div class="row">
                  <div class="col-md-4">
                    <job-title-search></job-title-search>
                  </div>
                  <div class="col-md-4">
                    <job-skill-search></job-skill-search>
                  </div>
                  <div class="col-md-4">
                    <job-city-search></job-city-search>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="job-section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h4 class="card-title">All Jobs</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  @forelse($jobs->chunk(4) as $chunk)
                  <div class="row">
                    @foreach ($chunk as $job)
                    <div class="col-md-3 col-12">
                      @if(!applicationHasUser($job->applications, auth()->id()))
                      <a class="job-link" href="{{ route('job.view', $job->slug) }}">
                        @endif
                        <div class="jobs card">
                          <div class="card-body">
                            <p>{{ Illuminate\Support\Str::limit($job->title, 30) }}</p>
                            <p class="text-sm text-muted">{{ $job->company_name }}
                              <strong>{{ $job->city->name }}</strong></p>
                            <p class="my-0"><strong>Category</strong>: {{ $job->category->name }}</p>
                            <p class="my-0"> {{ renderJobType($job->type) }} </p>
                            <p class=""><strong>Salary</strong>: {{ "Rs. " . thousandsCurrencyFormat($job->monthly_salary_min) . " - " .
                                thousandsCurrencyFormat($job->monthly_salary_max)  }}</p>
                            <p><strong>Posted </strong> {{ $job->created_at->diffForHumans() }}</p>
                            @if (applicationHasUser($job->applications, auth()->id()))
                            <p class="m-0 text-sm text-info">You applied for this job</p>
                            @endif

                            <div class="tags-wrap">
                              <ul class="tags">
                                @foreach ($job->skills as $skill)
                                <li>
                                  <div href="#">{{ $skill->name }}</div>
                                </li>
                                @endforeach
                              </ul>
                            </div>
                          </div>
                        </div>
                        @if(!applicationHasUser($job->applications, auth()->id()))
                      </a>
                      @endif
                    </div>
                    @endforeach
                  </div>
                  @empty
                  <div class="col-12">
                    <h3>No Jobs were found</h3>
                  </div>
                  @endforelse
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="pagination-wrap">
                {{ $jobs->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-front>
