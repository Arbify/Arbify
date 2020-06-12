import * as urls from '../../urls';
import camelcaseKeys from 'camelcase-keys';

const state = () => ({
    loading: false,
    history: [],
});

const getters = {
    loading: (state) => state.loading,
};

const mutations = {
    startLoading(state) {
        state.loading = true;
    },
    update(state, history) {
        state.loading = false;
        state.history = history;
    },
};

const actions = {
    fetch({ state, commit, rootGetters }, { messageId, languageId, form }) {
        commit('startLoading');

        axios
            .get(urls.messageValueHistory(rootGetters.projectId, messageId, languageId, form))
            .then(({ data }) => {
            commit('update', camelcaseKeys(data, { deep: true }));
        });
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};
