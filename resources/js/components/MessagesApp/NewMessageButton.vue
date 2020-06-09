<template>
    <div>
        <button class="btn btn-primary" @click="click">New message</button>
    </div>
</template>

<script>
    import MessageFormModal from './MessageFormModal';

    export default {
        components: { MessageFormModal },
        methods: {
            click() {
                this.$store.commit('prepareMessageFormModal');
                $('#message-form-modal').modal('show');
            },
        },
    };
</script>
