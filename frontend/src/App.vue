<template>
<v-app id="app" :style="{background: $vuetify.theme.themes[isDark].background}">
  <router-view />

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
      window.Echo.join('notif-channel')
        .listen('Notifi', (e) => {
          this.notifCount += 1;
          if (e.notification.to == localStorage.getItem("user_id")) {
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
      } else {
        this.$vuetify.theme.dark = false;
      }
    } else if (
      window.matchMedia &&
      window.matchMedia("(prefers-color-scheme: dark)")
      .matches
    ) {
      this.$vuetify.theme.dark = true;
      localStorage.setItem(
        "dark_theme",
        this.$vuetify.theme.dark.toString()
      );
    }

    //get all new notifications after refresh page
    const api = 'http://127.0.0.1:8000/api/getAllUnreadMessages';
    const api2 = `http://127.0.0.1:8000/api/getNotification/${localStorage.getItem('user_id')}`;
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
    console.log("App compoennt mounted");

    // console.log(this.$store.getters['selectedUser']);
    // console.log(this.$store.getters['isLoggedOut']);
  },
  updated() {
    //do something after updating vue instance
    const api = 'http://127.0.0.1:8000/api/getAllUnreadMessages';
    const api2 = `http://127.0.0.1:8000/api/getNotification/${localStorage.getItem('user_id')}`;
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
    console.log("App compoennt updated");
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
</style>
