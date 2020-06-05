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
            <input type="text" id="{{ $label }}" name="value"
                   class="form-control message-field @if(!is_null($value)) is-accepted @endif"
                   value="{{ $value ?? '' }}" data-initial-value="{{ $value ?? '$$null$$' }}">
        </form>
    </div>
</div>
