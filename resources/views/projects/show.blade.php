@extends('layout')

@section('content')
    <div class="container">
        <div class="mb-4 d-flex align-items-center justify-content-between">
            <h2>{{ $project->name }}</h2>
            <a href="{{ route('messages.index', $project) }}" class="btn btn-outline-secondary">Messages</a>
        </div>
    </div>
@endsection
