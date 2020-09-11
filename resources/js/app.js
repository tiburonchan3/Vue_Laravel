require('./bootstrap');
window.$ = require('jquery');
window.Vue = require('vue');

import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
import swal from 'sweetalert2'
import StarRating from 'vue-star-rating';


Vue.use(VueRouter);
Vue.use(VueAxios, axios);

Vue.component('star-rating', StarRating);


const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});

window.swal = swal;
//configuracion de sweet alert
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;
//evento de vue
window.EventBus = new Vue();
//segundo evento de vue
window.EventBus2 = new Vue();

window.EventColor = new Vue();

