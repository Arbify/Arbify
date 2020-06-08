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
        updateMessageValue(state, messageValue) {
            state.messageValues = state.messageValues.filter(
                mv => !(mv.languageId === messageValue.languageId && mv.messageId === messageValue.messageId
                    && mv.form === messageValue.form)
            );

            state.messageValues.push(messageValue);
        },
    },
    actions: {
        loadAll({ commit }, projectId) {
            axios.get(urls.messageData(projectId)).then(({ data }) => {
                commit('loadAll', {
                    projectId: projectId,
                    ...camelcaseKeys(data, {deep: true})
                });
            });
        },
        saveMessageValue({ state, commit }, { languageId, messageId, form, value }) {
            axios.put(
                urls.putMessageValue(state.projectId, messageId, languageId, form),
                { value: value }
            ).then(({ data }) => {
                commit('updateMessageValue', camelcaseKeys(data, {deep: true}));
            });
        }
    }
});

export default store;
