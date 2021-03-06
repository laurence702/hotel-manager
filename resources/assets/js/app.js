/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Jquery from "jquery";
require("./bootstrap");

window.$ = window.JQuery = Jquery;
window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component("example", require("./components/Example.vue"));
Vue.component("receipt", require("./components/Receipt.vue"));
Vue.component("receipt2", require("./components/Receipt2.vue"));
Vue.component("cart", require("./components/Cart.vue"));
Vue.component("bookingreport", require("./components/BookingReport.vue"));

const app = new Vue({
    el: "#app"
});