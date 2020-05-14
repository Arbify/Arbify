@php
    $label = $message->name . '.' . $language->code . (!is_null($form) ? '.' . $form ?? '' : '');
    $value = $message->valueForLanguage($language, $form);
@endphp

<div class="form-group row">
    @if(is_null($form))
        <label for="{{ $label }}" class="col-form-label message-type-col sr-only">Message</label>
    @else
        <label for="{{ $label }}" class="col-form-label message-type-col">
            <span class="badge badge-light">{{ strtoupper($form ?? '') }}</span>
        </label>
    @endif
    <div class="col">
        <form method="POST" action="{{ route('messages.values.put', [$project, $message, $language->code]) }}" class="message-value-form">
            @method('PUT')
            @csrf
            @if(!is_null($form))
                <input type="hidden" name="form" value="{{ $form }}">
            @endif
            <div class="input-group">
                <input type="text" id="{{ $label }}" name="value" class="form-control message-field @if(!is_null($value)) is-accepted @endif"
                       value="{{ $value ?? '' }}" data-initial-value="{{ $value ?? '' }}">
                <div class="input-group-append message-submit">
                    <input class="btn btn-outline-success" type="submit" value="✓" tabindex="-1">
                </div>
            </div>
        </form>
    </div>
</div>
