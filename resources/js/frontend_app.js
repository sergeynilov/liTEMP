import Vue from 'vue'
import axios from 'axios'
axios.defaults.crossDomain = true

import 'font-awesome/css/font-awesome.css'

Vue.config.productionTip = false
Window.axios = axios

import { createInertiaApp, Link } from '@inertiajs/inertia-vue'
Vue.component('inertia-link', Link)

import route from "ziggy";
import { ZiggyVue, Ziggy } from 'ziggy';
Vue.use(ZiggyVue, Ziggy, route);



const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: false,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

import Swal from 'sweetalert2'

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props }) {
        new Vue({
            render: h => h(App, props),
        }).$mount(el)

    },
})

// createInertiaApp.use(VueToast);
//
// let instance = createInertiaApp.$toast.open('You did it!');
//
// // Force dismiss specific toast
// instance.dismiss();
// // Dismiss all opened toast immediately
// createInertiaApp.$toast.clear();


