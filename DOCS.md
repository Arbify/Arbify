# Documentation

This is the documentation for the source code of Arbify.

## Delete confirmation modals

Just add `.delete-modal-show` class to the form that you intend to interrupt in order to confirm with the user if he really wants to delete given resource.

Under the hood, it stops `form`'s `submit` event and shows the modal instead and resumes submitting the form only if user clicked on the red *Delete* button.

Use `data-delete-modal-title` and `data-delete-modal-body` parameters of the `form` to set the messages in the modal.
