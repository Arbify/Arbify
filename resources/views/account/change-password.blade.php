@extends('layout')

@section('content')
    <div class="container">
        @formsection('Change password')
            @if (session('success'))
                <div class="alert alert-success mb-4">
                    {!! session('success') !!}
                </div>
            @endif

            <form method="POST" action="{{ route('account.change-password') }}">
                @csrf
                <div class="form-group row">
                    <label for="old_password" class="col-md-4 col-form-label text-md-right">Old password</label>

                    <div class="col-md-6">
                        <input id="old_password" type="password"
                               class="form-control @error('old_password') is-invalid @enderror"
                               name="old_password" required autofocus autocomplete="current-password">

                        @error('old_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="new_password" class="col-md-4 col-form-label text-md-right">New password</label>

                    <div class="col-md-6">
                        <input id="new_password" type="password"
                               class="form-control @error('new_password') is-invalid @enderror"
                               name="new_password" required autocomplete="new-password">

                        @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <span class="text-form text-muted">Minimum 8 characters.</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">Confirm new password</label>

                    <div class="col-md-6">
                        <input id="new_password_confirmation" type="password" class="form-control"
                               name="new_password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Update password
                        </button>
                    </div>
                </div>
            </form>
        @endformsection
    </div>
@endsection
