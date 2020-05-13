@if($message->isMessage())
    @include('messages.partials.message-value-input', [
        'language' => $language,
        'message' => $message,
        'form' => null,
    ])
@elseif($message->isPlural())
    @foreach($language->getPluralForms() as $form)
        @include('messages.partials.message-value-input', [
            'language' => $language,
            'message' => $message,
            'form' => $form,
        ])
    @endforeach
@elseif($message->isGender())
    @foreach($language->getGenderForms() as $gender)
        @include('messages.partials.message-value-input', [
            'language' => $language,
            'message' => $message,
            'form' => $gender,
        ])
    @endforeach
@endif
