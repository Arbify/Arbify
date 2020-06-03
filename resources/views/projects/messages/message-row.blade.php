<tr>
    <th scope="row">
        <div class="d-flex flex-wrap align-items-baseline justify-content-between">
            <code class="d-block mb-1 mr-2">{{ $message->name }}</code>

            <div>
                @if($message->isPlural())
                    <span class="badge badge-light mr-2">PLURAL</span>
                @elseif($message->isGender())
                    <span class="badge badge-light mr-2">GENDER</span>
                @endif
                @can('update', [$message, $project])
                    <a href="{{ route('messages.edit', [$project, $message]) }}" class="small">edit</a>
                @endcan
                @can('delete', [$message, $project])
                    <form method="post" action="{{ route('messages.destroy', [$project, $message]) }}"
                          class="d-inline ml-2 delete-row"
                          data-delete-text="this message">
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
            @if($message->isMessage())
                @include('projects.messages.message-value-input', [
                    'language' => $language,
                    'message' => $message,
                    'messageValues' => $messageValues,
                    'form' => null,
                ])
            @elseif($message->isPlural())
                @foreach($language->plural_forms as $form)
                    @include('projects.messages.message-value-input', [
                        'language' => $language,
                        'message' => $message,
                        'messageValues' => $messageValues,
                        'form' => $form,
                    ])
                @endforeach
            @elseif($message->isGender())
                @foreach($language->getGenderForms() as $gender)
                    @include('projects.messages.message-value-input', [
                        'language' => $language,
                        'message' => $message,
                        'messageValues' => $messageValues,
                        'form' => $gender,
                    ])
                @endforeach
            @endif

        </td>
    @endforeach
</tr>
