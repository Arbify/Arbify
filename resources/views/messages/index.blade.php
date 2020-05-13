@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Messages - Project: {{ $project->name }}</h2>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif
    </div>

    <div class="container-fluid d-flex justify-content-center">
        <div class="table-responsive w-auto">
            <table class="table table-striped table-bordered bg-white">
                <colgroup>
                    <col style="width: 300px">
                    @foreach($project->languages as $language)
                        <col style="width: 400px;">
                    @endforeach
                    <col style="width: 146px">
                </colgroup>
                <thead>
                    <tr>
                        <th>Message</th>
                        @foreach($project->languages as $language)
                            <th>{{ $language->code }} - {{ $language->name }}</th>
                        @endforeach
                        <th>
                            <a href="{{ route('projects.add-language', $project) }}" class="btn btn-primary">Add language</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($project->messages as $message)
                        <tr>
                            <th scope="row">
                                <code class="d-block mb-2">{{ $message->name }}</code>
                                @if($message->isPlural())
                                    <span class="badge badge-light">PLURAL</span>
                                @elseif($message->isGender())
                                    <span class="badge badge-light">GENDER</span>
                                @endif
                                <small class="d-block mt-2">{{ $message->description }}</small>
                            </th>
                            @foreach($project->languages as $language)
                                <td>
                                    @include('messages.message-inputs', [
                                        'language' => $language,
                                        'message' => $message,
                                    ])
                                </td>
                            @endforeach
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td scope="row">
                            <a href="#" class="btn btn-primary btn-block">Add message</a>
                        </td>
                        <td colspan="{{ $project->languages->count() + 1 }}"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
