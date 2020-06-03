const GLOBAL_MODAL_SELECTOR = '#global-modal';
const GLOBAL_MODAL_TITLE_SELECTOR = '#global-modal-title';
const GLOBAL_MODAL_BODY_SELECTOR = '#global-modal-body';
const GLOBAL_MODAL_ACTION_SELECTOR = '#global-modal-action';

const DELETE_MODAL_SHOW_SELECTOR = '.delete-modal-show';

const $modal = $(GLOBAL_MODAL_SELECTOR);

$(DELETE_MODAL_SHOW_SELECTOR).submit(e => {
    e.preventDefault();

    const oldModalHtml = $modal.html();

    const $modalTitle = $(GLOBAL_MODAL_TITLE_SELECTOR);
    const $modalBody = $(GLOBAL_MODAL_BODY_SELECTOR);
    const $modalAction = $(GLOBAL_MODAL_ACTION_SELECTOR);

    const $form = $(e.target);
    const title = $form.data('deleteModalTitle');
    const body = $form.data('deleteModalBody');

    $modalTitle.text(title);
    $modalBody.html('Do you really want to delete ' + body + '?');
    $modalAction.text('Delete').removeClass('btn-primary').addClass('btn-danger');

    $modal.modal();

    $(GLOBAL_MODAL_ACTION_SELECTOR).click(() => {
        $form.unbind('submit').submit();
    });

    $modal.on('hidden.bs.modal', () => {
        $modal.html(oldModalHtml);
    });
});

export {
    GLOBAL_MODAL_SELECTOR,
    GLOBAL_MODAL_TITLE_SELECTOR,
    GLOBAL_MODAL_BODY_SELECTOR,
    GLOBAL_MODAL_ACTION_SELECTOR,
};
