@extends('administration.layout')

@section('administration-content')
    <div class="container d-flex flex-column align-items-center">
        <form action="{{ route('administration.update-settings') }}" method="POST" class="col-10">
            @csrf

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {!! session('success') !!}
                </div>
            @endif

            <div class="card card-body mb-4">
                <div class="row">
                    <span class="col-md-6 col-form-label text-md-right">User registration</span>
                    <div class="col-md-6 pt-2">
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" class="custom-control-input" id="registration_enabled.enabled" name="registration_enabled"
                                   value="1" @if(old('registration_enabled', Settings::registrationEnabled())) checked @endif>
                            <label class="custom-control-label" for="registration_enabled.enabled">
                                Enabled
                            </label>
                        </div>

                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" class="custom-control-input" id="registration_enabled.disabled" name="registration_enabled"
                                   value="0" @unless(old('registration_enabled', Settings::registrationEnabled())) checked @endif>
                            <label class="custom-control-label" for="registration_enabled.disabled">
                                Disabled
                            </label>
                        </div>

                        @error('registration_enabled')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card card-body mb-4">
                <div class="row">
                    <label for="default_language" class="col-md-6 col-form-label text-md-right">Default project language</label>
                    <div class="col-md-6">
                        <select name="default_language" id="default_language"
                                class="form-control @error('default_language') is-invalid @enderror" required>
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}" @if(old('default_language', Settings::defaultLanguage()) == $language->id) selected @endif>
                                    {{ $language->getDisplayName() }}
                                </option>
                            @endforeach
                        </select>

                        @error('default_language')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-primary d-block mx-auto" value="Update settings">
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $('#default_language').selectpicker({
            liveSearch: true,
        });
    </script>
@endpush
