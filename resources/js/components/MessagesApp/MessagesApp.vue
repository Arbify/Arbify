<template>
    <div class="d-flex justify-content-center">
        <div class="table-responsive w-auto">
            <table :class="['messages-table', 'table', 'table-bordered', 'table-hover', 'bg-white', overflowing ? 'overflowing' : '']">
                <colgroup>
                    <col style="width: 300px">
                    <col style="width: 400px" v-for="language in languages" :key="language.id">
                </colgroup>
                <thead>
                    <tr>
                        <th>
                            <div class="d-flex align-items-center">
                                Message
                                <NewMessageButton class="ml-auto" />
                            </div>
                        </th>
                        <LanguageHeaderCell v-for="language in languages" :key="language.id"
                                            :language-id="language.id" />
                    </tr>
                </thead>
                <tbody>
                    <MessageRow v-for="message in messages" :key="message.id" :message-id="message.id" />
                </tbody>
            </table>
        </div>

        <MessageFormModal />
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import NewMessageButton from './NewMessageButton';
    import LanguageHeaderCell from './LanguageHeaderCell';
    import MessageFormModal from './MessageFormModal';
    import MessageRow from './MessageRow';

    export default {
        components: { MessageRow, NewMessageButton, LanguageHeaderCell, MessageFormModal },
        props: ['projectId'],
        data() {
            return {
                overflowing: false,
            };
        },
        computed: {
            ...mapGetters(['languages', 'messages']),
        },
        created: function () {
            this.$store.dispatch('loadAll', {
                projectId: this.projectId,
                onLoad: () => this.updateTableWidth(),
            });

            this.updateTableWidth();
            window.addEventListener('resize', this.updateTableWidth);
        },
        destroyed: function () {
            window.removeEventListener('resize', this.updateTableWidth);
        },
        methods: {
            updateTableWidth() {
                const width = 300 + 400 * this.languages.length;
                this.overflowing = window.innerWidth >= width;
            }
        },
    };
</script>

<style lang="scss" scoped>
    .overflowing {
        width: initial;
    }
</style>
