@extends('layout')

@section('content')
    <div class="container">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h2>Projects</h2>
            @can('create', Arbify\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="btn btn-primary">New project</a>
            @endcan
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif

        <table class="table table-bordered table-striped bg-white mb-4">
            <colgroup>
                <col>
                <col style="width: 200px">
                <col style="width: 100px">
                <col style="width: 100px">
                <col style="width: 150px">
            </colgroup>
            <thead>
                <tr>
                    <th>Project name</th>
                    <th>Translating progress</th>
                    <th>Messages</th>
                    <th>Languages</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>
                            <a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a> -
                            <small>
                                <a href="{{ route('messages.index', $project) }}"><b>Messages</b></a>
                                | <a href="{{ route('project-languages.index', $project) }}">Languages</a>
                                @can('view-any', [Arbify\Models\ProjectMember::class, $project])
                                    | <a href="{{ route('project-members.index', $project) }}">Members</a>
                                @endcan
                            </small>
                            @if($project->isPrivate())
                                <span class="badge badge-light">PRIVATE</span>
                            @endif
                        </td>
                        <td>
                            @include('projects.messages.translation-progress', ['statistics' => $statistics[$project->id]['all']])
                        </td>
                        <td>{{ $project->messages->count() }}</td>
                        <td>{{ $project->languages->count() }}</td>
                        <td class="py-0 align-middle">
                            @can('update', $project)
                                <a href="{{ route('projects.edit', $project) }}">Edit</a>
                            @endcan
                            @can('delete', $project)
                                <form method="post" action="{{ route('projects.destroy', $project) }}" class="d-inline ml-2 delete delete-modal-show"
                                      data-delete-modal-title="Deleting project" data-delete-modal-body="<b>{{ $project->name }}</b>">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-link btn-sm text-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">The list is empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $projects->links() }}
        </div>
    </div>
@endsection
