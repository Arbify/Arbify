@extends('projects.layout')

@section('project-content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif
    </div>

    <div id="messages-app" data-project-id="{{ $project->id }}">
        <div class="mt-5 flex-center">
            <span class="spinner-border mr-4"></span> Loading JavaScript widget...
        </div>
    </div>
@endsection
