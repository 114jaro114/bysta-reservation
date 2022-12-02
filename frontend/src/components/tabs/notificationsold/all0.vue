<template>
<div class="all w-100 h-100 text-uppercase mt-1">
  <v-lazy :options="{
            threshold: .8
          }" transition="fade-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card elevation="2">
          <v-card-title>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details></v-text-field>
          </v-card-title>
          <v-data-table no-data-text="Nenašli sa žiadne notifikácie" :header-props="headerProps" :footer-props="footerProps" :headers="headers" :items="items" :search="search" item-key="title" :loading="myloadingvariable"
            loading-text="Načítavanie... Prosím počkajte">

            <template v-slot:header.data-table-select="{ on, props }">
              <v-simple-checkbox color="purple" v-bind="props" v-on="on"></v-simple-checkbox>
            </template>
            <template v-slot:item="{ item }">
              <v-card class="m-3" color="primary" dark>
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
            </template>
          </v-data-table>
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
export default {
  name: "All",
  components: {},
  data() {
    return {
      search: '',
      footerProps: {
        itemsPerPageText: 'Počet riadkov',
        itemsPerPageOptions: [5, 10, 15, -1],
      },
      headerProps: {
        sortByText: "Zoradiť podľa"
      },
      headers: [{
        text: 'Názov',
        align: 'start',
        filterable: true,
        sortable: true,
        value: 'title',
      }, {
        text: 'Dátum',
        align: 'start',
        filterable: false,
        sortable: true,
        value: 'date',
      }, ],
      actualUser: localStorage.getItem("user_id"),
      users: [],
      myloadingvariable: true,
      //
      items: [{
          src: 'https://cdn.vuetifyjs.com/images/cards/foster.jpg',
          title: 'Supermodel',
          artist: 'Foster the People',
          date: '2021-24-3'
        },
        {
          src: 'https://cdn.vuetifyjs.com/images/cards/halcyon.png',
          title: 'Halcyon Days',
          artist: 'Ellie Goulding',
          date: '2021-25-3'
        },
      ],
      notif: [],
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
  }
}
</script>

<style type="scss">
/* .md-empty-state {
    margin-top: 5rem !important;
  } */
</style>
