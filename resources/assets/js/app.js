
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Please = require('pleasejs');
window.qrcode = require('qrcode-generator');

import Templates from './containers/Templates.vue';

import EditorStore from './vuex/EditorStore';
import TemplatesStore from './vuex/TemplatesStore';

Vue.component('hello', require('./components/Hello.vue'));

window.routes = {
    templates: { el: '#app', store: TemplatesStore, render: h => h(Templates) }
}
