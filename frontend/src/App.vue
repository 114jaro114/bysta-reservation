<template>
<v-app id="app" :style="{background: $vuetify.theme.themes[isDark].background}">
  <Toolbar @navigationDrawer="openNavigationDrawer"
    v-if="$route.name != 'Login' && this.$route.name != 'Register' && this.$route.name != 'Welcome' && this.$route.name != 'ForgotPassword' && this.$route.name != 'ResetPassword' && this.$route.name != 'VerificationAccount'" />

  <NavigationDrawer :drawer="drawer" />

  <router-view />
  <v-fab-transition>
    <v-btn class="goToTop" v-scroll="onScroll" v-show="fab" fab small dark fixed bottom right color="primary" @click="toTop">
      <v-icon>mdi-arrow-up</v-icon>
    </v-btn>
  </v-fab-transition>

  <v-snackbar class="snackbar_message" v-model="snackbarUnreadMessages" :multi-line="multiLine" color="orange" :right="true" :bottom="true" rounded>
    <v-list class="p-2" two-line maxWidth="310" color="orange" dense rounded>
      <template v-for="(item, index) in notifMSG">
        <v-list-item :key="index" @click="selectDataAboutUser(item)">
          <v-badge bottom dot :color="getColor(item.from_contact.status)" offset-x="10" offset-y="10" class="mr-2">
            <v-avatar color="primary" size="40" v-if="item.from_contact.avatar == null">
              <span class="text-uppercase white--text">{{ item.from_contact.name.charAt(0) }}</span>
            </v-avatar>
            <v-avatar size="40" v-else>
              <img :src="`${$root.envUrlNoApi}/storage/user-avatar/${item.from_contact.avatar}`">
            </v-avatar>
          </v-badge>
          <v-list-item-content>
            <v-list-item-title class="d-flex justify-start text-subtitle-2 font-weight-bold p-0 pl-1">
              <v-chip small color="white primary--text">
                <v-icon left class="mr-1" small>mdi-account-circle-outline</v-icon>{{item.from_contact.name}}
              </v-chip>
            </v-list-item-title>

            <v-list-item-subtitle class="text-left white--text font-weight-bold p-0 pl-1 pt-1" v-text="item.text"></v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </template>
    </v-list>
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


  <div v-if="$route.name != 'Login' && this.$route.name != 'Register' && this.$route.name != 'Welcome' && this.$route.name != 'ForgotPassword' && this.$route.name != 'ResetPassword' && this.$route.name != 'VerificationAccount'">
    <SpeedDial />
    <Footer v-if="$route.name != 'Messenger' && $route.name != 'Reservation'" />
    <BottomNavigation />
  </div>
</v-app>
</template>

<script>
// import HelloWorld from './components/HelloWorld.vue'
import axios from 'axios';
import Toolbar from "@/components/Toolbar.vue";
import Footer from "@/components/Footer.vue";
import SpeedDial from "@/components/SpeedDial.vue";
import BottomNavigation from "@/components/BottomNavigation.vue";
import NavigationDrawer from "@/components/NavigationDrawer.vue";

