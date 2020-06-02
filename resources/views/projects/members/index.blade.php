@extends('projects.layout')

@section('project-content')
    <div class="container">
        <p class="alert alert-info mb-4"><b>Note:</b> All administrators and super administrators have lead role abilities in any project.</p>
        @can('create', [Arbify\Models\ProjectMember::class, $project])
            <div class="d-flex mb-4">
                <a href="{{ route('project-members.create', $project) }}" class="btn btn-primary ml-auto">Add member</a>
            </div>
        @endcan

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif

        <table class="table table-bordered table-striped bg-white mb-4">
            <colgroup>
                <col>
                <col style="width: 100px">
                <col style="width: 200px">
            </colgroup>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Project role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                    <tr>
                        <td>{{ $member->user->username }}</td>
                        <td>
                            @if($member->isLead())
                                <span class="badge badge-danger">Lead</span>
                            @elseif($member->isMember())
                                <span class="badge badge-info">Member</span>
                            @elseif($member->isTranslator())
                                <span class="badge badge-light">Translator</span>
                            @endif
                        </td>
                        <td class="py-0 align-middle">
                            @can('update', [$member, $project])
                                <a href="{{ route('project-members.edit', [$project, $member]) }}">Edit</a>
                            @endcan
                            @can('delete', [$member, $project])
                                <form method="post" action="{{ route('project-members.destroy', [$project, $member]) }}" class="d-inline ml-2 delete delete-modal-show"
                                      data-delete-modal-title="Deleting member" data-delete-modal-body="<b>{{ $member->user->name }}</b> from this project">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-link btn-sm text-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
