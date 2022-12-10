import Vue from 'vue'
import App from './App.vue'

import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import i18n from './i18n'

//vuetify import
// import social_auth from './social_auth/index'

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

// import {
//   VueReCaptcha
// } from 'vue-recaptcha-v3'
//
// // For more options see below
// Vue.use(VueReCaptcha, {
//   siteKey: '*****',
//   loaderOptions: {
//     useRecaptchaNet: true,
//     autoHideBadge: false
//   },
//   explicitRenderParameters: {
//     container: 'inline-badge',
//     badge: 'inline',
//     size: 'invisible'
//   }
// })

// vue scrollbar
import Vuebar from 'vuebar';
Vue.use(Vuebar);

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
  key: process.env.VUE_APP_PUSHER_APP_KEY,
  cluster: process.env.VUE_APP_PUSHER_CLUSTER,
  authEndpoint: `${process.env.VUE_APP_API_URL}/broadcast`,
  // authHost: "http://localhost",
  // authEndpoint: "/broadcasting/auth",
  // authEndpoint: 'http://127.0.0.1/public/broadcasting/auth',
  encrypted: false, //changed from true
  forceTLS: false,
  wsHost: window.location.hostname,
  //wsHost: "websockets",
  wsPort: 6001,
  // wssPort: 6001,
  disableStats: false, //from true
  enabledTransports: ['ws', 'wss'],
  auth: {
    headers: {
      Accept: 'application/json',
      Authorization: 'Bearer ' + token,
    }
  }
})

// import scss file
require('@/assets/styles/main.scss');

Vue.config.productionTip = false

import axios from 'axios';

import {
  isLoggedIn
} from './utils/auth'

new Vue({
    router,
    vuetify,
    store,
    i18n,
    data: {
      language: {
        countries: [{
            name: "sk",
            flag: "sk"
          },
          {
            name: "en",
            flag: "gb"
          }
        ],

        selectedLang: 0,
      },

      envUrlNoApi: undefined,

      savedReservation: {
        details: undefined,
        contactInfos: undefined
      },

      friendships: {
        friends: undefined,
        friends_overlay: true,
        friendsLoading: true,
      },

      me: {
        id: undefined,
        name: undefined,
        email: undefined,
        avatar: undefined,
        status: undefined,
        created_at: undefined,
        overlayAvatar: true,
      },

      prices: {
        priceAdults: 18,
        priceChildsto2: 0,
        priceChilds2to12: 18,
        priceCabinUnderSixPpl: 150,
        cleaningFee: 100,
      },

      navigationDrawerLeft: {
        numberOfFriends: undefined,
      },

      navigationDrawerRight: {
        countMyFriendshipRequests: 0,
      },

      profile: {
        data: {
          returnVariable: undefined,
          userData: undefined
        },
        friendships: {
          friends: undefined,
          numberOfFriends: 0,
          friends_overlay: true,
        }
      },

      toolbar: {
        allPossibleFriends: {
          users: undefined,
          usersLoading: true
        },
        friendRequests: {
          friendRequests: undefined,
          friendRequests_overlay: true,
        },
        fewNewestMessages: {
          overlayNewestMessages: true,
          fewNewestMessages: undefined,
        },
        fewNewestNotifications: {
          overlayNewestNotifications: true,
          fewNewestNotifications: undefined,
        },
        fewOldNotifications: {
          overlayOldNotifications: true,
          fewOldNotifications: undefined,
        },
      },
    },

    methods: {
      getDataOfMe() {
        const api = `${process.env.VUE_APP_API_URL}/auth/user`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.me.id = res.data.id;
            this.me.name = res.data.name;
            this.me.email = res.data.email;
            this.me.avatar = res.data.avatar;
            this.me.status = res.data.status;
            this.me.created_at = res.data.created_at;
            this.me.overlayAvatar = false;
          });
      },

      getAllFriends() {
        const api = `${process.env.VUE_APP_API_URL}/friendships`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.friendships.friendsLoading = false;
            this.friendships.friends_overlay = false;
            this.friendships.friends = res.data;
          });
      },
      // NavigationDrawerLeft
      getNumberOfFriends() {
        const api = `${process.env.VUE_APP_API_URL}/getNumberOfFriends`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.navigationDrawerLeft.numberOfFriends = res.data;
          });
      },
      // Toolbar
      getAllPossibleFriends() {
        const api = `${process.env.VUE_APP_API_URL}/getAllPossibleFriends`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.toolbar.allPossibleFriends.usersLoading = false;
            this.toolbar.allPossibleFriends.users = res.data;
          });
      },

      getFriendRequests() {
        const api = `${process.env.VUE_APP_API_URL}/getAllFriendshipRequests`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.toolbar.friendRequests.friendRequests = res.data;
            this.toolbar.friendRequests.friendRequests_overlay = false;
          });
      },

      getFewNewestMessages() {
        const api = `${process.env.VUE_APP_API_URL}/getFewNewestMessages`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.toolbar.fewNewestMessages.overlayNewestMessages = false;
            this.toolbar.fewNewestMessages.fewNewestMessages = res.data;
          });
      },

      getFewNewestNotifications() {
        const api = `${process.env.VUE_APP_API_URL}/getFewNewestNotifications`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.toolbar.fewNewestNotifications.overlayNewestNotifications = false;
            this.toolbar.fewNewestNotifications.fewNewestNotifications = res.data;
          });
      },

      getFewOldNotifications() {
        const api = `${process.env.VUE_APP_API_URL}/getFewOldNotifications`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.toolbar.fewOldNotifications.overlayOldNotifications = false;
            this.toolbar.fewOldNotifications.fewOldNotifications = res.data;
          });
      },

      getCountMyFriendshipRequests() {
        const api = `${process.env.VUE_APP_API_URL}/getCountMyFriendshipRequests`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            this.navigationDrawerRight.countMyFriendshipRequests = res.data;
          });
      },
    },

    async created() {
      this.envUrlNoApi = process.env.VUE_APP_API_URL2;
      if (isLoggedIn()) {
        this.getDataOfMe();
        this.getAllFriends();
        // NavigationDrawerLeft
        this.getNumberOfFriends();
        // Toolbar
        this.getAllPossibleFriends();
        this.getFriendRequests();

        this.getFewNewestMessages();
        this.getFewOldNotifications();
        this.getFewNewestNotifications();
        //navigationDrawerCenter
        this.getCountMyFriendshipRequests();
      }
    },
    // social_auth,
    // i18n,
    render: h => h(App),
  })
  .$mount('#app')