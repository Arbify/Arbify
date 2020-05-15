@extends('layout')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Preferences</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('account.update-preferences') }}">
                            @csrf

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update preferences
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
