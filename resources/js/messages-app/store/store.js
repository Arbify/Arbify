import Vue from 'vue';
import Vuex from 'vuex';
import dataModule from './modules/data';
import messageFormModalModule from './modules/message-form-modal';
import historyModalModule from './modules/history-modal';

Vue.use(Vuex);

export default new Vuex.Store({
    state: () => ({
        projectId: null,
    }),
    getters: {
        projectId: (state) => state.projectId,
    },
    mutations: {
        setProjectId(state, projectId) {
            state.projectId = projectId;
        },
    },

    modules: {
        data: dataModule,
        messageFormModal: messageFormModalModule,
        historyModal: historyModalModule,
    },
});
