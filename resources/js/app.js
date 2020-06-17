/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Vuetify
import vuetify from '../plugins/vuetify'

// VueRouter
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// Vue2Editor
import Vue2Editor from "vue2-editor";
Vue.use(Vue2Editor);

// BootstrapVue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)

// BootstrapVue icon components plugin
Vue.use(IconsPlugin)

import 'css-file-icons/build/css-file-icons.css'

import Dashboard from './Admin pages/Dashboard'
import Settings from './Admin pages/Settings'
import Users from './Admin pages/Users'
import Roles from './Admin pages/Roles'
import Permissions from './Admin pages/Permissions'
import Activities from './Admin pages/Activities'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Laravel-Vue-Pagination
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('email-section', require('./components/email-section.vue').default);
Vue.component('email-list', require('./components/email-list.vue').default);
Vue.component('show-email', require('./components/show-email.vue').default);
Vue.component('new-email', require('./components/new-email.vue').default);

Vue.component('admin', require('./components/Admin/Admin.vue').default);

const routes = [
    {
        path: '/admin/',
        component: Dashboard
    },
    {
        path: '/admin/users',
        component: Users
    },
    {
        path: '/admin/roles',
        component: Roles
    },
    {
        path: '/admin/permissions',
        component: Permissions
    },
    {
        path: '/admin/settings',
        component: Settings
    },
    {
        path: '/admin/activities',
        component: Activities
    }
  ];

  const router = new VueRouter({
    mode: 'history',
    routes
  })


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    vuetify,
    el: '#app',
    router,
    data: {
        newEmailComponentKey:0
    }
});
