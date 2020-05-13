@php
    $label = $message->name.'.'.$language->code
@endphp

@if($message->isMessage())
    <label for="{{ $label }}" class="sr-only">Message</label>
    <input type="text" class="form-control" id="{{ $label }}" value="{{ $message->valueForLanguage($language) }}">
@elseif($message->isPlural())
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_ZERO)
        <div class="form-group row">
            <label for="{{ $label }}.zero" class="col-form-label message-type-col">
                <span class="badge badge-light">ZERO</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.zero" name="{{ $label }}.zero" class="form-control" value="{{ $message->valueForLanguage($language, 'zero') }}">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_ONE)
        <div class="form-group row">
            <label for="{{ $label }}.one" class="col-form-label message-type-col">
                <span class="badge badge-light">ONE</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.one" name="{{ $label }}.one" class="form-control" value="{{ $message->valueForLanguage($language, 'one') }}">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_TWO)
        <div class="form-group row">
            <label for="{{ $label }}.two" class="col-form-label message-type-col">
                <span class="badge badge-light">TWO</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.two" name="{{ $label }}.two" class="form-control" value="{{ $message->valueForLanguage($language, 'two') }}">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_FEW)
        <div class="form-group row">
            <label for="{{ $label }}.few" class="col-form-label message-type-col">
                <span class="badge badge-light">FEW</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.few" name="{{ $label }}.few" class="form-control" value="{{ $message->valueForLanguage($language, 'few') }}">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_MANY)
        <div class="form-group row">
            <label for="{{ $label }}.many" class="col-form-label message-type-col">
                <span class="badge badge-light">MANY</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.many" name="{{ $label }}.many" class="form-control" value="{{ $message->valueForLanguage($language, 'many') }}">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_OTHER)
        <div class="form-group row">
            <label for="{{ $label }}.other" class="col-form-label message-type-col">
                <span class="badge badge-light">OTHER</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.other" name="{{ $label }}.other" class="form-control" value="{{ $message->valueForLanguage($language, 'other') }}">
            </div>
        </div>
    @endif
@elseif($message->isGender())
    <div class="form-group row">
        <label for="{{ $label }}.male" class="col-form-label message-type-col">
            <span class="badge badge-light">MALE</span>
        </label>
        <div class="col">
            <input type="text" id="{{ $label }}.male" name="{{ $label }}.male" class="form-control" value="{{ $message->valueForLanguage($language, 'male') }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="{{ $label }}.female" class="col-form-label message-type-col">
            <span class="badge badge-light">FEMALE</span>
        </label>
        <div class="col">
            <input type="text" id="{{ $label }}.female" name="{{ $label }}.female" class="form-control" value="{{ $message->valueForLanguage($language, 'female') }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="{{ $label }}.other" class="col-form-label message-type-col">
            <span class="badge badge-light">OTHER</span>
        </label>
        <div class="col">
            <input type="text" id="{{ $label }}.other" name="{{ $label }}.other" class="form-control" value="{{ $message->valueForLanguage($language, 'other') }}">
        </div>
    </div>
@endif
