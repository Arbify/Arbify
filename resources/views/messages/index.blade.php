@extends('layout')

@section('content')
    <div class="container">
        <h2 class="mb-4">Messages - {{ $project->name }}</h2>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif
    </div>

    <div class="container-fluid d-flex justify-content-center">
        <div class="table-responsive w-auto">
            <table class="table table-striped table-bordered bg-white w-auto" style="table-layout: fixed">
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
                        <th class="align-middle">
                            {{ $language->code }} - {{ $language->name }}
                            <form method="POST"
                                  action="{{ route('projects.languages.destroy', [$project, $language]) }}"
                                  class="d-inline float-right delete-modal-show" data-delete-modal-title="Deleting language from project"
                                  data-delete-modal-body="<b>{{ $language->code }}</b> from <b>{{ $project->name }}</b>">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link btn-sm text-danger p-0" style="font-size: 80%">
                                    delete
                                </button>
                            </form>
                        </th>
                    @endforeach
                    <th>
                        <a href="{{ route('projects.languages.create', $project) }}" class="btn btn-primary">Add
                            language</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($project->messages as $message)
                    <tr>
                        <th scope="row" class="font-weight-normal">
                            <div class="d-flex flex-wrap align-items-baseline">
                                <strong><code class="d-block mb-1 mr-2">{{ $message->name }}</code></strong>

                                <div>
                                    @if($message->isPlural())
                                        <span class="badge badge-light mr-2">PLURAL</span>
                                    @elseif($message->isGender())
                                        <span class="badge badge-light mr-2">GENDER</span>
                                    @endif
                                    <a href="{{ route('messages.edit', [$project, $message]) }}" class="small">edit</a>
                                    <form method="post" action="{{ route('messages.destroy', [$project, $message]) }}"
                                          class="d-inline ml-2 delete-modal-show"
                                          data-delete-modal-title="Deleting message" data-delete-modal-body="<code>{{ $message->name }}</code> message">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-link btn-sm text-danger p-0" style="font-size: 80%">
                                            delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <small class="d-block mt-2">{{ $message->description }}</small>
                        </th>
                        @foreach($project->languages as $language)
                            <td>
                                @include('messages.partials.message-inputs', [
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
                        <a href="{{ route('messages.create', $project) }}" class="btn btn-primary btn-block">Add
                            message</a>
                    </td>
                    <td colspan="{{ $project->languages->count() + 1 }}"></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
