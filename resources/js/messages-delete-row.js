import {updateStatistics} from "./messages-table";

const SELECTOR = '.delete-row';

$(document).on('submit', SELECTOR, e => {
    e.preventDefault();

    const $form = $(e.target);
    const body = $form.data('deleteText');

    const $content = $(`
        <div class="d-flex align-items-center">
            <p class="mb-0">Do you really want to delete ${body}?</p>
            <button class="btn btn-sm btn-outline-secondary ml-2">Cancel</button>
            <button class="btn btn-sm btn-danger ml-2">Delete</button>
        </div>
    `)
        .on('click', '.btn-outline-secondary', () => $form.popover('hide'))
        .on('click', '.btn-danger', () => {
            $form.popover('hide');
            const $row = $form.closest('tr');
            $row.hide(400);

            $.ajax({
                type: 'DELETE',
                url: $form.attr('action'),
                data: $form.serialize(),
            }).done(() => {
                $row.find('td').each((index, element) => {
                    const allFields = $(element).find('.message-field').length;
                    const nullFields = $(element).find('.message-field[data-initial-value="$$null$$"]').length;
                    const translatedFields = allFields - nullFields;

                    updateStatistics(index + 1, -allFields, -translatedFields);
                });

                $row.remove();
            }).fail(() => {
                $row.show();
                console.error('XHR call failed');
            });
        });

    $form.popover({
        html: true,
        trigger: 'manual',
        title: 'Confirm deleting',
        content: $content,
    }).popover('show');
});

$(document).on('click', (e) => {
    $(SELECTOR).each((_, element) => {
        const $element = $(element);
        // hide any open popovers when the anywhere else in the body is clicked
        if ($('.popover').has(e.target).length === 0 && $element.is('[aria-describedby]')) {
            $element.popover('hide');
        }
    });
});
