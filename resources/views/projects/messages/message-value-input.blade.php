@php
    /**
      * @var \Arbify\Models\Message  $message
      * @var \Arbify\Models\Language $language
      * @var string|null          $form
      * @var array                $messageValues
      */
    $label = $message->name . '.' . $language->code . (!is_null($form) ? '.' . $form ?? '' : '');
    $value = $messageValues[$message->id][$language->id][$form] ?? null;
    $value = $value ? $value['value'] : null;
@endphp

<div class="form-group row">
    @if(isset($form))
        <label for="{{ $label }}" class="col-form-label message-type-col">
            <span class="badge badge-light">{{ strtoupper($form ?? '') }}</span>
        </label>
    @else
        <label for="{{ $label }}" class="col-form-label message-type-col sr-only">Message</label>
    @endif
    <div class="col">
        <form method="POST" action="{{ route('message-values.put', [$project, $message, $language->code, $form]) }}"
              class="message-value-form">
            @method('PUT')
            @csrf
            <div class="input-group">
                <input type="text" id="{{ $label }}" name="value"
                       class="form-control message-field @if(!is_null($value)) is-accepted @endif"
                       value="{{ $value ?? '' }}" data-initial-value="{{ $value ?? '$$null$$' }}">

                <div class="input-group-append">
                    <a href="#" class="btn btn-outline-secondary flex-center px-2" title="History">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18px" height="18px">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z" />
                        </svg>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
