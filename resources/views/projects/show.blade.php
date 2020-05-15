@extends('layout')

@section('content')
    <div class="container">
        <div class="mb-4 d-flex align-items-center">
            <h2 class="mr-auto">{{ $project->name }}</h2>
            <a href="{{ route('projects.export', $project) }}" class="btn btn-outline-primary mr-2">Export</a>
            <a href="{{ route('messages.index', $project) }}" class="btn btn-outline-secondary">Messages</a>
        </div>
        <p>Nothing particularly interesting to see here. Yet.</p>
    </div>
@endsection
