<template>
    <tr>
        <th scope="row">
            <div class="row-content">
                <code class="name">{{ message.name }}</code>

                <div>
                    <span class="type badge badge-light" v-if="message.type === 'plural'">PLURAL</span>
                    <span class="type badge badge-light" v-else-if="message.type === 'gender'">GENDER</span>

                    <a v-if="message.canUpdate" href @click.prevent="onUpdate" class="text-primary small mr-2">edit</a>
                    <a v-if="message.canDelete" href @click.prevent="onDelete"
                       :class="'text-danger small ' + deleteRowClass " ref="delete">delete</a>
                </div>
            </div>

            <small class="description" v-if="message.description">{{ message.description }}</small>
        </th>
        <MessageLanguageCell v-for="language in shownLanguages" :key="language.id"
                             :message-id="messageId" :language-id="language.id" />
    </tr>
</template>

<script>
    import { mapGetters } from 'vuex';
    import MessageLanguageCell from './MessageLanguageCell';
    import { MESSAGE_FORM_MODAL_ID } from '../consts';

    const DELETE_ROW_CLASS = 'delete-row';

    export default {
        components: { MessageLanguageCell },
        props: ['messageId', 'languageIds'],
        computed: {
            ...mapGetters({ languages: 'data/languages' }),
            shownLanguages() {
                return this.languageIds.map(id => this.languages.find(l => l.id === id));
            },
            message() {
                return this.$store.getters['data/messageById'](this.messageId);
            },
            deleteRowClass() {
                return DELETE_ROW_CLASS;
            },
        },
        methods: {
            onUpdate() {
                this.$store.commit('messageFormModal/prepare', this.message);
                $(`#${MESSAGE_FORM_MODAL_ID}`).modal('show');
            },
            onDelete() {
                const $delete = $(this.$refs.delete)
                const $content = $(`
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Do you really want to delete ${this.message.name}?</p>
                        <button class="btn btn-sm btn-outline-secondary ml-2">Cancel</button>
                        <button class="btn btn-sm btn-danger ml-2">Delete</button>
                    </div>
                `)
                    .on('click', '.btn-outline-secondary', () => $delete.popover('hide'))
                    .on('click', '.btn-danger', () => {
                        $delete.popover('hide');
                        this.$store.dispatch('data/deleteMessage', this.messageId);
                    });

                $(`.${DELETE_ROW_CLASS}`).popover('hide');

                $delete.popover({
                    html: true,
                    trigger: 'manual',
                    title: 'Confirm deleting',
                    content: $content,
                }).popover('show');
            },
        }
    };
</script>

<style lang="scss" scoped>
    .row-content {
        display: flex;
        flex-wrap: wrap;
        align-items: baseline;
        justify-content: space-between;
    }

    .name {
        margin: 0 0.5rem 0.25rem 0;
        display: block;
    }

    .type:not(:last-child) {
        margin-right: 0.5rem;
    }

    .description {
        margin-top: 0.5rem;
        display: block;
    }
</style>
