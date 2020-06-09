<template>
    <form @submit.prevent="onSubmit">
        <div id="message-form-modal" class="modal fade" tabindex="-1" role="dialog" @click.self="onClose">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <template v-if="action === 'new'">New message</template>
                            <template v-else>Editing message</template>
                        </h5>
                        <button type="button" class="close" @click="onClose" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Message name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" v-model="name" required autofocus
                                       :class="['form-control', errors.name ? 'is-invalid' : '']">

                                <span v-if="errors.name" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.name[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <textarea name="description" id="description" rows="5" v-model="description"
                                          :class="['form-control', errors.description ? 'is-invalid' : '']"></textarea>

                                <span v-if="errors.description" class="invalid-feedback"
                                      role="alert">
                                    <strong>{{ errors.description[0] }}</strong>
                                </span>

                                <span class="form-text text-muted">Optional.</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <span class="col-md-4 col-form-label text-md-right">Type</span>

                            <div class="col-md-6 pt-2">
                                <div class="custom-control custom-radio custom-control mb-1">
                                    <input type="radio" id="type.message" name="type" v-model="type" value="message"
                                           class="custom-control-input" :disabled="action === 'edit'">
                                    <label class="custom-control-label" for="type.message">
                                        Basic message
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control mb-1">
                                    <input type="radio" id="type.plural" name="type" v-model="type" value="plural"
                                           class="custom-control-input" :disabled="action === 'edit'">
                                    <label class="custom-control-label" for="type.plural">
                                        <span class="badge badge-light">PLURAL</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control">
                                    <input type="radio" id="type.gender" name="type" v-model="type" value="gender"
                                           class="custom-control-input" :disabled="action === 'edit'">
                                    <label class="custom-control-label" for="type.gender">
                                        <span class="badge badge-light">GENDER</span>
                                    </label>
                                </div>

                                <span v-if="errors.type" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.type[0] }}</strong>
                                </span>

                                <span class="form-text text-muted">
                                    Once you select the type, you cannot change it.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="onClose">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <template v-if="action === 'new'">Add message</template>
                            <template v-else>Update message</template>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        computed: {
            action() {
                return this.$store.state.messageFormModal.action;
            },
            name: {
                get() {
                    return this.$store.state.messageFormModal.data.name;
                },
                set(value) {
                    this.$store.commit('messageFormModalUpdate', {name: value});
                },
            },
            description: {
                get() {
                    return this.$store.state.messageFormModal.data.description;
                },
                set(value) {
                    this.$store.commit('messageFormModalUpdate', {description: value});
                },
            },
            type: {
                get() {
                    return this.$store.state.messageFormModal.data.type;
                },
                set(value) {
                    this.$store.commit('messageFormModalUpdate', {type: value});
                },
            },
            errors() {
                return this.$store.state.messageFormModal.errors;
            }
        },
        methods: {
            onSubmit(event) {
                this.$store.dispatch('submitMessageFormModal', {
                    onSuccess: () => this.onClose(),
                });
            },
            onClose() {
                $('#message-form-modal').modal('hide');
            },
        },
    };
</script>
