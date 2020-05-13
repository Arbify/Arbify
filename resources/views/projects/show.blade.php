@extends('layouts.app')

@section('content')
    <h2 class="mb-5 container">Project: {{ $project->name }}</h2>

    <div class="container-fluid">
        <table class="table table-striped table-bordered bg-white">
            <colgroup>
                <col style="width: 300px">
                @foreach($project->languages as $language)
                    <col>
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
                        <a href="#" class="btn btn-primary">Add language</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($project->messages as $message)
                    <tr>
                        <td scope="row">
                            <code class="d-block mb-2">{{ $message->name }}</code>
                            @if($message->isPlural())
                                <span class="badge badge-light">PLURAL</span>
                            @elseif($message->isGender())
                                <span class="badge badge-light">GENDER</span>
                            @endif
                            <small class="d-block mt-2">{{ $message->description }}</small>
                        </td>
                        @foreach($project->languages as $language)
                            @php
                                $label = $message->name.'.'.$language->code
                            @endphp
                            <td>
                                @include('projects.message-inputs', [
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
@endsection
