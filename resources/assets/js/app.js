
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


Pusher.logToConsole = true;

var pusher = new Pusher('8dc95d49e9a8f15e0980', {
    cluster: 'eu',
    encrypted: true
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('callingcomponent', require('./components/CallingComponent.vue'));
Vue.component('contactlist', require('./components/ContactList.vue'));

const app = new Vue({
    el: '#app'
});

