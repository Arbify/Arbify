@extends('projects.layout')

@section('project-content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {!! session('success') !!}
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-center">
        <div class="table-responsive w-auto">
            <table class="messages-table table table-striped table-bordered bg-white" style="table-layout: fixed">
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
                                @can('create', [Arbify\Models\Message::class, $project])
                                    <a href="{{ route('messages.create', $project) }}" class="btn btn-primary ml-auto new-message">
                                        New message
                                    </a>
                                @endcan
                            </div>
                        </th>
                        @foreach($project->languages as $language)
                            <th>
                                <div class="d-flex align-items-center">
                                    @if(!is_null($language->flag))
                                        <img src="{{ asset("storage/flags/$language->flag.svg") }}" alt="" class="country-flag">
                                    @endif

                                    {{ $language->getDisplayName() }}

                                    @php $stats = $statistics[$language->code]; @endphp
                                    <span class="translation-progress-bg">
                                        <span class="translation-progress @if($stats['percent'] == 100) bg-success @else bg-info @endif"
                                              style="width: {{ $stats['percent'] }}%"></span>
                                    </span>
                                    <small class="ml-auto messages-statistics"
                                           data-all="{{ $stats['all'] }}" data-translated="{{ $stats['translated'] }}">
                                        @include('projects.messages.translation-progress', ['statistics' => $stats])
                                    </small>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($project->messages as $message)
                        @include('projects.messages.message-row', [
                            'project' => $project,
                            'message' => $message,
                            'messageValues' => $messageValues,
                        ])
                    @empty
                        <tr>
                            <td colspan="{{ $project->languages->count() + 1 }}">There are no messages.</td>
                        </tr>
                    @endforelse
                </tbody>
                @can('create', [Arbify\Models\Message::class, $project])
                    <tfoot>
                        <tr>
                            <td>
                                <a href="{{ route('messages.create', $project) }}" class="btn btn-primary btn-block new-message">New message</a>
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
