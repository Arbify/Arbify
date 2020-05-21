@extends('projects.layout')

@section('project-content')
    <div class="container">
        <table class="table table-bordered table-striped bg-white mb-4">
            <thead>
                <tr>
                    <th>User display name</th>
                    <th>Project role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><i>All administrators and super administrators</i></td>
                    <td>Lead</td>
                    <td></td>
                </tr>
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
