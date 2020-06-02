@extends('layout')

@section('content')
<div class="container">
    @formsection('Login')
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row">
                <label for="username_or_email" class="col-md-4 col-form-label text-md-right">Username or email</label>

                <div class="col-md-6">
                    <input id="username_or_email" type="text" class="form-control @error('username_or_email') is-invalid @enderror"
                           name="username_or_email" value="{{ old('username_or_email') }}" required autocomplete="email" autofocus>

                    @error('username_or_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif
                </div>
            </div>
        </form>
    @endformsection
</div>
@endsection
