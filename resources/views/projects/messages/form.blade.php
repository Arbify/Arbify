@extends('layout')

@section('content')
    <div class="container">
        @formsection(isset($message) ? "Edit $message->name in $project->name" : "New message in $project->name")
            @isset($message)
                <form method="POST" action="{{ route('messages.update', [$project, $message]) }}">
                @method('PATCH')
            @else
                <form method="POST" action="{{ route('messages.store', $project) }}" id="create-form">
            @endisset

                @csrf
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Message name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $message->name ?? '') }}" required autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                    <div class="col-md-6">
                        <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $message->description ?? '') }}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <span class="form-text text-muted">Optional.</span>
                    </div>
                </div>

                <div class="form-group row">
                    <span class="col-md-4 col-form-label text-md-right">Type</span>

                    @php $oldType = old('type', $message->type ?? 'message') @endphp

                    <div class="col-md-6 pt-2">
                        <div class="custom-control custom-radio custom-control mb-1">
                            <input type="radio" id="type.message" name="type" value="message" class="custom-control-input"
                                   @if($oldType == 'message') checked @endif required @isset($message) disabled @endisset>
                            <label class="custom-control-label" for="type.message">
                                Basic message
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control mb-1">
                            <input type="radio" id="type.plural" name="type" value="plural" class="custom-control-input"
                                   @if($oldType == 'plural') checked @endif required @isset($message) disabled @endisset>
                            <label class="custom-control-label" for="type.plural">
                                <span class="badge badge-light">PLURAL</span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control">
                            <input type="radio" id="type.gender" name="type" value="gender" class="custom-control-input"
                                   @if($oldType == 'gender') checked @endif required @isset($message) disabled @endisset>
                            <label class="custom-control-label" for="type.gender">
                                <span class="badge badge-light">GENDER</span>
                            </label>
                        </div>

                        @error('type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <span class="form-text text-muted">Once you select the type, you cannot change it.</span>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            @isset($message)
                                Update message
                            @else
                                Create message
                            @endisset
                        </button>
                    </div>
                </div>
            </form>
        @endformsection
    </div>
@endsection
