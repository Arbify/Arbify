@extends('layout')

@section('content')
    <div class="container">
        <div class="mb-3 d-flex align-items-center">
            <h2 class="mr-auto">{{ $project->name }}</h2>
            <a href="{{ route('projects.export', $project) }}" class="btn btn-outline-primary mr-2">Export</a>
        </div>
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a href="{{ route('projects.show', $project) }}"
                   class="nav-link @if(request()->route()->getName() == 'projects.show') active @endif">Overview</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('messages.index', $project) }}"
                   class="nav-link @if(request()->route()->getName() == 'messages.index') active @endif">Messages</a>
            </li>
        </ul>
    </div>

    @yield('project-content')
@endsection
