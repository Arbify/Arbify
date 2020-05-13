@php
    $label = $message->name . '.' . $language->code . !is_null($form) ? ('.' . $form ?? '') : ''
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
        <input type="text" id="{{ $label }}" name="{{ $label }}" class="form-control"
               value="{{ $message->valueForLanguage($language, $form ?? '') }}">
    </div>
</div>
