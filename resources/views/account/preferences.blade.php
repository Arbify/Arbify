@extends('layout')

@section('content')
    <div class="container">
        @formsection('Preferences')
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {!! session('success') !!}
                </div>
            @endif

            <form method="POST" action="{{ route('account.update-preferences') }}">
                @csrf

                <p class="alert alert-info">No preferences here yet.</p>

                <div class="form-group row">
                    <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                    <div class="col-md-6">
                        <input type="text" id="username" class="form-control-plaintext" readonly value="{{ $user->username }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email address</label>
                    <div class="col-md-6">
                        <input type="text" id="email" class="form-control-plaintext" readonly value="{{ $user->email }}">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Update preferences
                        </button>
                    </div>
                </div>
            </form>
        @endformsection
    </div>
@endsection
