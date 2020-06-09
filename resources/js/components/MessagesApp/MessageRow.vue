<template>
    <tr>
        <th scope="row">
            <div class="row-content">
                <code class="name">{{ message.name }}</code>

                <div>
                    <span class="type badge badge-light" v-if="message.type === 'plural'">PLURAL</span>
                    <span class="type badge badge-light" v-else-if="message.type === 'gender'">GENDER</span>

                    <a href="#" @click.prevent="onEdit" class="text-primary small">edit</a>
                </div>
            </div>

            <small class="description" v-if="message.description">{{ message.description }}</small>
        </th>
        <MessageLanguageCell v-for="language in languages" :key="language.id"
                             :message-id="messageId" :language-id="language.id" />
    </tr>
</template>

<script>
    import {mapGetters} from 'vuex';
    import MessageLanguageCell from './MessageLanguageCell';

    export default {
        components: {MessageLanguageCell},
        props: ['messageId'],
        computed: {
            ...mapGetters(['languages']),
            message() {
                return this.$store.getters.messageById(this.messageId);
            }
        },
        methods: {
            onEdit() {
                this.$store.commit('prepareMessageFormModal', this.messageId);
                $('#message-form-modal').modal('show');
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
