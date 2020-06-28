<template>
    <div v-if="loading" class="mt-5 flex-center">
        <span class="spinner-border"></span>
    </div>
    <div v-else class="d-flex justify-content-center">
        <div class="table-responsive w-auto">
            <table v-show="stickyHeaderShown" class="sticky-header messages-table table table-bordered bg-white">
                <TableColgroup :shown-languages="shownLanguages" :show-collapsed-flags="showCollapsedFlags" />
                <TableHeader :shown-languages="shownLanguages" :show-collapsed-flags="showCollapsedFlags"
                             :can-create-messages="canCreateMessages" />
            </table>
            <table class="messages-table table table-bordered table-hover bg-white" id="messages-table">
                <TableColgroup :shown-languages="shownLanguages" :show-collapsed-flags="showCollapsedFlags" />
                <TableHeader :shown-languages="shownLanguages" :show-collapsed-flags="showCollapsedFlags"
                             :can-create-messages="canCreateMessages" />

                <tbody>
                    <tr class="languages-overflow">
                        <td :colspan="shownLanguages.length + 1"></td>
                        <td v-if="showCollapsedFlags" :rowspan="messages.length + 2">
                            <div class="languages-overflow-items">
                                <a v-for="language in collapsedLanguages" href
                                   @click.prevent="() => onShowLanguage(language.id)" :title="language.displayName">
                                    <img v-if="language.flagUrl" :src="language.flagUrl" alt="" class="country-flag">
                                    <span v-else>{{ language.code }}</span>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <MessageRow v-for="message in messages" :key="message.id" :message-id="message.id"
                                :language-ids="shownLanguages.map(language => language.id)" />

                    <tr>
                        <td :colspan="shownLanguages.length + 1" class="text-center">
                            <NewMessageButton v-if="canCreateMessages" class="ml-auto" />
                        </td>
                    </tr>
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
    import TableHeader from './TableHeader';
    import TableColgroup from './TableColgroup';

    export default {
        components: {
            TableColgroup,
            TableHeader,
            MessageValuesHistoryModal,
            MessageRow,
            NewMessageButton,
            LanguageHeaderCell,
            MessageFormModal
        },
        props: ['projectId'],
        data() {
            return {
                shownLanguagesIds: [],
                stickyHeaderShown: false,
            };
        },
        computed: {
            ...mapGetters({
                loading: 'data/loading',
                languages: 'data/languages',
                languageById: 'data/languageById',
                messages: 'data/messages',
                canCreateMessages: 'data/canCreateMessages',
            }),
            shownLanguages() {
                return this.shownLanguagesIds.map(id => this.languages.find(l => l.id === id));
            },
            collapsedLanguages() {
                return this.languages.filter(language => !this.shownLanguagesIds.includes(language.id));
            },
            showCollapsedFlags() {
                return this.collapsedLanguages.length !== 0;
            }
        },
        created: function () {
            this.$store.commit('setProjectId', this.projectId);
            this.$store.dispatch('data/loadAll', {
                onLoad: () => this.updateShownLanguages(),
            });

            window.addEventListener('scroll', this.updateStickyHeader);

            this.updateShownLanguages();
            window.addEventListener('resize', this.updateShownLanguages);
        },
        destroyed: function () {
            window.removeEventListener('scroll', this.updateStickyHeader);
            window.removeEventListener('resize', this.updateShownLanguages);
        },
        methods: {
            updateStickyHeader() {
                const messagesTable = document.getElementById('messages-table');
                const offset = window.pageYOffset + messagesTable.getBoundingClientRect().top - window.scrollY;

                this.stickyHeaderShown = offset - 1 < 0;
            },
            updateShownLanguages() {
                const staticColsWidth = 370;
                const colWidth = 400;

                let columns = Math.floor((window.innerWidth - staticColsWidth) / colWidth);
                columns = columns > 1 ? columns : 1;

                while (this.shownLanguagesIds.length > columns) {
                    this.shownLanguagesIds.pop();
                }
                while (this.shownLanguagesIds.length < columns && this.collapsedLanguages.length > 0) {
                    this.shownLanguagesIds.push(this.collapsedLanguages[0].id);
                }
            },
            onShowLanguage(languageId) {
                this.shownLanguagesIds.shift();
                this.shownLanguagesIds.push(languageId);
            },
        },
    };
</script>

<style lang="scss" scoped>
    .sticky-header {
        position: fixed;
        top: 0;
        z-index: 10;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .2);
    }

    .languages-overflow {
        height: 0;

        &:hover {
            background: #fff;
        }

        td {
            text-align: center;
            vertical-align: top;

            &:nth-child(1) {
                padding: 0;
            }

            &:nth-child(2) {
                border-top-width: 3px;
            }
        }
    }

    .languages-overflow-items {
        display: flex;
        flex-direction: column;

        > * {
            margin-bottom: 1rem;
        }
    }
</style>
