<template>
<div class="all w-100 h-100 mt-1">
  <v-lazy :options="{
            threshold: .8
          }" transition="fade-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card>
          <v-toolbar class="notiftoolbar" extended extension-height="7" color="primary" dark>

            <v-text-field v-if="selected.length == '0'" v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details clearable></v-text-field>
            <div v-else>
              <v-btn fab icon small>
                <v-icon>mdi-star-box-multiple-outline</v-icon>
              </v-btn>

              <v-btn fab icon small>
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </div>

            <v-spacer></v-spacer>

            <span>Označiť všetko</span>
            <v-checkbox class="mt-5 ml-3" color="secondary secondary--text" @change="checkUncheckAll($event);" v-model=" item_1.checked" :indeterminate="item_1.indeterminate"></v-checkbox>

            <v-progress-linear v-if="myloadingvariable" color="white" style="height:6px" slot="extension" :indeterminate="true"></v-progress-linear>
          </v-toolbar>

          <v-list class="pb-0" two-line>
            <v-list-item-group v-model="selected" active-class="primary--text" multiple>
              <v-list-item class="justify-center" v-if="myloadingvariable">
                Načítavanie... Prosím počkajte
              </v-list-item>
              <v-list-item class="justify-center" v-if="items.length == 0 && !myloadingvariable">
                <v-btn color="primary" icon width="170px" height="170px">
                  <v-icon style="font-size: 150px">mdi-bell-cancel</v-icon>
                </v-btn>
              </v-list-item>
              <template v-else v-for="(item, index) in filteredItems">
                <v-list-item :key="item.title">
                  <template v-slot:default="{ active }">
                    <v-list-item-content @click="checkUncheck(item, active)">
                      <v-list-item-title v-text="item.title"></v-list-item-title>

                      <v-list-item-subtitle class="text--primary" v-text="item.headline"></v-list-item-subtitle>

                      <v-list-item-subtitle v-text="item.subtitle"></v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-action>
                      <v-list-item-action-text v-text="item.action"></v-list-item-action-text>

                      <v-checkbox value v-if="!active" @click="checkUncheck(item, active)"></v-checkbox>

                      <v-checkbox input-value="true" value v-else @click="checkUncheck(item, active)"></v-checkbox>

                      <!-- <v-icon v-if="!active" color="grey lighten-1">
                        mdi-star-outline
                      </v-icon> -->

                      <!-- <v-icon v-else color="yellow darken-3">
                        mdi-star
                      </v-icon> -->
                    </v-list-item-action>
                  </template>
                </v-list-item>
                <v-divider class="m-0" v-if="index < items.length - 1" :key="index"></v-divider>
              </template>
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
      items: [{
          id: '2',
          action: '15 min',
          headline: 'Brunch this weekend?',
          subtitle: `I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`,
          title: 'Ali Connors',
        },
        {
          id: '4',
          action: '2 hr',
          headline: 'Summer BBQ',
          subtitle: `Wish I could come, but I'm out of town this weekend.`,
          title: 'me, Scrott, Jennifer',
        },
        {
          id: '6',
          action: '6 hr',
          headline: 'Oui oui',
          subtitle: 'Do you have Paris recommendations? Have you ever been?',
          title: 'Sandra Adams',
        },
        {
          id: '8',
          action: '12 hr',
          headline: 'Birthday gift',
          subtitle: 'Have any ideas about what we should get Heidi for her birthday?',
          title: 'Trevor Hansen',
        },
        {
          id: '10',
          action: '18hr',
          headline: 'Recipe to try',
          subtitle: 'We should eat this: Grate, Squash, Corn, and tomatillo Tacos.',
          title: 'Britta Holt',
        },
      ],
      myloadingvariable: true,
      checkbox: true,
      item_1: {
        name: 'test 1',
        checked: false,
        indeterminate: false
      },
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
          this.item_1.checked = false;
          this.item_1.indeterminate = true;
        }
        if (this.selectedAll.length == this.items.length) {
          this.item_1.indeterminate = false;
          this.item_1.checked = true;
        }
        if (this.selectedAll.length == "0") {
          this.item_1.indeterminate = false;
          this.item_1.checked = false;
        }
      } else {
        this.selectedAll.push(item.id);
        if (this.selectedAll.length == this.items.length) {
          this.item_1.indeterminate = false;
          this.item_1.checked = true;
        }
      }
    },

    checkUncheckAll(event) {
      if (event == true) {
        this.item_1.checked = true;
        this.item_1.indeterminate = false;

        for (var i = 0; i < this.items.length; i++) {
          this.selected.push(i);
        }

        for (var x = 0; x < this.items.length; x++) {
          this.selectedAll.push(this.items[x].id);
        }
      } else {
        this.item_1.checked = false;
        this.item_1.indeterminate = false;
        this.selected = [];
        this.selectedAll = [];
      }
      // if (event) {
      //   this[`item_${next}`].checked = false;
      //   this[`item_${next}`].indeterminate = true;
      // } else {
      //   this[`item_${value}`].checked = false;
      //   this[`item_${value}`].indeterminate = true;
      // }

    },
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
      return _.orderBy(this.items.filter(item => {
        if (!this.search) return this.items;
        return (item.title.toLowerCase()
          .includes(this.search.toLowerCase()) ||
          item.action.toLowerCase()
          .includes(this.search.toLowerCase()) ||
          item.headline.toLowerCase()
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
}
</style>
