/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VModal from 'vue-js-modal';
// import axios from 'axios';
// import Swal from 'sweetalert2';
import Vue from 'vue'
import DatePicker from 'v-calendar/lib/components/date-picker.umd';
import { ServerTable, ClientTable, Event } from 'vue-tables-2';
import Multiselect from 'vue-multiselect';
import CKEditor from '@ckeditor/ckeditor5-vue';
import VueApexCharts from "vue-apexcharts";
import store from './store'
import VueSignature from "vue-signature-pad";
import draggable from 'vuedraggable';

require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

Vue.use(VModal, { dynamic: true, injectModalsContainer: true });
Vue.use(ClientTable, {}, false, 'bootstrap4');
Vue.use(ServerTable, {}, false, 'bootstrap4');
Vue.use(CKEditor);
Vue.use(VueSignature);

Vue.directive('init', {
    bind: function (el, binding, vnode) {
        vnode.context[binding.arg] = binding.value;
    }
});

Vue.directive('tooltip', function (el, binding) {
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover focus'
    })
})

Vue.directive('popover', function (el, binding) {
    $(el).popover({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'
    })
})

window.Toast = swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 3000
});

Vue.component('date-picker', DatePicker);

Vue.component('multiselect', Multiselect);

Vue.component('apexchart', VueApexCharts);

Vue.component('draggable', draggable);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// jim components
require('./jim.js');

// mark components
require('./mark.js');

// jayr components
require('./jayr.js');

// xyxy components
require('./xyxy.js');

//bayani components
require('./bayani.js');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: '#app',
});

const appsearch = new Vue({
    // store,
    el: '#appsearch',
});


