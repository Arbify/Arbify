<template>
    <div>
        <button class="btn btn-primary" @click="click">New message</button>
    </div>
</template>

<script>
    import MessageFormModal from './MessageFormModal';
    import { MESSAGE_FORM_MODAL_ID } from '../consts';

    export default {
        components: { MessageFormModal },
        methods: {
            click() {
                this.$store.commit('messageFormModal/prepare');
                $(`#${MESSAGE_FORM_MODAL_ID}`).modal('show');
            },
        },
    };
</script>
