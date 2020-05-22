@extends('layout')

@section('content')
    <div class="container">
        @formsection("Add language to $project->name")
            <form method="POST" action="{{ route('project-languages.store', $project) }}">
                @csrf
                <div class="form-group row">
                    <label for="language" class="col-md-4 col-form-label text-md-right">Language</label>

                    <div class="col-md-6">
                        <select id="language" class="form-control @error('language') is-invalid @enderror" name="language" required autofocus>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}" @if(old('language') == $language->id) selected @endif>
                                    {{ $language->getDisplayName() }}
                                </option>
                            @endforeach
                        </select>

                        @error('language')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">Add language</button>
                    </div>
                </div>
            </form>
        @endformsection
    </div>
@endsection

@push('scripts')
    <script>
        $('#language').selectpicker({
            liveSearch: true,
        });
    </script>
@endpush
