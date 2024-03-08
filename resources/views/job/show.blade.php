<x-front>
  @section('title', $job->title)

  @section('jsconfig')
  <script>
    window.app = {
      url: {
        jobApply: "{{ route('job.apply', [$job->id, auth()->id()]) }}"
      }
    }
  </script>
  @endsection

  @push('css')
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">
  @endpush

  @push('js')
  <script></script>
  @endpush

  @section('bodyclass', 'overflow-hidden-lg')

  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="mb-2 card">
            <div class="card-header">
              <h3 class="card-title">More Jobs...</h3>
            </div>
            <div class="p-0 card-body job-left">
              <div class="row">
                @foreach ($jobs as $j)
                <div class="col-12">
                  <div class="job-in @if($j->id == $job->id) active @endif">
                    <div>
                      <a href="{{ route('job.view', $j->slug) }}">{{ $j->title }}</a>
                    </div>
                    <div class="text-muted">{{ $j->company_name }}</div>
                    <div class="text-muted">{{ $j->city->name }}</div>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="text-success">{{ $j->created_at->diffForHumans() }}</div>
                      <div>
                        {{ applicationHasUser($j->applications, auth()->id()) ? "You applied for this job" : "" }}
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <div class="col-12">
                <div class="my-2 pagination-wrap d-lg-flex justify-content-center align-items-center">
                  {{ $jobs->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card job-right">
            <div class="card-header">
              <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                  <h2 class="mb-1 text-xl job-title"><a href="{{ route('job.view', $job->slug) }}">{{ $job->title }}</a>
                  </h2>
                  <p class="mb-0 text-secondary">{{ $job->company_name }} - {{ $job->city->name }}</p>
                  <p class="mb-0">Posted {{ $job->created_at->diffForHumans() }}</p>
                  {{--Add Button--}}
                  @php
                  $user = auth()->user();
                  $profile = $user->profile;
                  @endphp
                  @if (!in_array($user->id, $applicationUserIds))
                  <job-apply-button username="{{ $user->name }}" email="{{ $user->email }}"
                    phone="{{ $profile->phone }}" image="{{ $profile->image
                  }}" resume="{{ $profile->cv }}" jobrole="{{ $profile->jobrole }}" company="{{ $job->company_name }}">
                  </job-apply-button>
                  @endif
                </div>
              </div>
            </div>
            <div class="card-body">
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
      </div>
    </div>
  </section>
</x-front>
