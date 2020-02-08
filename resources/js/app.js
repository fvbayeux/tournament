/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import AutoScroll from "./components/AutoScroll";
import Counter from "./components/Counter";
import DashboardCounter from "./components/DashboardCounter";
import DashboardGames from "./components/DashboardGames";
import Games from "./components/Games";
import Loader from "./components/Loader";
import Players from "./components/Players";

Vue.component("font-awesome-icon", FontAwesomeIcon);
Vue.component("auto-scroll", AutoScroll);
Vue.component("counter", Counter);
Vue.component("dashboard-counter", DashboardCounter);
Vue.component("dashboard-games", DashboardGames);
Vue.component("games", Games);
Vue.component("loader", Loader);
Vue.component("players", Players);

var eventHub = new Vue();

const app = new Vue({
    el: "#app",
    eventHub: eventHub
});
