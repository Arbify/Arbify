@extends('projects.layout')

@section('project-content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif

    </div>

    <div class="mx-5">
        <div id="messages-app" data-project-id="{{ $project->id }}"></div>
    </div>
@endsection
