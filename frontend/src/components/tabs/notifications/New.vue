<template>
<div class="new">
  <v-container>
    <v-row justify="center" class="ml-0 mr-0">
      <v-col class="pl-0 pr-0">
        <v-card elevation="0">
          <v-toolbar class="notiftoolbar" color="primary" flat dark>
            <div class="w-75" v-if="selected.length == 0">
              <v-text-field color="white white--color" v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details filled rounded dense clearable disabled v-if="overlay || notif.length == 0"></v-text-field>
              <v-text-field color="white white--color" v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details filled rounded dense clearable v-if="!overlay &&  notif.length != 0"></v-text-field>
            </div>

            <div v-if="selected.length > 0 && deleteNotif == false && addToSaved == false">
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn fab icon small @click="addToSaved = !addToSaved; deleteNotif = false" v-bind="attrs" v-on="on">
                    <v-icon>mdi-bookmark-multiple</v-icon>
                  </v-btn>
                </template>
                <span>Pridať do uložených</span>
              </v-tooltip>
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn fab icon small @click="deleteNotif = !deleteNotif; addToSaved = false" v-bind="attrs" v-on="on">
                    <v-icon>mdi-delete</v-icon>
                  </v-btn>
                </template>
                <span>Vymazať</span>
              </v-tooltip>
            </div>

            <!-- snackbar deleteNotif-->
            <v-snackbar :timeout="-1" :value="deleteNotif" absolute centered color="primary" elevation="0" height="64">
              <span v-if="selectedAll.length > 1">Naozaj chcete vymazať tieto notifikácie?</span>
              <span v-else>Naozaj chcete vymazať túto notifikáciu?</span>
              <div>
                <v-btn color="error error--text" text small @click="deleteNotif = false; deleteNotification()">
                  Áno
                </v-btn>
                <v-btn color="white white--text" text small outlined @click="deleteNotif = false">
                  Nie
                </v-btn>
              </div>
            </v-snackbar>

            <!-- snackbar addToSaved-->
            <v-snackbar :timeout="-1" :value="addToSaved" absolute centered color="primary" elevation="0" height="64">
              <span v-if="selectedAll.length > 1">Naozaj chcete premiestniť notifikácie do zoznamu uložených?</span>
              <span v-else>Naozaj chcete premiestniť notifikáciu do zoznamu uložených?</span>
              <div>
                <v-btn color="error error--text" text small @click="addToSaved = false; addNotificationsToSaved()">
                  Áno
                </v-btn>
                <v-btn color="white white--text" text small outlined @click="addToSaved = false">
                  Nie
                </v-btn>
              </div>
            </v-snackbar>
            <!-- ///////// -->

            <v-spacer v-if="deleteNotif == false && addToSaved == false"></v-spacer>

            <span style="font-size:12px" class="text-right" v-if="deleteNotif == false && addToSaved == false">Označiť všetko</span>
            <v-checkbox class="mt-5 ml-3" color="white white--text" @change="checkUncheckAll($event);" disabled v-if="overlay || notif.length == 0 && deleteNotif == false && addToSaved == false"></v-checkbox>
            <v-checkbox class="mt-5 ml-3" color="white white--text" @change="checkUncheckAll($event);" v-model=" item_1.checked" :indeterminate="item_1.indeterminate"
              v-if="!overlay && notif.length != 0 && deleteNotif == false && addToSaved == false"></v-checkbox>
          </v-toolbar>

          <v-list class="pb-0 pt-0" three-line>
            <v-list-item-group v-model="selected" active-class="primary--text" multiple>
              <v-list-item v-if="overlay != false" inactive disabled>
                <v-overlay :value="overlay" :absolute="true" :opacity="0">
                  <v-progress-circular indeterminate size="24" color="primary"></v-progress-circular>
                </v-overlay>
              </v-list-item>
              <v-list-item class="justify-center" v-if="filteredItems.length == 0 && !overlay && notif.length != 0" disabled>
                <v-list-item-content class="p-2 pr-0 pl-0">
                  <v-card class="rounded-lg card-statement" elevation="0">
                    <span>Žiadne výsledky</span>
                  </v-card>
                </v-list-item-content>
              </v-list-item>

              <v-list-item class="justify-center" v-else-if="notif.length == 0 && !overlay" disabled>
                <v-list-item-content class="p-2 pr-0 pl-0">
                  <v-card class="rounded-lg card-statement" elevation="0">
                    <span>Žiadne notifikácie</span>
                  </v-card>
                </v-list-item-content>
              </v-list-item>
              <template v-else v-for="(item, index) in notif">
                <!-- list notif -->
                <v-list-item class="p-0" :key="item.name" v-if="!overlay">
                  <template v-slot:default="{ active }">
                    <v-list-item-content class="pt-5 pb-5 pl-3" @click="checkUncheck(item, active)">
                      <v-list-item-title v-text="item.title"></v-list-item-title>

                      <v-list-item-subtitle class="text--primary" v-text="item.subtitle"></v-list-item-subtitle>

                      <v-list-item-subtitle v-text="item.text"></v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-action class="m-0 p-3" @click="checkUncheck(item, active)">
                      <v-list-item-action-text class="pb-3" v-text="item.date"></v-list-item-action-text>

                      <v-dialog v-model="dialogNotifDetail" fullscreen hide-overlay transition="dialog-bottom-transition">
                        <template v-slot:activator="{ on: menu, attrs }">
                          <v-btn class="p-absolute" style="left:10px" icon large color="primary" v-bind="attrs" v-on="{ ...menu }" @click="getNotifDetail(item, active)">
                            <v-icon size="24">mdi-eye</v-icon>
                          </v-btn>
                        </template>
                        <v-card>
                          <v-toolbar dark color="primary" elevation="0">
                            <v-btn icon dark @click="dialogNotifDetail = false">
                              <v-icon>mdi-close</v-icon>
                            </v-btn>
                            <v-toolbar-title class="justify-center">Detail</v-toolbar-title>
                          </v-toolbar>
                        </v-card>
                      </v-dialog>

                      <v-checkbox value v-if="!active"></v-checkbox>

                      <v-checkbox input-value="true" value v-else></v-checkbox>
                    </v-list-item-action>
                  </template>
                </v-list-item>
                <v-divider class="m-0" v-if="index < notif.length - 1 && !overlay" :key="index"></v-divider>
              </template>
            </v-list-item-group>
          </v-list>

          <v-snackbar height="64" v-model="snackbar" :multi-line="multiLine" color="success" :left="true">
            <v-icon>mdi-check-circle</v-icon>
            {{ text }}
            <template v-slot:action="{ attrs }">
              <v-btn color="white" text v-bind="attrs" @click="snackbar = false">
                <v-icon>mdi-close-circle</v-icon>
              </v-btn>
            </template>
          </v-snackbar>
        </v-card>
      </v-col>
    </v-row>
    <!-- </v-lazy> -->
  </v-container>
