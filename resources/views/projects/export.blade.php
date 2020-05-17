@extends('layout')

@section('content')
    <div class="container">
        <h2 class="mb-4">Export - {{ $project->name }}</h2>

        <div class="card-deck mb-4">
            <div class="card">
                <div class="card-header text-center">
                    All languages ARB archive
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur corporis dolores error ex facilis itaque nobis odit velit. Beatae debitis dignissimos exercitationem fugit ipsa ipsum molestiae numquam quo sit totam?</p>
                        <button class="btn btn-primary btn-block btn-lg">Export (zip)</button>
                        <button class="btn btn-primary btn-block btn-lg">Export (tar.gz)</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header text-center">
                    Specific language ARB
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('projects.export-language', $project) }}">
                        @csrf
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci assumenda commodi cum, eligendi et id iste maiores minima molestias neque nulla obcaecati praesentium quasi quia sint sit vero voluptates!</p>
                        <div class="form-group">
                            <label for="language">Language</label>
                            <select id="language" class="custom-select" name="language" required>
                                @foreach($project->languages()->getResults() as $language)
                                    <option value="{{ $language->id }}">{{ $language->getDisplayName() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg">Export (arb)</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
