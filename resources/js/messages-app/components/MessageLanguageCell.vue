<template>
    <td v-if="message.type === 'message'">
        <MessageValueInput :message-id="message.id" :language-id="language.id" :form="null" />
    </td>
    <td v-else-if="message.type === 'plural'">
        <MessageValueInput v-for="(form, i) in language.pluralForms" :key="i" :form="form"
                           :message-id="message.id" :language-id="language.id" />
    </td>
    <td v-else-if="message.type === 'gender'">
        <MessageValueInput v-for="(form, i) in language.genderForms" :key="i" :form="form"
                           :message-id="message.id" :language-id="language.id" />
    </td>
</template>

<script>
    import MessageValueInput from './MessageValueInput';

    export default {
        components: { MessageValueInput },
        props: ['messageId', 'languageId'],
        computed: {
            message() {
                return this.$store.getters['data/messageById'](this.messageId);
            },
            language() {
                return this.$store.getters['data/languageById'](this.languageId);
            },
        }
    };
</script>
