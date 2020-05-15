@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if(isset($user))
                        <div class="card-header">Edit <b>{{ $user->name }}</b></div>
                    @else
                        <div class="card-header">New user</div>
                    @endif

                    <div class="card-body">
                        @if(isset($user))
                            <form method="POST" action="{{ route('users.update', $user) }}" autocomplete="off">
                            @method('PATCH')
                        @else
                            <form method="POST" action="{{ route('users.store') }}" autocomplete="off">
                        @endif

                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Display name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name', $user->name ?? '') }}"
                                           required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email', $user->email ?? '') }}"
                                           required>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="text"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" value="{{ old('password', $generatedPassword ?? '') }}"
                                           @if(!isset($user)) required @endif>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <span class="form-text text-muted">
                                        @if(isset($user))
                                            Leave blank to use old password.<br>
                                        @endif
                                        Minimum 8 characters.
                                    </span>
                                </div>
                            </div>

                            @if(!isset($user))
                                <div class="form-group row">
                                    <div class="offset-4 col-md-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="email_verification" name="email_verification" value="1">
                                            <label class="custom-control-label" for="email_verification">
                                                Mark the email as verified
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-4 col-md-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="send_credentials" name="send_credentials" value="1" checked>
                                            <label class="custom-control-label" for="send_credentials">
                                                Send an email with credentials
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @if(isset($user))
                                            Update user
                                        @else
                                            Create user
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
