<template>
    <table class="messages-table table table-bordered bg-white">
        <colgroup>
            <col style="width: 300px">
            <col style="width: 400px" v-for="language in languages" :key="language.id">
        </colgroup>
        <thead>
            <tr>
                <th>
                    <div class="d-flex align-items-center">
                        Message
                        <a href="#" class="btn btn-primary ml-auto new-message">
                            New message
                        </a>
                    </div>
                </th>
                <LanguageHeaderCell v-for="language in languages" :key="language.id" :language-id="language.id" />
            </tr>
        </thead>
        <tbody>
            <MessageRow v-for="message in messages" :key="message.id" :message-id="message.id" />
        </tbody>
    </table>
</template>

<script>
    import { mapGetters } from 'vuex';
    import LanguageHeaderCell from './LanguageHeaderCell';
    import MessageRow from './MessageRow';

    export default {
        components: {MessageRow, LanguageHeaderCell},
        props: ['projectId'],
        computed: {
            ...mapGetters(['languages', 'messages']),
        },
        mounted() {
            this.$store.dispatch('loadAll', this.projectId);
        },
    };
</script>
