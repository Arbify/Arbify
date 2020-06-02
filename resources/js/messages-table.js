const $messagesTable = $('.messages-table');

// Set width for table according to screen size.
const languagesCount = $messagesTable.find('thead tr').children().length - 1;
const columnsWidth = 300 + languagesCount * 400;
const updateTableWidth = () => {
    if ($(window).width() < columnsWidth) {
        $messagesTable.css('width', '');
    } else {
        $messagesTable.css('width', 'initial');
    }
};

updateTableWidth();
$(window).resize(updateTableWidth);

const NULL_VALUE_SYMBOL = '$$null$$';
const MESSAGE_FORM_SELECTOR = '.message-value-form';
const MESSAGE_FIELD_SELECTOR = '.message-field';
const CLASS_ACCEPTED = 'is-accepted';
const CLASS_MODIFIED = 'is-modified';

$messagesTable.on('input', MESSAGE_FIELD_SELECTOR, e => {
    const $field = $(e.target);
    updateField($field);
});

$messagesTable.on('submit', MESSAGE_FORM_SELECTOR, e => {
    e.preventDefault()

    const $field = $(e.target).find(MESSAGE_FIELD_SELECTOR);
    sendMessageValue($field);
});

$messagesTable.on('blur', MESSAGE_FIELD_SELECTOR, e => {
    const $field = $(e.target);
    sendMessageValue($field);
});

const sendMessageValue = $field => {
    if (!isModified($field)) return;

    const $form = $field.closest('form');
    const value = $field.val();
    const wasNull = isInitialValueNull($field);
    const isNull = value == '';

    const column = $field.closest('td').prevAll().length;

    $.post($form.attr('action'), $form.serialize())
        .done(() => {
            $field.data('initialValue', isNull ? NULL_VALUE_SYMBOL : value);
            updateField($field);

            if (wasNull && !isNull) {
                updateStatistics(column, 0, +1);
            } else if (!wasNull && isNull) {
                updateStatistics(column, 0, -1);
            }
        })
        .fail((error) => console.error(error));
}

const updateField = $field => {
    $field
        .toggleClass(CLASS_MODIFIED, isModified($field))
        .toggleClass(CLASS_ACCEPTED, isAccepted($field));

}

const isInitialValueNull = $field => $field.data('initialValue') == NULL_VALUE_SYMBOL;

const isModified = $field => {
    return $field.val() != $field.data('initialValue')
        // Field isn't modified if it was null and now it's empty.
        && !($field.val() == '' && isInitialValueNull($field));
};

const isAccepted = $field => {
    return !isModified($field) && !isInitialValueNull($field);
}

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

const updateStatistics = (column, allDelta, translatedDelta) => {
    const selector = `.messages-table thead th:nth-child(${column + 1}) .messages-statistics`;
    const $stats = $(selector);

    $stats.data('all', parseInt($stats.data('all')) + allDelta);
    const all = parseInt($stats.data('all'));

    $stats.data('translated', parseInt($stats.data('translated')) + translatedDelta);
    const translated = parseInt($stats.data('translated'));

    const percent = parseFloat((translated / all * 100).toFixed(2));

    $stats
        .toggleClass('text-success', percent == 100)
        .toggleClass('text-info', percent > 0 && percent < 100)
        .toggleClass('text-danger', percent == 0)
        .text(`${translated}/${all} (${percent}%)`);

    $stats.prev('.translation-progress-bg').find('.translation-progress')
        .toggleClass('bg-success', percent == 100)
        .toggleClass('bg-info', percent < 100)
        .css('width', `${percent}%`);
};

export { updateStatistics };
