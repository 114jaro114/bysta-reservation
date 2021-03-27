<template>
<div class="all w-100 h-100 mt-1">
  <v-lazy :options="{
            threshold: .8
          }" transition="fade-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card>
          <v-toolbar class="notiftoolbar" extended extension-height="4" color="primary" dark>
            <div class="w-75" v-if="selected.length == '0'">
              <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details clearable disabled v-if="myloadingvariable"></v-text-field>
              <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details clearable v-if="!myloadingvariable"></v-text-field>
            </div>

            <div v-else>
              <v-btn fab icon small>
                <v-icon>mdi-star-box-multiple-outline</v-icon>
              </v-btn>

              <v-btn fab icon small @click="deleteNotif = !deleteNotif">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </div>

            <v-spacer></v-spacer>

            <span style="font-size:12px">Označiť všetko</span>
            <v-checkbox class="mt-5 ml-3" color="secondary secondary--text" @change="checkUncheckAll($event);" disabled v-if="myloadingvariable"></v-checkbox>
            <v-checkbox class="mt-5 ml-3" color="secondary secondary--text" @change="checkUncheckAll($event);" v-model=" item_1.checked" :indeterminate="item_1.indeterminate" v-if="!myloadingvariable"></v-checkbox>

            <v-progress-linear v-if="myloadingvariable" color="white" style="height:4px" slot="extension" :indeterminate="true"></v-progress-linear>
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
                <v-btn color="primary" icon width="170px" height="170px">
                  <v-icon style="font-size: 150px">mdi-bell-cancel</v-icon>
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
                <v-list-item class="p-0" :key="item.title" v-if="!myloadingvariable">
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
      <!-- <v-col v-for="(item, i) in items" :key="i" cols="12">
        <v-card color="primary" dark>
          <div class="d-flex flex-no-wrap justify-space-between">
            <div>
              <v-card-title class="headline" v-text="item.title"></v-card-title>

              <v-card-subtitle v-text="item.artist"></v-card-subtitle>

              <v-card-actions v-if="item.artist === 'Ellie Goulding'">
                <v-btn class="ml-2 mt-3" fab icon small>
                  <v-icon>mdi-star-box-multiple-outline</v-icon>
                </v-btn>

                <v-btn class="ml-2 mt-3" outlined rounded medium>
                  Označiť ako videné <v-icon>mdi-eye-check-outline</v-icon>
                </v-btn>
              </v-card-actions>

              <v-card-actions v-else>
                <v-btn class="ml-2 mt-3" fab icon small>
                  <v-icon>mdi-star-box-multiple-outline</v-icon>
                </v-btn>

                <v-btn class="ml-2 mt-3" outlined rounded medium>
                  <v-icon>mdi-eye-check</v-icon>
                </v-btn>
              </v-card-actions>
            </div>

            <v-avatar class="ma-3" size="125" tile>
              <v-img :src="item.src"></v-img>
            </v-avatar>
          </div>
        </v-card>
      </v-col> -->
    </v-row>
  </v-lazy>
</div>
</template>

<script>
import axios from 'axios'
import _ from 'lodash';
export default {
  name: "All",
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
      text: ''
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
      const api = 'http://127.0.0.1:8000/api/deleteNotification';
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

  mounted() {
    //do something after mounting vue instance
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
        console.log(res);
        this.myloadingvariable = false;
        this.notif = res.data;
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
.v-toolbar__extension {
  padding: 0px !important;
}

.notiftoolbar .v-toolbar__content,
.v-toolbar__extension {
  padding-right: 10px;
  padding-left: 10px;
}

.v-sheet.v-card--active {
  color: black;
}
</style>
