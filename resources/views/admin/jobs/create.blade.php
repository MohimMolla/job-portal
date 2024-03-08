<x-main>
  @section('title', 'Create new Job')
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
            <li class="breadcrumb-item"><a href="{{ route('admin.jobs.index') }}">Jobs</a></li>
            <li class="breadcrumb-item active">Create job</li>
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
          <form action="{{ route('admin.jobs.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-12">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <h5 class="card-title">Job Information</h5>
                    <div class="card-tools">
                      <button class="btn btn-tool" type="button" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- ./card-header -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <div class="mb-3">
                          <label for="title" class="col-form-label text-secondary">Job Title*</label>
                          <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                            required autofocus>
                          @error('title')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <label for="category" class="col-form-label text-secondary">Category*</label>
                        <select name="category" id="category"
                          class="select2 form-control @error('category') is-invalid @enderror" required>
                          <option></option>
                          @foreach($categories as $category)
                          <option @if(old('category')==$category->id) selected @endif
                            value="{{ $category->id }}">{{ $category->name }}</option>
                          @endforeach
                        </select>
                        @error('category')
                        <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                      <div class="col-lg-4">
                        <label for="type" class="col-form-label text-secondary">Job Type*</label>
                        <select name="type" id="type" class="select2 form-control @error('type') is-invalid @enderror"
                          required>
                          <option></option>
                          <option @if(old('type')==App\Models\Job::FULL_TIME) selected @endif
                            value="{{ App\Models\Job::FULL_TIME }}">Full Time</option>
                          <option @if(old('type')==App\Models\Job::PART_TIME) selected @endif
                            value="{{ App\Models\Job::PART_TIME }}">Part Time</option>
                          <option @if(old('type')==App\Models\Job::CONTRACT) selected @endif
                            value="{{ App\Models\Job::CONTRACT }}">Contract</option>
                          <option @if(old('type')==App\Models\Job::INTERNSHIP) selected @endif
                            value="{{ App\Models\Job::INTERNSHIP }}">Internship</option>
                          <option @if(old('type')==App\Models\Job::OFFICE) selected @endif
                            value="{{ App\Models\Job::OFFICE }}">Office</option>
                        </select>
                        @error('type')
                        <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                      <div class="col-lg-4">
                        <div class="mb-3">
                          <label for="location" class="col-form-label text-secondary">Job Location*</label>
                          <select name="location" id="location"
                            class="select2 form-control @error('location') is-invalid @enderror">
                            <option></option>
                            @foreach ($locations as $location)
                            <optgroup label="{{ $location->name }}">
                              @foreach ($location->city as $city)
                              <option @if(old('location')==$city->id) selected @endif
                                value="{{ $city->id }}">{{ $city->name }}</option>
                              @endforeach
                            </optgroup>
                            @endforeach
                          </select>
                          @error('location')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label for="qualification"
                            class="col-form-label text-secondary">Qualification/Eligibility*</label>
                          <select name="qualification[]" id="qualification"
                            class="form-control select2 @error('qualification') is-invalid @enderror" required multiple>
                            <option></option>
                            @foreach ($qualifications as $qualification)
                            @php
                                $old_q = old('qualification') ? old('qualification') : [];
                            @endphp
                            <option @if(in_array($qualification->id, $old_q)) selected @endif
                              value="{{ $qualification->id }}">{{ $qualification->name }}</option>
                            @endforeach
                          </select>
                          @error('qualification')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label for="hiring" class="col-form-label text-secondary">Hiring Process*</label>
                          <select name="hiring[]" id="hiring"
                            class="form-control select2 @error('hiring') is-invalid @enderror" multiple>
                            @php
                                $old_hiring = old('hiring') ? old('hiring') : [];
                            @endphp
                            <option></option>
                            <option @if(in_array(App\Models\Job::FACE_TO_FACE, $old_hiring)) selected @endif
                              value="{{ App\Models\Job::FACE_TO_FACE }}">Face to Face</option>
                            <option @if(in_array(App\Models\Job::WRITTEN_TEST, $old_hiring)) selected @endif
                              value="{{ App\Models\Job::WRITTEN_TEST }}">Written-test</option>
                            <option @if(in_array(App\Models\Job::TELEPHONIC, $old_hiring)) selected @endif
                              value="{{ App\Models\Job::TELEPHONIC }}">Telephonic</option>
                            <option @if(in_array(App\Models\Job::GROUP_DISCUSSION, $old_hiring)) selected @endif
                              value="{{ App\Models\Job::GROUP_DISCUSSION }}">Group Discussion</option>
                            <option @if(in_array(App\Models\Job::WALK_IN, $old_hiring)) selected @endif
                              value="{{ App\Models\Job::WALK_IN }}">Walk In</option>
                          </select>
                          @error('hiring')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="mb-3">
                          <label for="deadline" class="col-form-label text-secondary">Application Deadline</label>
                          <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}"
                            class="form-control @error('deadline') is-invalid @enderror" />
                          @error('deadline')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <label for="monthly_salary_min" class="col-form-label text-secondary">Monthly Salary
                          (Min)*</label>
                        <input type="number" name="monthly_salary_min" id="monthly_salary_min"
                          class="form-control @error('monthly_salary_min') is-invalid @enderror" min="1000"
                          value="{{ old('monthly_salary_min') }}" required>
                        @error('monthly_salary_min')
                        <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>

                      <div class="col-lg-4">
                        <label for="monthly_salary_max" class="col-form-label text-secondary">Monthly Salary
                          (Max)*</label>
                        <input type="number" name="monthly_salary_max" id="monthly_salary_max"
                          class="form-control @error('monthly_salary_max') is-invalid @enderror" min="1500"
                          value="{{ old('monthly_salary_max') }}" required />
                        @error('monthly_salary_max')
                        <span class="invalid-feedback">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>

                      <div class="col-lg-12">
                        <div class="mb-3">
                          <div id="quill-editor"></div>
                          <textarea name="description" id="description"
                            class="q-editor d-none form-control @error('description') is-invalid @enderror"
                            required>{{ old('description') }}</textarea>
                          <input type="hidden" name="description_ql" id="qlDescription" class="ql-input-hidden"
                            value="{{ old('description_ql') }}">
                          @error('description')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="mb-3">
                          <label for="company_name">Company Name</label>
                          <input id="company_name" class="form-control  @error('company_name') is-invalid @enderror"
                          type="text" name="company_name" value="{{ old('company_name') }}" />

                          @error('company_name')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <!-- ./col-lg-12 -->
                    </div>

                    <div class="my-2 row">
                      <div class="col-lg-12">
                        <h5 class="mb-2 text-secondary">Additional Details (Optional)</h5>
                        <hr>
                      </div>
                      <div class="col-lg-3">
                        <div class="mb-3">
                          <label for="year_passing_from">Year of Passing (From)</label>
                          <select name="year_passing_from" id="year_passing_from"
                            class="form-control select2 @error('year_passing_from') is-invalid @enderror">
                            <option></option>
                            {{ renderYearOptions(old('year_passing_from')) }}
                          </select>

                          @error('year_passing_from')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-lg-3">
                        <div class="mb-3">
                          <label for="year_passing_to">Year of Passing (To)</label>
                          <select name="year_passing_to" id="year_passing_to"
                            class="form-control select2 @error('year_passing_to') is-invalid @enderror">
                            <option></option>
                            {{ renderYearOptions(old('year_passing_to')) }}
                          </select>

                          @error('year_passing_to')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-lg-3">
                        <div class="mb-3">
                          <label for="experience_from">Experience (From)</label>
                          <select name="experience_from" id="experience_from"
                            class="form-control select2 @error('experience_from') is-invalid @enderror">
                            <option></option>
                            {{ renderExperienceOptions(old('experience_from')) }}
                          </select>

                          @error('experience_from')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-lg-3">
                        <div class="mb-3">
                          <label for="experience_to">Experience (To)</label>
                          <select name="experience_to" id="experience_to"
                            class="form-control select2 @error('experience_to') is-invalid @enderror">
                            <option></option>
                            {{ renderExperienceOptions(old('experience_to')) }}
                          </select>

                          @error('experience_to')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label for="skills">Skills</label>
                          <select name="skills[]" id="skills"
                            class="multiple form-control @error('skills') is-invalid @enderror" multiple>
                            @php
                                $old_skills = old('skills') ? old('skills') : [];
                            @endphp
                            <option></option>
                            @foreach ($skills as $skill)
                            <option {{ (in_array($skill->id, $old_skills)) ? "selected" : "" }} value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @endforeach
                          </select>

                          @error('skills')
                          <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="mb-3">
                          <label for="gender">Gender</label>
                          <select name="gender" id="gender" class="form-control select2">
                            <option></option>
                            <option {{ old('gender') == APP\Models\Job::MALE ? "selected" : "" }}
                              value="{{ APP\Models\Job::MALE }}">Male</option>
                            <option {{ old('gender') == APP\Models\Job::FEMALE ? "selected" : "" }}
                              value="{{ APP\Models\Job::FEMALE }}">Female</option>
                            <option {{ old('gender') == APP\Models\Job::BOTH ? "selected" : "" }}
                              value="{{ APP\Models\Job::BOTH }}">Both</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="mt-3 row">
                      <div class="text-right col-lg-12">
                        <button type="submit" class="btn btn-success">Save</button>
                      </div>
                    </div>
                  </div>
                  <!-- ./card-body -->
                </div>
                <!-- ./card -->
              </div>
              <!-- ./col-lg-12 -->
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->

  @section('jsconfig')
  <script>
    let app = {
      url: {
        searchSkill: "{{ route('admin.skills.search') }}"
      }
    }
  </script>
  @endsection

  @push('css')
  <!-- Quill -->
  <link rel="stylesheet" href="{{ asset('plugins/quill/quill.snow.css') }}">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <!-- Suggestags -->
  <link rel="stylesheet" href="{{ asset('plugins/suggestags/css/amsify.suggestags.css') }}">
  @endpush

  @push('js')
  <!-- Moment -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  @endpush
</x-main>
