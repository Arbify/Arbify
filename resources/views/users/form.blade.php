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

                            <div class="form-group row">
                                <span class="col-md-4 col-form-label text-md-right">Role</span>

                                <div class="col-md-6 pt-2">
                                    @php
                                        use \App\Models\User;

                                        $superAdministrator = User::ROLE_SUPER_ADMINISTRATOR;
                                        $administrator = User::ROLE_ADMINISTRATOR;
                                        $userRole = User::ROLE_USER;
                                        $guest = User::ROLE_GUEST;

                                        $oldRole = (int) old('role', $user->role ?? $userRole);

                                        $canGiveRole = function (?User $user, int $role) {
                                            if ($user) {
                                                return Auth::user()->can('update-role', [$user, $role]);
                                            }

                                            return Auth::user()->can('create-role', [User::class, $role]);
                                        }
                                    @endphp
                                    <div class="custom-control custom-radio custom-control">
                                        <input type="radio" id="role.super-administrator" name="role" value="{{ $superAdministrator }}" class="custom-control-input"
                                               @if($oldRole === $superAdministrator) checked @endif required @unless($canGiveRole($user ?? null, $superAdministrator)) disabled @endunless>
                                        <label class="custom-control-label" for="role.super-administrator">
                                            <b class="d-block">Super administrator</b>
                                            <span class="d-block mt-1 mb-2">Can access and manage all resources, users and other super administrators. Has access to administration panel.</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control">
                                        <input type="radio" id="role.administrator" name="role" value="{{ $administrator }}" class="custom-control-input"
                                               @if($oldRole === $administrator) checked @endif required @unless($canGiveRole($user ?? null, $administrator)) disabled @endunless>
                                        <label class="custom-control-label" for="role.administrator">
                                            <b class="d-block">Administrator</b>
                                            <span class="d-block mt-1 mb-2">Can access and manage all resources and users.</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control">
                                        <input type="radio" id="role.user" name="role" value="{{ $userRole }}" class="custom-control-input"
                                               @if($oldRole === $userRole) checked @endif required @unless($canGiveRole($user ?? null, $userRole)) disabled @endunless>
                                        <label class="custom-control-label" for="role.user">
                                            <b class="d-block">User</b>
                                            <span class="d-block mt-1 mb-2">Can access all public projects and languages.</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control">
                                        <input type="radio" id="role.guest" name="role" value="{{ $guest }}" class="custom-control-input"
                                               @if($oldRole === $guest) checked @endif required @unless($canGiveRole($user ?? null, $guest)) disabled @endunless>
                                        <label class="custom-control-label" for="role.guest">
                                            <b class="d-block">Guest</b>
                                            <span class="d-block mt-1 mb-2">Can only access projects to which they have been added.</span>
                                        </label>
                                    </div>

                                    @error('role')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @if(!isset($user))
                                <hr style="width: 75%">

                                <div class="form-group row">
                                    <div class="offset-4 col-md-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="email_verification" name="email_verification"
                                                   @if(old('email_verification')) checked @endif>
                                            <label class="custom-control-label" for="email_verification">
                                                Mark the email as verified
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-4 col-md-6">
                                        <div class="custom-control custom-checkbox">
                                            {{-- Send credentials is checked by default --}}
                                            <input type="checkbox" class="custom-control-input" id="send_credentials" name="send_credentials"
                                                   @if(old('send_credentials') || empty(old())) checked @endif>
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
