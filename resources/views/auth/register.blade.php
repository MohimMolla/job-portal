<x-public>
@push('css')
  <!-- icheck bootstrap -->
    <link rel="stylesheet"
          href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  @endpush
  
  @section('title', 'Register')
  @section('body-class', 'register-page')
  
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{ url('/') }}"
           class="h1">{{ config('app.name') }}</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">{{ __('Register') }}</p>
        
        <form action="{{ route('register') }}"
              method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="{{ __('Name') }}"
                   value="{{ old('name') }}"
                   required
                   autocomplete="name"
                   autofocus/>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            @error('name')
            <span class="invalid-feedback"
                  role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="email"
                   id="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="{{ __('E-Mail Address') }}"
                   value="{{ old('email') }}"
                   required
                   autocomplete="email"/>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email')
            <span class="invalid-feedback"
                  role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="password"
                   id="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('Password') }}"
                   required
                   autocomplete="new-password"/>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password')
            <span class="invalid-feedback"
                  role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="password"
                   id="password-confirm"
                   class="form-control"
                   name="password_confirmation"
                   placeholder="{{ __('Confirm Password') }}"
                   required
                   autocomplete="new-password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit"
                      class="btn btn-primary btn-block">Register
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        
        
        <div class="mt-2 text-center">
          <a href="{{ route('login') }}"
             class="text-center">Already Registered?</a>
        </div>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->
</x-public>