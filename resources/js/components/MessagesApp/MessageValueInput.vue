<template>
    <div class="form-group row">
        <label v-if="form" :for="label" class="col-form-label message-type-col">
            <span class="badge badge-light">{{ form.toUpperCase() }}</span>
        </label>
        <label v-else :for="label" class="col-form-label message-type-col sr-only">Message</label>

        <div class="col message-value-form">
            <div class="input-group">
                <input type="text" :id="label" :class="inputClasses" v-model="value" @blur="onSave"
                       @keypress.enter="onSave">

                <div class="input-group-append">
                    <a href class="btn btn-outline-secondary flex-center px-2" title="History"
                       @click.prevent="onHistory">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18px"
                             height="18px">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { HISTORY_MODAL_ID } from './consts';

    export default {
        props: ['messageId', 'languageId', 'form'],
        data() {
            return {
                value: '',
            };
        },
        computed: {
            message() {
                return this.$store.getters.messageById(this.messageId);
            },
            language() {
                return this.$store.getters.languageById(this.languageId);
            },
            storedValue() {
                return this.$store.getters.messageValueBy(this.languageId, this.messageId, this.form);
            },
            label() {
                return `${this.messageId}.${this.languageId}.${this.form}`;
            },
            inputClasses() {
                return [
                    'form-control',
                    'message-field',
                    this.state === 'accepted' ? 'is-accepted' : '',
                ];
            },
            state() {
                if (this.storedValue && (
                    this.storedValue.value === this.value
                    || this.storedValue.value === null && this.value === ''
                )) {
                    return 'accepted';
                } else if (!this.storedValue && this.value === '') {
                    return 'empty';
                }

                return 'changed';
            },
        },
        mounted() {
            this.value = this.storedValue ? this.storedValue.value : '';
        },
        methods: {
            onSave() {
                if (this.state !== 'changed') return;

                this.$store.dispatch('saveMessageValue', {
                    languageId: this.languageId,
                    messageId: this.messageId,
                    form: this.form,
                    value: this.value,
                });
            },
            onHistory() {
                $(`#${HISTORY_MODAL_ID}`).modal('show');
                this.$store.dispatch('fetchMessageValuesHistoryModal', {
                    messageId: this.messageId,
                    languageId: this.languageId,
                    form: this.form,
                })
            },
        },
    };
</script>
