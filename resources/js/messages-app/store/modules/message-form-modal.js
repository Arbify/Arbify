import * as urls from '../../urls';
import camelcaseKeys from 'camelcase-keys';

const state = () => ({
    loading: false,
    action: 'new', // or edit
    data: {
        name: '',
        description: '',
        type: 'message',
    },
    errors: {},
});

const getters = {
    loading: (state) => state.loading,
    action: (state) => state.action,
    errors: (state) => state.errors,
};

const mutations = {
    startLoading(state) {
        state.loading = true;
    },
    stopLoading(state) {
        state.loading = false;
    },
    prepare(state, message = null) {
        state.action = message === null ? 'new' : 'edit';
        state.errors = {};

        if (message !== null) {
            state.data = message;
        } else {
            state.data = {
                name: '',
                description: '',
                type: 'message',
            };
        }
    },
    updateData(state, data) {
        state.data = { ...state.data, ...data };
    },
    updateErrors(state, errors) {
        state.loading = false;
        state.errors = errors;
    },
};

const actions = {
    submit({ state, commit, rootGetters }, { onSuccess }) {
        commit('startLoading');

        const storing = state.action === 'new';
        axios.request({
            method: storing ? 'POST' : 'PATCH',
            url: storing ? urls.storeMessage(rootGetters.projectId)
                : urls.updateMessage(rootGetters.projectId, state.data.id),
            data: state.data,
        }).then(({ data }) => {
            commit('stopLoading');
            commit('data/addOrUpdateMessage', camelcaseKeys(data.data), { root: true });
            onSuccess?.call();
        }).catch(error => {
            if (error.response.status !== 422) {
                console.error(error);
                return;
            }

            commit('updateErrors', error.response.data.errors);
        });
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};
