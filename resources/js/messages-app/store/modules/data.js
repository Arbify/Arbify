import * as urls from '../../urls';
import camelcaseKeys from 'camelcase-keys';

const state = () => ({
    projectId: null,

    loading: false,
    languages: [],
    messages: [],
    messageValues: [],
    canCreateMessages: null,
});

const getters = {
    projectId: (state) => state.projectId,

    loading: (state) => state.loading,
    languages: (state) => state.languages,
    languageById: (state) => (id) => state.languages.find(l => l.id === id),
    messages: (state) => state.messages,
    messageById: (state) => (id) => state.messages.find(m => m.id === id),
    messageValues: (state) => state.messageValues,
    messageValueBy: (state) => (languageId, messageId, form) => state.messageValues.find(
        mv => mv.languageId === languageId && mv.messageId === messageId && mv.form === form
    ),
    canCreateMessages: (state) => state.canCreateMessages,
};

const mutations = {
    startLoading(state) {
        state.loading = true;
    },
    loadAll(state, { languages, messages, values, canCreateMessages }) {
        languages.sort((a, b) => a.canPutValues ? -1 : 1)

        state.loading = false;
        state.languages = languages;
        state.messages = messages;
        state.messageValues = values;
        state.canCreateMessages = canCreateMessages;
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
        state.messageValues = state.messageValues.filter(mv => mv.messageId !== messageId);
    },
    updateMessageValue(state, messageValue) {
        state.messageValues = state.messageValues.filter(
            mv => !(mv.languageId === messageValue.languageId && mv.messageId === messageValue.messageId
                && mv.form === messageValue.form)
        );

        state.messageValues.push(messageValue);
    },
};

const actions = {
    loadAll({ commit, rootGetters }, { onLoad }) {
        commit('startLoading');

        axios.get(urls.messageData(rootGetters.projectId)).then(({ data }) => {
            commit('loadAll', {
                ...camelcaseKeys(data, { deep: true })
            });
            onLoad?.call();
        });
    },
    deleteMessage({ commit, rootGetters }, messageId) {
        axios.delete(urls.deleteMessage(rootGetters.projectId, messageId))
            .then(() => {
                commit('deleteMessage', messageId);
            });
    },
    saveMessageValue({ state, commit, rootGetters }, { languageId, messageId, form, value }) {
        axios.put(
            urls.putMessageValue(rootGetters.projectId, messageId, languageId, form),
            { message_value: value }
        ).then(({ data }) => {
            commit('updateMessageValue', camelcaseKeys(data));
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
