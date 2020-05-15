@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if(isset($language))
                        <div class="card-header">Edit <b>{{ $language->code }}</b></div>
                    @else
                        <div class="card-header">New language</div>
                    @endif

                    <div class="card-body">
                        @if(isset($language))
                            <form method="POST" action="{{ route('languages.update', $language) }}">
                            @method('PATCH')
                        @else
                            <form method="POST" action="{{ route('languages.store') }}">
                        @endif

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
                                <label for="flag" class="col-md-4 col-form-label text-md-right">Flag code</label>

                                <div class="col-md-6">
                                    <input id="flag" type="text" class="form-control @error('flag') is-invalid @enderror" name="flag" value="{{ old('flag', $language->flag ?? '') }}">

                                    @error('flag')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <span class="form-text text-muted">
                                        Optional. Codes from <a href="https://flagicons.lipis.dev/">here</a>.
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <span class="col-md-4 col-form-label text-md-right">Plural forms</span>

                                <div class="col-md-6 pt-2">
                                    @foreach(array_keys(App\Language::PLURAL_FORMS) as $form)
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" id="plural_forms.{{ $form }}"
                                                   name="plural_forms[]" value="{{ $form }}" @if(in_array($form, $language->plural_forms)) checked @endif>
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
                                        @if(isset($language))
                                            Update language
                                        @else
                                            Create language
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
