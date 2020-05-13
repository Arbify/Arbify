@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h2>Languages</h2>
            <a href="{{ route('languages.create') }}" class="btn btn-primary">New language</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif

        <table class="table table-bordered table-striped bg-white mb-4">
            <colgroup>
                <col style="width: 60px">
                <col style="width: 60px">
                <col style="width: 100px">
                <col>
                <col style="width: 200px">
            </colgroup>
            <thead>
            <tr>
                <th>#</th>
                <th>Flag</th>
                <th>Code</th>
                <th>Language</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($languages as $language)
                <tr>
                    <td>{{ $language->id }}</td>
                    <td class="p-0 text-center align-middle">
                        @if(!is_null($language->flag))
                            <span class="flag-icon flag-icon-{{ $language->flag }}" style="font-size: 1.5em"></span>
                        @endif
                    </td>
                    <td>{{ $language->code }}</td>
                    <td>{{ $language->name }}</td>
                    <td class="py-0 align-middle">
                        <a href="{{ route('languages.edit', $language->id) }}">Edit</a>
                        <form method="post" action="{{ route('languages.destroy', $language->id) }}" class="d-inline ml-2">
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
            {{ $languages->links() }}
        </div>
    </div>
@endsection
