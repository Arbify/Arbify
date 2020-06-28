<template>
    <colgroup>
        <col style="width: 300px">
        <col style="width: 400px" v-for="language in shownLanguages" :key="language.id">
        <col v-if="showCollapsedFlags" style="width: 70px">
    </colgroup>
</template>

<script>
    export default {
        props: ['shownLanguages', 'showCollapsedFlags'],
    };
</script>
