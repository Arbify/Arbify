@foreach($languages as $language)
    <option value="{{ $language->id }}"
            @empty($language->flag))
                data-content="<span class='country-flag-selectpicker-placeholder'></span> {{ $language->getDisplayName() }}"
            @else
                data-content="<img src='{{ asset("storage/flags/$language->flag.svg") }}' alt='' class='country-flag-selectpicker'> {{ $language->getDisplayName() }}"
            @endif
            {{ $selected($language) ? 'selected' : '' }}>
        {{ $language->getDisplayName() }}
    </option>
@endforeach
