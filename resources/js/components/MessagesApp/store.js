import Vue from 'vue';
import Vuex from 'vuex';
import camelcaseKeys from 'camelcase-keys';
import * as urls from './urls';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        projectId: null,
        languages: [],
        messages: [],
        messageValues: [],

        messageFormModal: {
            action: 'new', // or edit
            data: {
                name: '',
                description: '',
                type: 'message',
            },
            errors: {},
        }
    },
    getters: {
        languages: (state) => state.languages,
        languageById: (state) => (id) => state.languages.find(l => l.id === id),
        messages: (state) => state.messages,
        messageById: (state) => (id) => state.messages.find(m => m.id === id),
        messageValueBy: (state) => (languageId, messageId, form) => state.messageValues.find(
            mv => mv.languageId === languageId && mv.messageId === messageId && mv.form === form
        ),
    },
    mutations: {
        loadAll(state, { projectId, languages, messages, values }) {
            state.projectId = projectId
            state.languages = languages;
            state.messages = messages;
            state.messageValues = values;
        },
        addOrUpdateMessage(state, message) {
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
        messageFormModalErrors(state, errors) {
            state.messageFormModal.errors = errors;
        },
    },
    actions: {
        loadAll({ commit }, { projectId, onLoad }) {
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
    },
});

export default store;
