@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if(isset($project))
                        <div class="card-header">Edit <b>{{ $project->name }}</b></div>
                    @else
                        <div class="card-header">New project</div>
                    @endif

                    <div class="card-body">
                        @if(isset($project))
                            <form method="POST" action="{{ route('projects.update', $project) }}">
                            @method('PATCH')
                        @else
                            <form method="POST" action="{{ route('projects.store') }}">
                        @endif

                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Project name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $project->name ?? '') }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @if(isset($project))
                                            Update project
                                        @else
                                            Create project
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
