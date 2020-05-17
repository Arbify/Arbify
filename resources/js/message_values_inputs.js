(function () {
    const NULL_VALUE_SYMBOL = '$$null$$';
    const MESSAGE_FORM_SELECTOR = '.message-value-form';
    const MESSAGE_FIELD_SELECTOR = '.message-field';

    const CLASS_ACCEPTED = 'is-accepted';
    const CLASS_MODIFIED = 'is-modified';

    const $forms = $(MESSAGE_FORM_SELECTOR);

    $forms.find(MESSAGE_FIELD_SELECTOR).on('input', (e) => {
        const $input = $(e.target);
        if (isModified($input)) {
            $input.addClass(CLASS_MODIFIED).removeClass(CLASS_ACCEPTED);
        } else {
            $input.removeClass(CLASS_MODIFIED);
            if ($input.data('initialValue') != NULL_VALUE_SYMBOL) {
                $input.addClass(CLASS_ACCEPTED);
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
                        .removeClass(CLASS_MODIFIED)
                        .data('initialValue', newValue);

                    if ($input.val() != '') {
                        $input.addClass(CLASS_ACCEPTED)
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
            if (field.classList.contains(CLASS_MODIFIED)) {
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
