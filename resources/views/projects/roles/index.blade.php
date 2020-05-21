@extends('projects.layout')

@section('project-content')
    <div class="container">
        <p class="alert alert-info mb-4"><b>Note:</b> All administrators and super administrators have lead role abilities in any project.</p>
        <div class="d-flex mb-4">
            <a href="#" class="btn btn-primary ml-auto">Add user to project</a>
        </div>
        <table class="table table-bordered table-striped bg-white mb-4">
            <thead>
                <tr>
                    <th>User display name</th>
                    <th>Project role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($project->projectRoles as $role)
                    <tr>
                        <td>{{ $role->user->name }}</td>
                        <td>
                            @if($role->isLead())
                                Lead
                            @elseif($role->isMember())
                                Member
                            @elseif($role->isTranslator())
                                Translator
                            @endif
                        </td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
