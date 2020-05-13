@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h2>Projects</h2>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">New project</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif

        <table class="table table-bordered table-striped bg-white mb-4">
            <colgroup>
                <col style="width: 60px">
                <col>
                <col style="width: 100px">
                <col style="width: 100px">
                <col style="width: 200px">
            </colgroup>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project name</th>
                    <th>Messages</th>
                    <th>Languages</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>
                            <a href="{{ route('messages.index', $project) }}">{{ $project->name }}</a>
                        </td>
                        <td>{{ $project->messages->count() }}</td>
                        <td>{{ $project->languages->count() }}</td>
                        <td class="py-0 align-middle">
                            <a href="{{ route('projects.edit', $project) }}">Edit</a>
                            <form method="post" action="{{ route('projects.destroy', $project) }}" class="d-inline ml-2">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-link btn-sm text-danger">Delete</button>
                            </form>
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
