@extends('layout')

@section('content')
    <div class="container">
        <div class="d-flex mb-3 justify-content-between align-items-center">
            <h2>Secrets</h2>
            <a href="{{ route('account-secrets.create') }}" class="btn btn-primary">New secret</a>
        </div>

        <p class="alert alert-info mb4">Secrets are nothing but personal access tokens. A strings that allow different tools to authenticate as you and perform actions which you have the access to.</p>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif

        <table class="table table-bordered table-striped bg-white mb-4">
            <colgroup>
                <col>
                <col style="width: 350px">
                <col style="width: 70px">
            </colgroup>
            <thead>
                <tr>
                    <th>Secret name</th>
                    <th>Last used</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($secrets as $secret)
                    <tr>
                        <td>{{ $secret->name }}</td>
                        <td>
                            {{ $secret->last_used_at ? $secret->last_used_at->toDayDateTimeString() : 'Never' }}
                        </td>
                        <td class="py-0 align-middle">
                            <form method="post" action="{{ route('account-secrets.revoke', $secret) }}" class="d-inline delete-modal-show"
                                  data-delete-modal-title="Revoking secret" data-delete-modal-body="<b>{{ $secret->name }}</b>">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-link btn-sm text-danger">Revoke</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">The list is empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $secrets->links() }}
        </div>
    </div>
@endsection
