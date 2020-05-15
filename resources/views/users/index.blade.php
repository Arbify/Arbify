@extends('layout')

@section('content')
    <div class="container">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h2>Users</h2>
            <a href="{{ route('users.create') }}" class="btn btn-primary">New user</a>
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
                <col>
                <col style="width: 150px">
                <col style="width: 200px">
            </colgroup>
            <thead>
            <tr>
                <th>#</th>
                <th>Display name</th>
                <th>User email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>Administrator</td>
                    <td class="py-0 align-middle">
                        <a href="{{ route('users.edit', $user) }}">Edit</a>
                        <form method="post" action="{{ route('users.destroy', $user) }}"
                              class="d-inline ml-2 delete-modal-show" data-delete-modal-title="Deleting user"
                              data-delete-modal-body="<b>{{ $user->name }}</b>">
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
            {{ $users->links() }}
        </div>
    </div>
@endsection
