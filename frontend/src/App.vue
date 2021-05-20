<template>
<v-app id="app" :style="{background: $vuetify.theme.themes[isDark].background}">
  <router-view />
  <v-fab-transition>
    <v-btn class="goToTop" v-scroll="onScroll" v-show="fab" fab small dark fixed bottom right color="primary" @click="toTop">
      <v-icon>mdi-arrow-up</v-icon>
    </v-btn>
  </v-fab-transition>
  <v-snackbar v-model="snackbarUnreadMessages" :multi-line="multiLine" color="orange" :right="true" :bottom="true">
    <!-- <v-chip class="ma-2" color="white" outlined>
      NEW
    </v-chip> -->
    <v-icon>mdi-message-text-clock</v-icon>
    {{ textUnreadMessages }}
    <template v-slot:action="{ attrs }">
      <v-btn color="white" v-bind="attrs" @click="snackbarUnreadMessages = false" fab text small>
        <v-icon>mdi-close-circle</v-icon>
      </v-btn>
    </template>
  </v-snackbar>

  <v-snackbar v-model="snackbarNotifications" :multi-line="multiLine" color="orange" :right="true" :bottom="true">
    <v-icon>mdi-bell-ring</v-icon>
    {{ textNotifications }}
    <template v-slot:action="{ attrs }">
      <v-btn color="white" v-bind="attrs" @click="snackbarNotifications = false" fab text small>
        <v-icon>mdi-close-circle</v-icon>
      </v-btn>
    </template>
  </v-snackbar>
</v-app>
</template>

<script>
// import HelloWorld from './components/HelloWorld.vue'
import axios from 'axios';

