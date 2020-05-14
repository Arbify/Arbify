@extends('layout')

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
                                  class="d-inline float-right">
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
                                          class="d-inline ml-2">
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

@push('scripts')
    <script>
        (function () {
            const NULL_VALUE_SYMBOL = '$$null$$';
            const MESSAGE_FIELD_SELECTOR = '.message-field';
            const $forms = $('.message-value-form');

            $forms.find(MESSAGE_FIELD_SELECTOR).on('input', (e) => {
                const $input = $(e.target);
                if (isModified($input)) {
                    $input.addClass('is-modified').removeClass('is-accepted');
                } else {
                    $input.removeClass('is-modified');
                    if ($input.data('initialValue') != NULL_VALUE_SYMBOL) {
                        $input.addClass('is-accepted');
                    }
                }
            });

            $forms.on('submit', e => {
                e.preventDefault();

                const $form = $(e.target);
                const $input = $form.find(MESSAGE_FIELD_SELECTOR);
                const newValue = $input.val();
                if (isModified($input)) {
                    $.post($form.attr('action'), $form.serialize())
                        .done(() => {
                            $input
                                .removeClass('is-modified')
                                .data('initialValue', newValue);

                            if ($input.val() != '') {
                                $input.addClass('is-accepted')
                            }
                        });
                }
            });

            const isModified = $field => {
                return $field.val() != $field.data('initialValue')
                    && !($field.val() == '' && $field.data('initialValue') == NULL_VALUE_SYMBOL);
            };

            $(window).on('beforeunload', () => {
                let showWarning = false;

                $(MESSAGE_FIELD_SELECTOR).each((_, field) => {
                    if (field.classList.contains('is-modified')) {
                        // Focus only once, on the first field.
                        if (!showWarning) {
                            field.focus();
                        }

                        showWarning = true;
                    }
                });

                if (showWarning) {
                    return "You have some modified messages that weren't saved. Do you really want to leave the page?";
                }
            });
        })();
    </script>
@endpush
