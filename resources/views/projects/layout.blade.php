@extends('layout')

@section('breadcrumbs', '')

@section('content')
    <div class="bg-white border-bottom pt-4 mb-4">
        <div class="container">
            <nav class="mb-4">
                {{ Breadcrumbs::render() }}
            </nav>

            <div class="mb-3 d-flex align-items-center-sm-up flex-column flex-sm-row">
                <h2 class="mr-auto">{{ $project->name }}</h2>
                <div class="mt-2 mt-sm-0">
                    <div class="btn-group mr-2">
                        @can('update', $project)
                            <a href="{{ route('projects.edit', $project) }}"
                               class="btn btn-outline-secondary btn-xs-sm">Edit</a>
                        @endcan
                    </div>
                    <div class="btn-group">
                        @can('import', $project)
                            <a href="{{ route('projects.import', $project) }}"
                               class="btn btn-outline-primary btn-xs-sm">Import</a>
                        @endcan
                        <a href="{{ route('projects.export', $project) }}"
                           class="btn btn-outline-primary btn-xs-sm">Export</a>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs border-bottom-0">
                <li class="nav-item">
                    <a href="{{ route('messages.index', $project) }}"
                       class="nav-link @if(request()->route()->getName() == 'messages.index') active @endif"><b>Messages</b></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('project-languages.index', $project) }}"
                       class="nav-link @if(request()->route()->getName() == 'project-languages.index') active @endif">Languages</a>
                </li>
                @can('view-any', [Arbify\Models\ProjectMember::class, $project])
                    <li class="nav-item">
                        <a href="{{ route('project-members.index', $project) }}"
                           class="nav-link @if(request()->route()->getName() == 'project-members.index') active @endif">Members</a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>

    @yield('project-content')
@endsection
