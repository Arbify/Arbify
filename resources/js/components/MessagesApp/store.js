import Vue from 'vue';
import Vuex from 'vuex';
import camelcaseKeys from 'camelcase-keys';
import * as urls from './urls';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        appLoading: false,
        projectId: null,
        languages: [],
        messages: [],
        messageValues: [],

        messageFormModalLoading: false,
        messageFormModal: {
            action: 'new', // or edit
            data: {
                name: '',
                description: '',
                type: 'message',
            },
            errors: {},
        },

        historyModalLoading: false,
        historyModal: [],
    },
    getters: {
        appLoading: (state) => state.appLoading,
        languages: (state) => state.languages,
        languageById: (state) => (id) => state.languages.find(l => l.id === id),
        messages: (state) => state.messages,
        messageById: (state) => (id) => state.messages.find(m => m.id === id),
        messageValues: (state) => state.messageValues,
        messageValueBy: (state) => (languageId, messageId, form) => state.messageValues.find(
            mv => mv.languageId === languageId && mv.messageId === messageId && mv.form === form
        ),

        messageFormModalLoading: (state) => state.messageFormModalLoading,
        historyModalLoading: (state) => state.historyModalLoading,
    },
    mutations: {
        appStartLoading(state) {
            state.appLoading = true;
        },
        loadAll(state, { projectId, languages, messages, values }) {
            state.appLoading = false;
            state.projectId = projectId
            state.languages = languages;
            state.messages = messages;
            state.messageValues = values;
        },
        addOrUpdateMessage(state, message) {
            state.messageFormModalLoading = false;

            if (state.messages.some(m => m.id === message.id)) {
                state.messages = state.messages.map(m => {
                    if (m.id !== message.id) {
                        return m;
                    }

                    return message;
                });
            } else {
                state.messages.push(message);
            }
        },
        deleteMessage(state, messageId) {
            state.messages = state.messages.filter(m => m.id !== messageId);
            state.messageValues = state.messageValues.filter(mv => mv.messageId !== messageId);
        },
        updateMessageValue(state, messageValue) {
            state.messageValues = state.messageValues.filter(
                mv => !(mv.languageId === messageValue.languageId && mv.messageId === messageValue.messageId
                    && mv.form === messageValue.form)
            );

            state.messageValues.push(messageValue);
        },

        prepareMessageFormModal(state, messageId = null) {
            state.messageFormModal.action = messageId === null ? 'new' : 'edit';
            state.messageFormModal.errors = {};

            if (messageId !== null) {
                state.messageFormModal.data = state.messages.find(m => m.id === messageId);
            } else {
                state.messageFormModal.data = {
                    name: '',
                    description: '',
                    type: 'message',
                };
            }
        },
        messageFormModalUpdate(state, data) {
            state.messageFormModal.data = { ...state.messageFormModal.data, ...data };
        },
        messageFormModalStartLoading(state) {
            state.messageFormModalLoading = true;
        },
        messageFormModalErrors(state, errors) {
            state.messageFormModalLoading = false;
            state.messageFormModal.errors = errors;
        },

        historyModalStartLoading(state) {
            state.historyModalLoading = true;
        },
        historyModalUpdate(state, history) {
            state.historyModalLoading = false;
            state.historyModal = history;
        },
    },
    actions: {
        loadAll({ commit }, { projectId, onLoad }) {
            commit('appStartLoading');

            axios.get(urls.messageData(projectId)).then(({ data }) => {
                commit('loadAll', {
                    projectId: projectId,
                    ...camelcaseKeys(data, { deep: true })
                });
                onLoad?.call();
            });
        },
        deleteMessage({ commit, state }, messageId) {
            axios.delete(urls.deleteMessage(state.projectId, messageId))
                .then(() => {
                    commit('deleteMessage', messageId);
                });
        },
        saveMessageValue({ state, commit }, { languageId, messageId, form, value }) {
            axios.put(
                urls.putMessageValue(state.projectId, messageId, languageId, form),
                { value: value }
            ).then(({ data }) => {
                commit('updateMessageValue', camelcaseKeys(data));
            });
        },

        submitMessageFormModal({ state, commit }, { onSuccess }) {
            commit('messageFormModalStartLoading');

            const storing = state.messageFormModal.action === 'new';
            axios.request({
                method: storing ? 'POST' : 'PATCH',
                url: storing ? urls.storeMessage(state.projectId)
                    : urls.updateMessage(state.projectId, state.messageFormModal.data.id),
                data: state.messageFormModal.data,
            }).then(({ data }) => {
                commit('addOrUpdateMessage', camelcaseKeys(data));
                onSuccess?.call();
            }).catch(error => {
                if (error.response.status !== 422) {
                    console.error(error);
                    return;
                }

                commit('messageFormModalErrors', error.response.data.errors);
            });
        },

        fetchMessageValuesHistoryModal({ state, commit }, { messageId, languageId, form }) {
            commit('historyModalStartLoading');

            axios.get(urls.messageValueHistory(state.projectId, messageId, languageId, form)).then(({ data }) => {
                commit('historyModalUpdate', camelcaseKeys(data, { deep: true }));
            });
        }
    },
});

export default store;
