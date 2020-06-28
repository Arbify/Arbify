<template>
        <thead>
            <tr>
                <th>
                    <div class="messages-header-cell">
                        Message
                        <NewMessageButton v-if="canCreateMessages" class="messages-header-cell--wrapping" />
                    </div>
                </th>
                <LanguageHeaderCell v-for="language in shownLanguages" :key="language.id"
                                    :language-id="language.id" />
                <th v-if="showCollapsedFlags"></th>
            </tr>
        </thead>
</template>

<script>
    import NewMessageButton from './NewMessageButton';
    import LanguageHeaderCell from './LanguageHeaderCell';

    export default {
        components: {
            NewMessageButton,
            LanguageHeaderCell,
        },
        props: ['shownLanguages', 'showCollapsedFlags', 'canCreateMessages'],
    };
</script>
