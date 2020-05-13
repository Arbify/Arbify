@if($message->isMessage())
    <label for="{{ $label }}.message" class="sr-only"></label>
    <input type="text" class="form-control" id="{{ $label }}.message">
@elseif($message->isPlural())
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_ZERO)
        <div class="form-group row">
            <label for="{{ $label }}.zero" class="col-form-label message-type-col">
                <span class="badge badge-light">ZERO</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.zero" class="form-control">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_ONE)
        <div class="form-group row">
            <label for="{{ $label }}.one" class="col-form-label message-type-col">
                <span class="badge badge-light">ONE</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.one" class="form-control">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_TWO)
        <div class="form-group row">
            <label for="{{ $label }}.two" class="col-form-label message-type-col">
                <span class="badge badge-light">TWO</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.two" class="form-control">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_FEW)
        <div class="form-group row">
            <label for="{{ $label }}.few" class="col-form-label message-type-col">
                <span class="badge badge-light">FEW</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.few" class="form-control">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_MANY)
        <div class="form-group row">
            <label for="{{ $label }}.many" class="col-form-label message-type-col">
                <span class="badge badge-light">MANY</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.many" class="form-control">
            </div>
        </div>
    @endif
    @if($language->getPluralForms() & \App\Language::PLURAL_FORM_OTHER)
        <div class="form-group row">
            <label for="{{ $label }}.other" class="col-form-label message-type-col">
                <span class="badge badge-light">OTHER</span>
            </label>
            <div class="col">
                <input type="text" id="{{ $label }}.other" class="form-control">
            </div>
        </div>
    @endif
@elseif($message->isGender())
    <div class="form-group row">
        <label for="lol" class="col-form-label col-1" style="flex: 0 0 52px; max-width: 52px">
            <span class="badge badge-light">MALE</span>
        </label>
        <div class="col">
            <input type="text" id="lol" class="form-control">
        </div>
    </div>
    <input type="text" class="form-control">
    <input type="text" class="form-control">
    <input type="text" class="form-control">
@endif
