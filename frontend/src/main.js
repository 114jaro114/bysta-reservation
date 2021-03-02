import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

//vuetify import
import vuetify from './plugins/vuetify'

//vuelidate
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

// bootstrap-vue
import {
  BootstrapVue,
  IconsPlugin
} from 'bootstrap-vue'
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

//vue chat scroll
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

//import video-player
// import VuePlyr from "vue-plyr";
// Vue.use(VuePlyr);

//google maps
import * as VueGoogleMaps from "vue2-google-maps"

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyDa7tHiX8MPsxI62U4g_7wXD4WaMigSGmo",
    libraries: "places" // necessary for places input
  }
});

//translate
// import i18n from "./i18n";

// Calendar
// import VCalendar from 'v-calendar';
//
// // Use v-calendar & v-date-picker components
// Vue.use(VCalendar);

//gallery
import Lightbox from '@morioh/v-lightbox'
Vue.use(Lightbox);
import '@morioh/v-lightbox/dist/lightbox.css';

import Vuex from 'vuex'
Vue.use(Vuex)

import Echo from 'laravel-echo'
window.Pusher = require('pusher-js')

// This assumes you have already saved your bearer token in your browsers local storage
const token = localStorage.getItem('authToken');

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: "websocketkey",
  // cluster: 'mt1',
  authEndpoint: 'http://localhost:8000/api/broadcast',
  // authHost: "http://localhost",
  // authEndpoint: "/broadcasting/auth",
  // authEndpoint: 'http://127.0.0.1/public/broadcasting/auth',
  encrypted: true,
  forceTLS: false,
  wsHost: window.location.hostname,
  wsPort: 6001,
  // wssPort: 6001,
  disableStats: true,
  enabledTransports: ['ws', 'wss'],
  auth: {
    headers: {
      Accept: 'application/json',
      Authorization: 'Bearer ' + token,
    }
  }
})

//vue materialize
// import VueMaterial from 'vue-material';
// Vue.use(VueMaterial);

// import scss file
require('@/assets/styles/main.scss');

Vue.config.productionTip = false

new Vue({
    router,
    vuetify,
    store,
    // i18n,
    render: h => h(App),
  })
  .$mount('#app')