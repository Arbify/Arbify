@extends('layout')

@section('content')
    <div class="container">
        @formsection("Import - $project->name")
            <form method="POST" action="{{ route('projects.import-upload', $project) }}" enctype="multipart/form-data">
                @csrf

                <p class="alert alert-warning mb-4">
                    <b>Warning!</b> This importer still lacks many features. It imports messages
                    only as simple messages. It does not support plural or gender message types yet. You may
                    (but do not have to) encounter some unwanted behaviors while importing.
                </p>

                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {!! session('success') !!}
                    </div>
                @endif

                <div class="form-group row">
                    <label for="files" class="col-md-4 col-form-label text-md-right">File(s)</label>

                    <div class="col-md-6">
                        <input id="files" type="file" class="@error('files.*') is-invalid @enderror" name="files[]" required multiple>

                        @error('files.*')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <span class="col-md-4 col-form-label text-md-right">Options</span>

                    <div class="col-md-6 pt-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="override_message_values" name="override_message_values" value="1"
                                   class="custom-control-input" @if(old('override_message_values')) checked @endif>
                            <label for="override_message_values" class="custom-control-label">
                                <b class="d-block">Override message values</b>
                                <span class="d-block mt-1 mb-2">When value for a given message in a given language already exists, override it with the value from the imported file(s).</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Import
                        </button>
                    </div>
                </div>
            </form>
        @endformsection
    </div>
@endsection

@push('scripts')
    <script>
        $('#files').filepond({
            server: {
                url: '/filepond',
                headers: {
                    'Accept': 'application/json, text/plain'
                }
            },
        });
    </script>
@endpush
