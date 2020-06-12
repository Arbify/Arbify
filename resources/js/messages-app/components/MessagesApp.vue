<template>
    <div v-if="loading" class="mt-5 flex-center">
        <span class="spinner-border"></span>
    </div>
    <div v-else class="d-flex justify-content-center">
        <div class="table-responsive w-auto">
            <table
                :class="['messages-table', 'table', 'table-bordered', 'table-hover', 'bg-white', overflowing ? 'overflowing' : '']">
                <colgroup>
                    <col style="width: 300px">
                    <col style="width: 400px" v-for="language in languages" :key="language.id">
                </colgroup>
                <thead>
                    <tr>
                        <th>
                            <div class="d-flex align-items-center">
                                Message
                                <NewMessageButton v-if="canCreateMessages" class="ml-auto" />
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
        <MessageValuesHistoryModal />
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import NewMessageButton from './NewMessageButton';
    import LanguageHeaderCell from './LanguageHeaderCell';
    import MessageFormModal from './MessageFormModal';
    import MessageRow from './MessageRow';
    import MessageValuesHistoryModal from './MessageValuesHistoryModal';

    export default {
        components: { MessageValuesHistoryModal, MessageRow, NewMessageButton, LanguageHeaderCell, MessageFormModal },
        props: ['projectId'],
        data() {
            return { overflowing: false };
        },
        computed: {
            ...mapGetters({
                loading: 'data/loading',
                languages: 'data/languages',
                messages: 'data/messages',
                canCreateMessages: 'data/canCreateMessages',
            }),
        },
        created: function () {
            this.$store.commit('setProjectId', this.projectId);
            this.$store.dispatch('data/loadAll', {
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
