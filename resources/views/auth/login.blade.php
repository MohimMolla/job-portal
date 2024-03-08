<x-public>
@push('css')
  <!-- icheck bootstrap -->
    <link rel="stylesheet"
          href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  @endpush
  
  @section('title', 'Login')
  @section('body-class', 'login-page')
  
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="{{ url('/') }}"
           class="h1">{{ config('app.name') }}</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        
        <form method="POST"
              action="{{ route('login') }}">
          @csrf
          <div class="input-group mb-3">
            <input type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   placeholder="Email"
                   name="email"
                   required
                   autocomplete="email"
                   autofocus/>
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
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Password"
                   required
                   autocomplete="current-password"
            />
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
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox"
                       id="remember"
                       name="remember" {{ old('remember') ? 'checked' : '' }}/>
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit"
                      class="btn btn-primary btn-block">{{ __('Login') }}
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>
  
        <div class="mt-2 d-flex justify-content-between align-items-center">
        @if (Route::has('password.request'))
          
            <a class="text-center"
               href="{{ route('password.request') }}">
              I forgot my password
            </a>
    
            <a href="{{ route('register') }}"
               class="text-center">Register</a>
        @endif
        </div>

      @if(Route::has('register'))
          <p class="mb-0">
          
          </p>
        @endif
      
      
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
</x-public>
