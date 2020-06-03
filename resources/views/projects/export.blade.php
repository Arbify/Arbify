@extends('layout')

@section('content')
    <div class="container">
        <h2 class="mb-4">Export - {{ $project->name }}</h2>

        <div class="card-deck mb-4">
            <div class="card">
                <div class="card-header text-center">
                    All languages ARB archive
                </div>
                <form method="POST" action="{{ route('projects.export-all', $project) }}" class="card-body">
                    @csrf
                    <p>Archive with one <code>intl_&lt;lang&gt;.arb</code> file for every project language.</p>
                    <button class="btn btn-primary btn-block btn-lg">Export (zip)</button>
                </form>
            </div>
            <div class="card">
                <div class="card-header text-center">
                    Specific language ARB
                </div>
                <form method="POST" action="{{ route('projects.export-language', $project) }}" class="card-body">
                    @csrf
                    <p>One, specific language <code>intl_&lt;lang&gt;.arb</code> file.</p>
                    <div class="form-group">
                        <label for="language">Language</label>
                        <select id="language" class="form-control" name="language" required>
                            @include('partials.languages-options', [
                                'languages' => $project->languages,
                                'selected' => fn($language) => false,
                            ])
                        </select>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg">Export (arb)</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#language').selectpicker({
            liveSearch: true,
        });
    </script>
@endpush
