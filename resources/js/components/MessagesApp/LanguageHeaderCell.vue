<template>
    <th>
        <div class="d-flex align-items-center">
            <img v-if="language.flag" :src="language.flag" alt="" class="country-flag">

            {{ displayName }}

            <span class="translation-progress-bg">
                <span :class="progressClasses" :style="{ width: percentTranslated + '%' }"></span>
            </span>
            <small class="ml-auto messages-statistics">
                <span :class="statsClasses">
                    {{ language.stats.translated }}/{{ language.stats.all }}
                    ({{ percentTranslated }}%)
                </span>
            </small>
        </div>
    </th>
</template>

<script>
    export default {
        props: ['languageId'],
        computed: {
            language() {
                return this.$store.getters.languageById(this.languageId);
            },
            displayName() {
                return `${this.language.code} - ${this.language.name}`;
            },
            percentTranslated() {
                const percent = this.language.stats.translated / Math.max(this.language.stats.all, 1);

                return Math.round((percent + Number.EPSILON) * 100);
            },
            progressClasses() {
                return [
                    'translation-progress',
                    this.percentTranslated === 100 ? 'bg-success' : 'bg-info',
                ];
            },
            statsClasses() {
                if (this.percentTranslated === 100) {
                    return 'text-success';
                } else if (this.percentTranslated === 0) {
                    return 'text-danger';
                }

                return 'text-info';
            }
        },
    };
</script>
