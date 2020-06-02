import { updateStatistics } from "./messages-table";

const SELECTOR = '.delete-row';

$(document).on('submit', SELECTOR, e => {
    e.preventDefault();

    // Hide other delete-row popovers.
    $(SELECTOR).popover('hide');

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
            $.post({
                url: $form.attr('action'),
                data: $form.serialize(),
            }).done(() => {
                $form.popover('hide');
                const $row = $form.closest('tr');
                $row.hide(400, () => {
                    $row.find('td').each((index, element) => {
                        const allFields = $(element).find('.message-field').length;
                        const nullFields = $(element).find('.message-field[data-initial-value="$$null$$"]').length;
                        const translatedFields = allFields - nullFields;

                        updateStatistics(index + 1, -allFields, -translatedFields);
                    });

                    $row.remove();
                });
            });
        });

    $form.popover({
        html: true,
        trigger: 'manual',
        title: 'Confirm deleting',
        content: $content,
    }).popover('show');
});