export default {
  name: 'App',

  data() {
    return {
      notifCount: 0,
      snackbarUnreadMessages: false,
      snackbarNotifications: false,
      multiLine: true,
      textUnreadMessages: '',
      textNotifications: '',
      fab: false,
    }
  },

  created() {
    // window.Echo.private('testchannel')
    //   .listen('Test', (e) => {
    //     console.log('test successful ' + e)
    //   })
    //presence channel
    if (localStorage.getItem('user_id') != null) {
      //for unread messages
      window.Echo.join('messages.' + localStorage.getItem("user_id"))
        .listen('NewMessage', (e) => {
          if (e.message.to == localStorage.getItem("user_id")) {
            this.$store.dispatch('msgUnreadCounter', {
              unreadCounter: e.message.totalUnreadMsgTo
            });
            const api = `http://127.0.0.1:8000/api/user/${e.message.from}`;
            const config = {
              headers: {
                Accept: "application/json",
                Authorization: "Bearer " + localStorage.getItem("authToken"),
              },
            };
            axios.get(api, config)
              .then(res => {
                if (e.message.totalUnreadMsgTo == 1) {
                  // this.textUnreadMessages = `${e.message.totalUnreadMsgTo} neprečítaná správa`;
                  this.textUnreadMessages = `Nová správa od používateľa ${res.data[0].name}`;
                } else {
                  // this.textUnreadMessages = `Máte ${e.message.totalUnreadMsgTo} neprečítaných správ`;
                  this.textUnreadMessages = `Nová správa od používateľa ${res.data[0].name}`;
                }
                this.snackbarUnreadMessages = true;
              });
          }
        })
      //for notifications
      window.Echo.join('notif-channel.' + localStorage.getItem("user_id"))
        .listen('Notifi', (e) => {
          // this.notifCount = this.$store.getters['notificationCounter'];
          if (e.notification.status == 'new') {
            this.notifCount += 1;
            this.$store.dispatch('notificationCounter', {
              notifCounter: this.notifCount
            });
            if (this.notifCount == 1) {
              this.textNotifications = `Máte ${this.notifCount} novú notifikáciu`;
            } else {
              this.textNotifications = `Máte ${this.notifCount} nové notifikácie`;
            }
            this.snackbarNotifications = true;
          }
        })
    }
    console.log("App compoennt created");
  },
  computed: {
    isDark() {
      return (this.$vuetify.theme.dark) ? 'dark' : 'light'
    }
  },

  mounted() {
    localStorage.setItem('language', 'Slovensky');

    const theme = localStorage.getItem("dark_theme");
    if (theme) {
      if (theme === "true") {
        this.$vuetify.theme.dark = true;
        localStorage.setItem('graph_theme', 'dark');
      } else {
        this.$vuetify.theme.dark = false;
        localStorage.setItem('graph_theme', 'light');
      }
    }

    //get all new notifications after refresh page
    const api = 'http://127.0.0.1:8000/api/getAllUnreadMessages';
    const api2 = `http://127.0.0.1:8000/api/getNotificationNew/${localStorage.getItem('user_id')}`;
    const api3 = 'http://127.0.0.1:8000/api/rating';
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    if (localStorage.getItem('user_id') != null) {
      //unread messages
      axios.get(api, config)
        .then((res) => {
          this.$store.dispatch('msgUnreadCounter', {
            unreadCounter: res.data
          });
        });
      //notofications counter
      axios.get(api2, config)
        .then(res => {
          this.notifCount = res.data.length
          this.$store.dispatch('notificationCounter', {
            notifCounter: this.notifCount
          });
        });
    }

    if (localStorage.getItem('username') != null) {
      axios.get(api3, config)
        .then(resp => {
          for (var i = 0; i < resp.data.data.length; i++) {
            if (localStorage.getItem("username") == resp.data.data[i].Meno) {
              this.$store.dispatch('ratingState', {
                state: true
              });
            }
          }
        })
    }
    this.initDarkMode();
  },
  updated() {
    //do something after updating vue instance
    this.notifCount = this.$store.getters['notificationCounter'];

    const api = 'http://127.0.0.1:8000/api/getAllUnreadMessages';
    const api2 = `http://127.0.0.1:8000/api/getNotificationNew/${localStorage.getItem('user_id')}`;
    const api3 = 'http://127.0.0.1:8000/api/rating';
    // const api4 = `http://127.0.0.1:8000/api/checkPendingReservation/${localStorage.getItem('username')}`;
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };

    if (localStorage.getItem('user_id') != null) {
      //unread messages
      axios.get(api, config)
        .then((res) => {
          this.$store.dispatch('msgUnreadCounter', {
            unreadCounter: res.data
          });
        });
      //notofications counter
      axios.get(api2, config)
        .then(res => {
          this.$store.dispatch('notificationCounter', {
            notifCounter: res.data.length
          });
        });
    }
    if (localStorage.getItem('username') != null) {
      axios.get(api3, config)
        .then(resp => {
          for (var i = 0; i < resp.data.data.length; i++) {
            if (localStorage.getItem("username") == resp.data.data[i].Meno) {
              this.$store.dispatch('ratingState', {
                state: false
              });
            }
          }
        })
    }
    // axios.get(api4, config)
    //   .then(res => {
    //     this.$store.dispatch('pendingReservation', {
    //       count: res.data
    //     });
    //   });
    this.notifCount = this.$store.getters['notificationCounter'];
    this.initDarkMode();
  },

  methods: {
    onScroll(e) {
      if (typeof window === 'undefined') return
      const top = window.pageYOffset || e.target.scrollTop || 0
      this.fab = top > 20
    },
    toTop() {
      this.$vuetify.goTo(0)
    },
    initDarkMode() {
      if (JSON.parse(localStorage.getItem("auto_dlm")) == true) {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)')
          .matches) {
          this.$vuetify.theme.dark = true;
          localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
          localStorage.setItem('graph_theme', 'dark');
        } else {
          this.$vuetify.theme.dark = false;
          localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
          localStorage.setItem('graph_theme', 'light');
        }
        window.matchMedia('(prefers-color-scheme: dark)')
          .addEventListener('change', event => {
            if (event.matches) {
              this.$vuetify.theme.dark = true;
              localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
            } else {
              this.$vuetify.theme.dark = false;
              localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
            }
          })
      }
    },
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.theme--light .v-application--wrap {
  background-color: #f5f5f5 !important;
}

/* .theme--dark .v-application--wrap {
  background-color: #f5f5f5 !important;
} */

.goToTop {
  margin-bottom: 50px;
  z-index: 12 !important;
}
</style>
