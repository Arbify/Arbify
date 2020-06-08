require('./bootstrap');
require('bootstrap-select');

window.FilePond = require('filepond');
require('jquery-filepond/filepond.jquery');


require('./global-modal');
require('./messages-table');
require('./messages-delete-row');

import Vue from 'vue';
import store from './components/MessagesApp/store';
import MessagesApp from './components/MessagesApp/MessagesApp';

const messagesAppEl = document.getElementById('messages-app');

if (messagesAppEl) {
    const files = require.context('./', true, /\.vue$/i)
    files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

    new Vue({
        el: '#messages-app',
        render: h => h(MessagesApp, { props: { projectId: messagesAppEl.getAttribute('data-project-id') } }),
        store,
    });
}
