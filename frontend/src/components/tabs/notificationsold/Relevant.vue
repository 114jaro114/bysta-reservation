<template>
<div class="relevant w-100 h-100">
  <!-- <v-lazy :options="{
            threshold: .1
          }" transition="fade-transition"> -->
  <v-row justify="center" class="ml-0 mr-0">
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-col class="pl-3 pr-3">
      <v-card class="rounded" elevation="0">
        <v-toolbar class="notiftoolbar rounded-top" extended extension-height="4" color="primary" flat dark>
          <div class="w-75" v-if="selected.length == '0'">
            <v-text-field color="white white--color" v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details clearable disabled v-if="myloadingvariable || notif.length == 0"></v-text-field>
            <v-text-field color="white white--color" v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details clearable v-if="!myloadingvariable && notif.length != 0"></v-text-field>
          </div>

          <div v-else>
            <v-btn fab icon small @click="deleteNotif = !deleteNotif">
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </div>

          <v-spacer></v-spacer>

          <span style="font-size:12px">Označiť všetko</span>
          <v-checkbox class="mt-5 ml-3" color="secondary secondary--text" @change="checkUncheckAll($event);" disabled v-if="myloadingvariable || notif.length == 0"></v-checkbox>
          <v-checkbox class="mt-5 ml-3" color="secondary secondary--text" @change="checkUncheckAll($event);" v-model=" item_1.checked" :indeterminate="item_1.indeterminate" v-if="!myloadingvariable && notif.length != 0"></v-checkbox>

          <!-- <v-progress-linear v-if="myloadingvariable" color="white" style="height:4px" slot="extension" :indeterminate="true"></v-progress-linear> -->
        </v-toolbar>

        <v-list class="pb-0" three-line>
          <v-list-item-group v-model="selected" active-class="primary--text" multiple>
            <v-list-item class="justify-center" v-if="myloadingvariable" disabled>
              Načítavanie... Prosím počkajte
            </v-list-item>
            <v-list-item class="justify-center" v-if="filteredItems.length == 0 && !myloadingvariable && notif.length != 0" disabled>
              <v-btn color="primary" icon width="50px" height="50px">
                <v-icon style="font-size: 50px">mdi-cancel</v-icon>
                <span class="ml-3">Žiadne výsledky</span>
              </v-btn>
            </v-list-item>

            <v-list-item class="justify-center" v-if="notif.length == 0 && !myloadingvariable" disabled>
              <v-btn color="primary" icon width="50px" height="50px">
                <v-icon style="font-size: 50px">mdi-bell-cancel</v-icon>
                <span class="ml-3">Žiadne dôležité notifikácie</span>
              </v-btn>
            </v-list-item>
            <template v-else v-for="(item, index) in filteredItems">
              <!-- card notif -->
              <!-- <v-list-item class="p-0" :key="item.title" v-if="!myloadingvariable">
                  <template v-slot:default="{ active }">
                    <v-card class="w-100" elevation="0" tile>
                      <div class="d-flex flex-no-wrap">
                        <v-card-text @click=" checkUncheck(item, active)">
                          <v-card-title v-text="item.title" class="headline justify-center">
                          </v-card-title>

                          <v-card-subtitle v-text="item.headline"></v-card-subtitle>
                          <v-card-text v-text="item.subtitle"></v-card-text>
                        </v-card-text>

                        <v-card-actions @click="checkUncheck(item, active)">
                          <v-row>
                            <v-col cols="12" class="d-flex justify-content-end">
                              <span v-text="item.action"></span>
                            </v-col>
                            <v-col cols="12" class="d-flex justify-content-end">
                              <v-checkbox value v-if=" !active">
                              </v-checkbox>
                              <v-checkbox input-value="true" value v-else></v-checkbox>
                            </v-col>
                          </v-row>
                        </v-card-actions>
                      </div>
                    </v-card>
                  </template>
                </v-list-item> -->
              <!-- list notif -->
              <v-list-item class="p-0" :key="item.name" v-if="!myloadingvariable">
                <template v-slot:default="{ active }">
                  <v-list-item-content class="pt-5 pb-5 pl-3" @click="checkUncheck(item, active)">
                    <v-list-item-title v-text="item.title"></v-list-item-title>

                    <v-list-item-subtitle class="text--primary" v-text="item.subtitle"></v-list-item-subtitle>

                    <v-list-item-subtitle v-text="item.text"></v-list-item-subtitle>
                  </v-list-item-content>

                  <v-list-item-action class="m-0 p-3" @click="checkUncheck(item, active)">
                    <v-list-item-action-text class="pb-3" v-text="item.date"></v-list-item-action-text>

                    <v-checkbox value v-if="!active"></v-checkbox>

                    <v-checkbox input-value="true" value v-else></v-checkbox>
                  </v-list-item-action>
                </template>
              </v-list-item>
              <v-divider class="m-0" v-if="index < notif.length - 1 && !myloadingvariable" :key="index"></v-divider>
            </template>
            <!-- snackbard -->
            <v-snackbar :timeout="-1" :value="deleteNotif" absolute centered color="primary" elevation="24">
              Naozaj chcete vymazať túto notifikáciu?
              <v-btn class="ml-2 mt-3" color="secondary error--text" fab x-small @click="deleteNotif = false; deleteNotification(item)">
                <v-icon>mdi-check</v-icon>
              </v-btn>
              <v-btn class="ml-2 mt-3" color="secondary accent--text" fab x-small medium @click="deleteNotif = false">
                <v-icon>mdi-close</v-icon>
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
            <!-- ///////// -->
          </v-list-item-group>
        </v-list>
      </v-card>
    </v-col>
  </v-row>
  <!-- </v-lazy> -->
</div>
</template>

<script>
import axios from 'axios'
import _ from 'lodash';
export default {
  name: "Relevant",
  components: {},
  data() {
    return {
      search: '',
      selected: [],
      selectedAll: [],
      notif: [],
      myloadingvariable: true,
      checkbox: true,
      item_1: {
        name: 'test 1',
        checked: false,
        indeterminate: false
      },
      // notif snackbars
      deleteNotif: false,
      snackbar: false,
      multiLine: true,
      text: '',

      overlay: true,
    }
  },

  methods: {
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
      this.text = "Notifikácia bola úspešne vymazaná";
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
          const api = `${process.env.VUE_APP_API_URL}/getNotificationRelevant/${localStorage.getItem('user_id')}`;
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
    }
  },

  mounted() {
    //do something after mounting vue instance
    //do something after mounting vue instance
    const api = `${process.env.VUE_APP_API_URL}/getNotificationRelevant/${localStorage.getItem('user_id')}`;
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    axios.get(api, config)
      .then(res => {
        this.myloadingvariable = false;
        this.notif = res.data;
        this.overlay = false;
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
}
</script>

<style type="scss">
/* .md-empty-state {
    margin-top: 5rem !important;
  } */
</style>
