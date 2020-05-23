@extends('layout')

@section('content')
    <div class="container">
        @formsection(isset($language) ? "Edit $language->code" : 'New language')
            @isset($language)
                <form method="POST" action="{{ route('languages.update', $language) }}">
                @method('PATCH')
            @else
                <form method="POST" action="{{ route('languages.store') }}">
            @endisset

                @csrf
                <div class="form-group row">
                    <label for="code" class="col-md-4 col-form-label text-md-right">Language code</label>

                    <div class="col-md-6">
                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code', $language->code ?? '') }}" required autofocus>

                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <span class="form-text">
                            <a href="https://en.wikipedia.org/wiki/ISO_639-1">Usually ISO 639-1.</a>
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Language name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $language->name ?? '') }}">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <span class="form-text text-muted">Optional.</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="flag" class="col-md-4 col-form-label text-md-right">Flag</label>

                    <div class="col-md-6">
                        <select name="flag" id="flag" class="form-control @error('flag') is-invalid @enderror">
                            <option value="">None</option>
                            <option data-divider="true"></option>
                            @foreach($countryFlags as $flag)
                                <option value="{{ $flag }}" @if(old('flag', $language->flag ?? '') == $flag) selected @endif>{{ $flag }}</option>
                            @endforeach
                        </select>

                        @error('flag')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <span class="col-md-4 col-form-label text-md-right">Plural forms</span>

                    <div class="col-md-6 pt-2">
                        @foreach(array_keys(App\Models\Language::PLURAL_FORMS) as $form)
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="plural_forms.{{ $form }}"
                                       name="plural_forms[]" value="{{ $form }}" @if(isset($language) && in_array($form, $language->plural_forms)) checked @endif>
                                <label class="custom-control-label" for="plural_forms.{{ $form }}">
                                    <span class="badge badge-light">{{ strtoupper($form) }}</span>
                                </label>
                            </div>
                        @endforeach

                        @error('plural_forms')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            @isset($language)
                                Update language
                            @else
                                Create language
                            @endisset
                        </button>
                    </div>
                </div>
            </form>
        @endformsection
    </div>
@endsection

@push('scripts')
    <script>
        $('#flag').selectpicker({
            liveSearch: true,
        });
    </script>
@endpush
