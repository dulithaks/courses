require('./bootstrap');
window.Vue = require('vue/dist/vue');

import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
import Vuelidate from 'vuelidate'
import Vue from 'vue'
import vSelect from 'vue-select'

Vue.component('v-select', vSelect)

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Vuelidate)

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
