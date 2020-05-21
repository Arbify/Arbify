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
