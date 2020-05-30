@extends('layout')

@section('content')
    <div class="container">
        @formsection("Import - $project->name")
            <form method="POST" action="{{ route('projects.import-upload', $project) }}" enctype="multipart/form-data">
                @csrf

                <div class="alert alert-warning mb-4">
                    <pre class="mb-0">// This part is still a big work-in-progress. It may even not work at all!</pre>
                </div>

                <div class="form-group row">
                    <label for="files" class="col-md-4 col-form-label text-md-right">File(s)</label>

                    <div class="col-md-6">
                        <input id="files" type="file" class="@error('file') is-invalid @enderror" name="file[]" required multiple>

                        @error('file')
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
                            <input type="checkbox" id="override_message_values" name="override_message_values"
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
            server: '/filepond',
        });
    </script>
@endpush