</div>
</template>

<script>
import axios from 'axios'
import _ from 'lodash';
export default {
  name: "New",
  components: {},
  data() {
    return {
      form: {
        recipient: 1,
        title: 'hmm',
        subtitle: 'hmm',
        text: 'hmm',
        date: '2021-03-27 16:00',
        status: 'new',
      },
      search: '',
      selected: [],
      selectedAll: [],
      dialogNotifDetail: false,
      overlay: true,
      checkbox: true,
      item_1: {
        name: 'test 1',
        checked: false,
        indeterminate: false
      },
      notif: [],
      notifCount: 0,
      // notif snackbars
      deleteNotif: false,
      addToSaved: false,
      snackbar: false,
      multiLine: true,
      text: '',
    }
  },

  methods: {
    methodName() {
      const api = `${process.env.VUE_APP_API_URL}/sendNotification`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.post(api, {
          recipient: this.form.recipient,
          title: this.form.title,
          subtitle: this.form.subtitle,
          text: this.form.text,
          date: this.form.date,
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

    checkUncheck(item, active) {
      if (active) {
        for (var i = 0; i < this.selectedAll.length; i++) {
          if (this.selectedAll[i] == item.id) {
            this.selectedAll.splice(i, 1);
          }
        }
        if (this.item_1.checked == true) {
          this.deleteNotif = false;
          this.item_1.checked = false;
          this.item_1.indeterminate = true;
        }
        if (this.selectedAll.length == this.notif.length) {
          this.item_1.indeterminate = false;
          this.item_1.checked = true;
        }
        if (this.selectedAll.length == "0") {
          this.item_1.indeterminate = false;
          this.item_1.checked = false;
          this.deleteNotif = false;
        }
      } else {
        this.selectedAll.push(item.id);
        if (this.selectedAll.length == this.notif.length) {
          this.item_1.indeterminate = false;
          this.item_1.checked = true;
        }
      }
    },

    checkUncheckAll(event) {
      if (event == true) {
        this.item_1.checked = true;
        this.item_1.indeterminate = false;

        for (var i = 0; i < this.notif.length; i++) {
          this.selected.push(i);
        }

        for (var x = 0; x < this.notif.length; x++) {
          this.selectedAll.push(this.notif[x].id);
        }
      } else {
        this.item_1.checked = false;
        this.item_1.indeterminate = false;
        this.deleteNotif = false;
        this.selected = [];
        this.selectedAll = [];
      }
    },

    deleteNotification() {
      this.snackbar = true;

      const api = `${process.env.VUE_APP_API_URL}/deleteNotification`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.post(api, {
          ids: this.selectedAll,
        }, config)
        .then(() => {
          if (this.selectedAll.length > 1) {
            this.text = "Notifikácie boli úspešne vymazané.";
          } else {
            this.text = "Notifikácia bola úspešne vymazaná.";
          }
          this.selected = [];
          this.selectedAll = [];
          const api = `${process.env.VUE_APP_API_URL}/getNotificationNew/${localStorage.getItem('user_id')}`;
          const config = {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.getItem("authToken"),
            },
          };
          axios.get(api, config)
            .then(res => {
              this.notif = res.data;
              this.notifCount = res.data.length;
              this.$store.dispatch('notificationCounter', {
                notifCounter: this.notifCount
              });
            });
        })
    },

    addNotificationsToSaved() {
      this.snackbar = true;

      const api = `${process.env.VUE_APP_API_URL}/addToSaved`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.post(api, {
          ids: this.selectedAll,
        }, config)
        .then(() => {
          if (this.selectedAll.length > 1) {
            this.text = "Notifikácie boli premiestnené do zoznamu uložených.";
          } else {
            this.text = "Notifikácia bola premiestnená do zoznamu uložených.";
          }
          this.selected = [];
          this.selectedAll = [];
          const api = `${process.env.VUE_APP_API_URL}/getNotificationNew/${localStorage.getItem('user_id')}`;
          const config = {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.getItem("authToken"),
            },
          };
          axios.get(api, config)
            .then(res => {
              this.notif = res.data;
            });
        })
    },
  },

  mounted() {
    //do something after mounting vue instance
    const api = `${process.env.VUE_APP_API_URL}/getNotificationNew/${localStorage.getItem('user_id')}`;
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    axios.get(api, config)
      .then(res => {
        this.notif = res.data;
        this.overlay = false;
        this.notifCount = 0;

        this.$root.toolbar.fewNewestNotifications.fewNewestNotifications.forEach((elem, index) => {
          this.$root.toolbar.fewNewestNotifications.fewNewestNotifications[index].status_notif = "all";
          this.$root.toolbar.fewOldNotifications.fewOldNotifications.push(elem);
        })

        this.$root.toolbar.fewNewestNotifications.fewNewestNotifications = []

        this.$store.dispatch('notificationCounter', {
          notifCounter: this.notifCount
        });
        axios.post(`${process.env.VUE_APP_API_URL}/markAsRead`)
          .then(() => {
            this.$store.dispatch('notificationCounter', {
              notifCounter: 0
            });
          })
      });
  },

  computed: {
    filteredItems() {
      return _.orderBy(this.notif.filter(item => {
        if (!this.search) return this.notif;
        return (item.title.toLowerCase()
          .includes(this.search.toLowerCase()) ||
          item.date.toLowerCase()
          .includes(this.search.toLowerCase()) ||
          item.text.toLowerCase()
          .includes(this.search.toLowerCase()) ||
          item.subtitle.toLowerCase()
          .includes(this.search.toLowerCase()));
      }), 'headline');
    }
  },

  created() {
    //do something after creating vue instance
    //presence channel
    window.Echo.join('notif-channel.' + localStorage.getItem("user_id"))
      .listen('Notifi', (e) => {
        if (e.notification.status == 'new') {
          this.notif.push(e.notification);
          this.notifCount += 1;
          this.$store.dispatch('notificationCounter', {
            notifCounter: this.notifCount
          });
        }
      })
  },

  updated() {
    //do something after updating vue instance
    // console.log(this.$store.getters['notificationCounter']);
  }
}
</script>

<style type="scss">
</style>
