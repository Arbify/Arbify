@extends('layout')

@section('content')
    <div class="container">
        @formsection("Add languages to $project->name")
            <form method="POST" action="{{ route('project-languages.store', $project) }}">
                @csrf
                <div class="form-group row">
                    <label for="languages" class="col-md-4 col-form-label text-md-right">Languages</label>

                    <div class="col-md-6">
                        <select id="languages" class="form-control @error('languages') is-invalid @enderror"
                                name="languages[]" multiple required autofocus>
                            @include('partials.languages-options', [
                                'languages' => $languages,
                                'selected' => fn($language) => in_array($language->id, old('languages', [])),
                            ])
                        </select>

                        @error('languages')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        @error('languages.*')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">Add languages</button>
                    </div>
                </div>
            </form>
        @endformsection
    </div>
@endsection

@push('scripts')
    <script>
        $('#languages').selectpicker({
            liveSearch: true,
            selectedTextFormat: 'count',
        });
    </script>
@endpush
