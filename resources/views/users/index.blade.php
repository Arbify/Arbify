@extends('layout')

@section('content')
    <div class="container">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h2>Users</h2>
            @can('create', App\Models\User::class)
                <a href="{{ route('users.create') }}" class="btn btn-primary">New user</a>
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
                <col>
                <col style="width: 80px">
                <col style="width: 150px">
                <col style="width: 200px">
            </colgroup>
            <thead>
            <tr>
                <th>Display name</th>
                <th>User email</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->hasVerifiedEmail())
                            <span class="badge badge-success">Activated</span>
                        @else
                            <span class="badge badge-secondary">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($user->isSuperAdministrator())
                            <span class="badge badge-danger">Super administrator</span>
                        @elseif($user->isAdministrator())
                            <span class="badge badge-warning">Administrator</span>
                        @elseif($user->isUser())
                            <span class="badge badge-info">User</span>
                        @elseif($user->isGuest())
                            <span class="badge badge-light">Guest</span>
                        @endif
                    </td>
                    <td class="py-0 align-middle">
                        @can('update', $user)
                            <a href="{{ route('users.edit', $user) }}">Edit</a>
                        @endcan
                        @can('delete', $user)
                            <form method="post" action="{{ route('users.destroy', $user) }}"
                                  class="d-inline ml-2 delete-modal-show" data-delete-modal-title="Deleting user"
                                  data-delete-modal-body="<b>{{ $user->name }}</b>">
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
            {{ $users->links() }}
        </div>
    </div>
@endsection
