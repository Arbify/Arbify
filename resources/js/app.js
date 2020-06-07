require('./bootstrap');
require('bootstrap-select');

window.FilePond = require('filepond');
require('jquery-filepond/filepond.jquery');

window.Vue = require('vue');

require('./global-modal');
require('./messages-table');
require('./messages-delete-row');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

import MessagesApp from './components/MessagesApp';

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

if (document.getElementById('messages-app')) {
    new Vue({
        el: '#messages-app',
        render: h => h(MessagesApp),
    });
}
