
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Please = require('pleasejs');
window.qrcode = require('qrcode-generator');

import TemplatesEdit from './containers/TemplatesEdit.vue';
import TemplatesIndex from './containers/TemplatesIndex.vue';

import TemplatesEditStore from './vuex/TemplatesEditStore';
import TemplatesIndexStore from './vuex/TemplatesIndexStore';

window.routes = {
    templates_index: { el: '#app', store: TemplatesIndexStore, render: h => h(TemplatesIndex) },
    templates_edit: { el: '#app', store: TemplatesEditStore, render: h => h(TemplatesEdit) }
}
