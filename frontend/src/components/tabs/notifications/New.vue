<template>
<div class="new w-100 h-100 text-uppercase mt-1">
  <v-lazy :options="{
            threshold: .8
          }" transition="fade-transition">
    <v-row justify="center" class="ml-0 mr-0" v-if="this.$store.getters['notificationCounter'] === 0">
      <v-col>
        <!-- <v-lazy v-model="isActive" :options="{
          threshold: .5
        }" min-height="200" transition="fade-transition"> -->
        <v-btn color="primary" icon width="170px" height="170px">
          <v-icon style="font-size: 150px">mdi-bell-cancel</v-icon>
        </v-btn>
        <!-- </v-lazy> -->
        <v-text-field v-model="form.recipient" label="meno">meno</v-text-field>
        <v-text-field v-model="form.text" label="text">text</v-text-field>
        <v-text-field v-model="form.status" label="status">status</v-text-field>
        <v-btn @click="methodName">odoslat</v-btn>
      </v-col>
    </v-row>
    <v-row justify="center" class="ml-0 mr-0" v-else>
      <v-col v-for="(item, i) in notif" :key="i" cols="12">
        <v-card color="primary" dark>
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title class="headline" v-text="item.status"></v-card-title>

              <v-card-subtitle v-text="item.text"></v-card-subtitle>

              <v-card-actions>
                <v-btn class="ml-2 mt-3" fab icon small>
                  <v-icon>mdi-star-box-multiple-outline</v-icon>
                </v-btn>

                <v-btn class="ml-2 mt-3" outlined rounded medium>
                  Označiť ako videné <v-icon>mdi-eye-check-outline</v-icon>
                </v-btn>

                <v-snackbar :timeout="-1" :value="deleteNotif" absolute centered color="primary" elevation="24">
                  Naozaj chcete vymazať túto notifikáciu?
                  <v-btn class="ml-2 mt-3" rounded medium @click="deleteNotif = false; deleteNotification(item)">
                    Áno <v-icon>mdi-check</v-icon>
                  </v-btn>
                  <v-btn class="ml-2 mt-3" outlined rounded medium @click="deleteNotif = false">
                    Zrušiť <v-icon>mdi-close-thick</v-icon>
                  </v-btn>
                </v-snackbar>

                <v-snackbar v-model="snackbar" :multi-line="multiLine" color="success" :left="true">
                  <v-icon>mdi-check-circle</v-icon>
                  {{ text }}
                  <template v-slot:action="{ attrs }">
                    <v-btn color="white" text v-bind="attrs" @click="snackbar = false">
                      Zrušiť
                    </v-btn>
                  </template>
                </v-snackbar>

                <v-btn class="ml-2 mt-3" fab icon small @click="deleteNotif = true">
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </v-card-actions>

              <!-- <v-card-actions v-else>
                <v-btn class="ml-2 mt-3" fab icon small>
                  <v-icon>mdi-star-box-multiple-outline</v-icon>
                </v-btn>

                <v-btn class="ml-2 mt-3" outlined rounded medium>
                  <v-icon>mdi-eye-check</v-icon>
                </v-btn>
              </v-card-actions> -->
            </div>

            <v-avatar class="ma-3" size="125" tile>
              <v-img :src="item.src"></v-img>
            </v-avatar>
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>

<script>
import axios from 'axios';
export default {
  name: "New",
  components: {},
  data() {
    return {
      isActive: true,
      form: {
        recipient: null,
        text: null,
        status: null,
      },
      notif: [],
      notifCount: 0,
      deleteNotif: false,
      snackbar: false,
      multiLine: true,
      text: ''
    }
  },

  mounted() {
    //do something after mounting vue instance
    const api = `http://127.0.0.1:8000/api/getNotification/${localStorage.getItem('user_id')}`;
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    axios.get(api, config)
      .then(res => {
        console.log(res)
        this.notif = res.data;
        this.notifCount = res.data.length;
        this.$store.dispatch('notificationCounter', {
          notifCounter: this.notifCount
        });
      });

    console.log("mounted")
  },

  methods: {
    methodName() {
      const api = 'http://127.0.0.1:8000/api/sendNotification';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.post(api, {
          recipient: this.form.recipient,
          text: this.form.text,
          status: this.form.status
        }, config)
        .then(() => {
          // const api = `http://127.0.0.1:8000/api/getNotification/${localStorage.getItem('user_id')}`;
          // const config = {
          //   headers: {
          //     Accept: "application/json",
          //     Authorization: "Bearer " + localStorage.getItem("authToken"),
          //   },
          // };
          // axios.get(api, config)
          //   .then(res => {
          //     console.log(res)
          //     this.notif = res.data;
          //     this.notifCount = res.data.length;
          //     this.$store.dispatch('notificationCounter', {
          //       notifCounter: this.notifCount
          //     });
          //   });
        })
    },

    deleteNotification(e) {
      console.log(e);
      this.snackbar = true;
      this.text = "Notifikácia bola úspešne vymazaná";
      const api = 'http://127.0.0.1:8000/api/deleteNotification';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.post(api, {
          id: e.id,
        }, config)
        .then(() => {
          const api = `http://127.0.0.1:8000/api/getNotification/${localStorage.getItem('user_id')}`;
          const config = {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.getItem("authToken"),
            },
          };
          axios.get(api, config)
            .then(res => {
              console.log(res)
              this.notif = res.data;
              this.notifCount = res.data.length;
              this.$store.dispatch('notificationCounter', {
                notifCounter: this.notifCount
              });
            });
        })
    }
  },

  created() {
    //do something after creating vue instance
    //presence channel
    window.Echo.join('notif-channel')
      .listen('Notifi', (e) => {
        this.notif = e.notification.notification;
        console.log(e);
        this.notifCount += 1;
        this.$store.dispatch('notificationCounter', {
          notifCounter: this.notifCount
        });
        // this.notifCount = e.notifications.length;
      })
  },

  updated() {
    //do something after updating vue instance

  }
}
</script>

<style type="scss">
/* .md-empty-state {
    margin-top: 5rem !important;
  } */
@media only screen and (max-width: 550px) {
  .md-empty-state {
    width: 250px !important;
    height: 250px !important;
    padding: 0 !important;
  }
}
</style>
