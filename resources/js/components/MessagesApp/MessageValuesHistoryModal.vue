<template>
    <div :id="modalId" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        History
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div v-if="loading" class="m-4 flex-center">
                        <span class="spinner-border"></span>
                    </div>
                    <template v-else-if="history.length">
                        <div v-for="item in history" class="diff-item">
                            <pre class="diff" v-html="item.diff"></pre>
                            <p class="small text-muted">
                                {{ formatTime(item.updatedAt) }} •
                                {{ item.author && item.author.username }}
                            </p>
                        </div>
                    </template>
                    <p v-else class="mt-3">No items in the history are available.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { HISTORY_MODAL_ID } from './consts';
    import moment from 'moment';
    import { mapGetters } from 'vuex';

    export default {
        computed: {
            ...mapGetters({ loading: 'historyModalLoading' }),
            modalId() {
                return HISTORY_MODAL_ID;
            },
            history() {
                return this.$store.state.historyModal;
            },
            formatTime() {
                return (time) => moment(time, moment.ISO_8601).format('LLL');
            },
        },
    };
</script>

<style lang="scss" scoped>
    .diff-item {
        margin: 1rem 0;

        &:not(:last-child) {
            border-bottom: 1px solid #dee2e6;
        }

        &:last-child p {
            margin-bottom: 0;
        }

        .diff {
            margin-bottom: 0.5rem;
        }
    }
</style>