export default {
  name: 'App',
  props: ['drawerNew'],
  components: {
    Toolbar,
    Footer,
    SpeedDial,
    BottomNavigation,
    NavigationDrawer
  },

  data() {
    return {
      notifCount: 0,
      reservCount: 0,
      snackbarUnreadMessages: false,
      snackbarNotifications: false,
      multiLine: true,
      textUnreadMessages: '',
      textNotifications: '',
      fab: false,
      notifMSG: [],

      snackbar: false,
      snackbar_text: '',
      snackbar_color: '',
      drawer: false,
    }
  },

  created() {
    //presence channel
    if (localStorage.getItem('authToken') != null) {
      //for unread messages
      window.Echo.join('messages.' + localStorage.getItem("user_id"))
        .listen('NewMessage', (e) => {
          if (e.message.to == localStorage.getItem("user_id")) {
            if (this.$route.fullPath != `/messenger?name=${e.message.from_contact.name}`) {
              this.$store.dispatch('msgUnreadCounter', {
                unreadCounter: e.message.totalUnreadMsgTo
              });
              this.notifMSG = [];
              this.notifMSG.push(e.message);
              this.snackbarUnreadMessages = true;
            } else {
              const api = `${process.env.VUE_APP_API_URL}/conversation/${e.message.from}`;
              const config = {
                headers: {
                  Accept: "application/json",
                  Authorization: "Bearer " + localStorage.getItem("authToken"),
                },
              };
              axios.get(api, config)
                .then(() => {
                  //unread messages
                  const api = `${process.env.VUE_APP_API_URL}/getAllUnreadMessages`;
                  axios.get(api, config)
                    .then((res) => {
                      this.$store.dispatch('msgUnreadCounter', {
                        unreadCounter: res.data
                      });
                    });
                });
            }
          }
        })

      window.Echo.join('friendship.' + localStorage.getItem("user_id"))
        .listen('Friendships', (e) => {
          let newFriendRequest = {
            avatar: e.friendship.from_user.avatar,
            created_at: e.friendship.from_user.created_at,
            email: e.friendship.from_user.email,
            id: e.friendship.from_user.id,
            name: e.friendship.from_user.name,
            status: e.friendship.from_user.status,
            friendship_status: e.friendship.friendship_status,
            requester: e.friendship.requester,
            updated_at: null,
            user_requested: e.friendship.user_requested
          };
          this.$root.toolbar.friendRequests.friendRequests.push(newFriendRequest);
          // remove this request from array in $root and add data to friendship array
          let position = this.$root.toolbar.allPossibleFriends.users.reduce((acc, request, index) => {
            if (request.name == e.friendship.from_user.name) {
              acc.push(index);
            }
            return acc;
          }, []);
          this.$root.toolbar.allPossibleFriends.users.splice(position[0], 1);
          // plus 1 request from counter of requests
          this.$root.navigationDrawerRight.countMyFriendshipRequests += 1;
        })

      // remove friendship request
      window.Echo.join('friendship-remove.' + localStorage.getItem("user_id"))
        .listen('Friendship_remove', (e) => {
          // remove this request from array in $root and add data to friendship array
          let position = this.$root.toolbar.friendRequests.friendRequests.reduce((acc, request, index) => {
            if (request.id == e.friendship.requester) {
              acc.push(index);
            }
            return acc;
          }, []);
          this.$root.toolbar.allPossibleFriends.users.push(this.$root.toolbar.friendRequests.friendRequests[position[0]]);
          this.$root.toolbar.friendRequests.friendRequests.splice(position[0], 1);
          this.$root.navigationDrawerRight.countMyFriendshipRequests -= 1;
        })

      //for notifications
      window.Echo.join('notif-channel.' + localStorage.getItem("user_id"))
        .listen('Notifications', (e) => {
          if (e.notification.subtitle.substring(0, e.notification.subtitle.indexOf(' ')) == 'Prijatie') {
            let position = this.$root.toolbar.friendRequests.friendRequests.reduce((acc, request, index) => {
              if (request.id == e.notification.from_user.id) {
                acc.push(index);
              }
              return acc;
            }, []);
            this.$root.friendships.friends.push(this.$root.toolbar.friendRequests.friendRequests[position[0]]);
            this.$root.toolbar.friendRequests.friendRequests.splice(position[0], 1);
          } else if (e.notification.subtitle.substring(0, e.notification.subtitle.indexOf(' ')) == 'Odmietnutie') {
            // remove this request from array in $root and add data to friendship array
            let position = this.$root.toolbar.friendRequests.friendRequests.reduce((acc, request, index) => {
              if (request.id == e.notification.from_user.id) {
                acc.push(index);
              }
              return acc;
            }, []);
            this.$root.toolbar.allPossibleFriends.users.push(this.$root.toolbar.friendRequests.friendRequests[position[0]]);
            this.$root.toolbar.friendRequests.friendRequests.splice(position[0], 1);
          }

          let notif = {
            avatar: e.notification.from_user.avatar,
            created_at: e.notification.created_at.toLocaleString(),
            date: e.notification.date,
            email: e.notification.from_user.email,
            from: e.notification.from,
            id: e.notification.id,
            name: e.notification.from_user.name,
            status: e.notification.from_user.status,
            status_notif: e.notification.status,
            subtitle: e.notification.subtitle,
            text: e.notification.text,
            title: e.notification.title,
            to: e.notification.to,
            updated_at: e.notification.updated_at.toLocaleString()
          }

          this.$root.toolbar.fewNewestNotifications.fewNewestNotifications.push(notif);

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

      // for reservations
      window.Echo.join('reservation.' + this.$root.me.id)
        .listen('Reservations', (e) => {
          console.log(e);
          if (this.$route.fullPath != '/administration') {

            // this.reservCount += 1;
            // this.$store.dispatch('reservationCounter', {
            //   reservCounter: this.reservCount
            // });
            if (e.status == 'deleted') {
              this.reservCount += 1;
              this.$store.dispatch('reservationCounter', {
                reservCounter: this.reservCount
              });
            } else {
              this.getUncheckedReservations();
            }
          }
        })
    }
  },
  computed: {
    isDark() {
      return (this.$vuetify.theme.dark) ? 'dark' : 'light'
    }
  },

  mounted() {
    //do something after mounting vue instance
    localStorage.setItem('language', 'Slovenský jazyk');

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
    const api = `${process.env.VUE_APP_API_URL}/getAllUnreadMessages`;
    const api2 = `${process.env.VUE_APP_API_URL}/getNotificationNew/${localStorage.getItem('user_id')}`;
    const api3 = `${process.env.VUE_APP_API_URL}/rating`;

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
      //rating
      axios.get(api3, config)
        .then(res => {
          if (res.data.length != 0) {
            for (var i = 0; i < res.data.data.length; i++) {
              if (localStorage.getItem("username") == res.data.data[i].Meno) {
                this.$store.dispatch('ratingState', {
                  state: true
                });
              }
            }
          }
        })

      this.getUncheckedReservations();
    }
    this.initDarkMode();
  },
  updated() {
    this.drawer = this.drawerNew;
    //do something after updating vue instance
    this.notifCount = this.$store.getters['notificationCounter'];
    this.reservCount = this.$store.getters['reservationCounter'];

    // const api = 'http://127.0.0.1:8000/api/getAllUnreadMessages';
    // const api2 = `http://127.0.0.1:8000/api/getNotificationNew/${localStorage.getItem('user_id')}`;
    // const api3 = 'http://127.0.0.1:8000/api/rating';
    // // const api4 = `http://127.0.0.1:8000/api/checkPendingReservation/${localStorage.getItem('username')}`;
    // const config = {
    //   headers: {
    //     Accept: "application/json",
    //     Authorization: "Bearer " + localStorage.getItem("authToken"),
    //   },
    // };
    //
    // if (localStorage.getItem('user_id') != null) {
    //   //unread messages
    //   axios.get(api, config)
    //     .then((res) => {
    //       this.$store.dispatch('msgUnreadCounter', {
    //         unreadCounter: res.data
    //       });
    //     });
    //   //notofications counter
    //   axios.get(api2, config)
    //     .then(res => {
    //       this.$store.dispatch('notificationCounter', {
    //         notifCounter: res.data.length
    //       });
    //     });
    // }
    // if (localStorage.getItem('username') != null) {
    //   axios.get(api3, config)
    //     .then(resp => {
    //       for (var i = 0; i < resp.data.data.length; i++) {
    //         if (localStorage.getItem("username") == resp.data.data[i].Meno) {
    //           this.$store.dispatch('ratingState', {
    //             state: false
    //           });
    //         }
    //       }
    //     })
    // }
    // axios.get(api4, config)
    //   .then(res => {
    //     this.$store.dispatch('pendingReservation', {
    //       count: res.data
    //     });
    //   });

    this.initDarkMode();

    if (localStorage.getItem('authToken') != null) {
      if (this.$store.getters['friendshipRequestAction'].status == 'accept') {
        this.snackbar = true;
        this.snackbar_text = this.$store.getters['friendshipRequestAction'].text;
        this.snackbar_color = 'green';
        this.$store.dispatch('friendshipRequestAction', {
          status: null,
          text: null
        });
      } else if (this.$store.getters['friendshipRequestAction'].status == 'refuse') {
        this.snackbar = true;
        this.snackbar_text = this.$store.getters['friendshipRequestAction'].text;
        this.snackbar_color = 'red';
        this.$store.dispatch('friendshipRequestAction', {
          status: null,
          text: null
        });
      } else {
        this.snackbar = true;
        this.snackbar_text = this.$store.getters['friendshipRequestAction'].text;
        this.snackbar_color = 'red';
        this.$store.dispatch('friendshipRequestAction', {
          status: null,
          text: null
        });
      }
    }
  },

  methods: {
    getUncheckedReservations() {
      const api = `${process.env.VUE_APP_API_URL}/reservation/getUncheckedReservationsUser`;

      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      //reservations counter
      axios.get(api, config)
        .then(res => {
          this.reservCount = res.data
          this.$store.dispatch('reservationCounter', {
            reservCounter: this.reservCount
          });
        });
    },

    openNavigationDrawer(state) {
      this.drawer = state;
    },

    getColor(e) {
      if (e == 'offline') return 'red'
      else return 'green'
    },

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

    selectDataAboutUser(item) {
      console.log(item);
      this.snackbarUnreadMessages = false;
      this.$router.push(`/messenger?name=${item.from_contact.name}`);
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
