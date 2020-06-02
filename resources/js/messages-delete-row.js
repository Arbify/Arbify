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
