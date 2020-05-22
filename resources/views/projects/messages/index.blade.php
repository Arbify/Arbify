@extends('projects.layout')

@section('project-content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif
    </div>

    <div class="container-fluid d-flex justify-content-center">
        <div class="table-responsive w-auto">
            <table class="messages-table table table-striped table-bordered bg-white w-auto" style="table-layout: fixed">
                <colgroup>
                    <col style="width: 300px">
                    @foreach($project->languages as $language)
                        <col style="width: 400px;">
                    @endforeach
                </colgroup>
                <thead>
                    <tr>
                        <th>
                            <div class="d-flex align-items-center">
                                Message
                                <a href="#" class="btn btn-primary ml-auto">Add message</a>
                            </div>
                        </th>
                        @foreach($project->languages as $language)
                            <th class="align-middle">{{ $language->getDisplayName() }}</th>
                        @endforeach
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
                                        @can('update', [App\Models\Message::class, $project])
                                            <a href="{{ route('messages.edit', [$project, $message]) }}" class="small">edit</a>
                                        @endcan
                                        @can('delete', [App\Models\Message::class, $project])
                                            <form method="post" action="{{ route('messages.destroy', [$project, $message]) }}"
                                                  class="d-inline ml-2 delete-modal-show"
                                                  data-delete-modal-title="Deleting message" data-delete-modal-body="<code>{{ $message->name }}</code> message">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-link btn-sm text-danger p-0" style="font-size: 80%">
                                                    delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>

                                <small class="d-block mt-2">{{ $message->description }}</small>
                            </th>
                            @foreach($project->languages as $language)
                                <td>
                                    @include('projects.messages.message-inputs', [
                                        'language' => $language,
                                        'message' => $message,
                                    ])
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                @can('create', [App\Models\Message::class, $project])
                    <tfoot>
                        <tr>
                            <td scope="row">
                                <a href="{{ route('messages.create', $project) }}" class="btn btn-primary btn-block">Add message</a>
                            </td>
                            @if($project->languages->count() > 0)
                                <td colspan="{{ $project->languages->count() }}"></td>
                            @endif
                        </tr>
                    </tfoot>
                @endcan
            </table>
        </div>
    </div>
@endsection
