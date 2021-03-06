
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

// Vue.component('day-manager', require('./components/Daymanager.vue'));
Vue.component('comments-manager', require('./components/CommentsManager.vue'));
Vue.component('review-manager', require('./components/ReviewManager.vue'));
Vue.component('comment-review', require('./components/CommentReview.vue'));

import Vue from 'vue'
import Datetime from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(Datetime)
Vue.use(require('vue-moment'));

const app = new Vue({
    el: '#app'
});
