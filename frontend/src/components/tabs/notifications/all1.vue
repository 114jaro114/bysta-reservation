<template>
<div class="all w-100 h-100 text-uppercase mt-1">
  <v-lazy :options="{
            threshold: .8
          }" transition="fade-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card>
          <v-card-title class="pb-0" v-if="selected.length < 2">
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details clearable></v-text-field>
          </v-card-title>
          <v-card-title class="pb-0" v-else>
            <v-col class="p-0" cols="12" xs="12" sm="12" md="8" lg="9" xl="9">
              <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details></v-text-field>
            </v-col>
            <v-col class="p-0" cols="12" xs="12" sm="12" md="4" lg="3" xl="3">
              <v-btn color="primary" fab x-small dark class="mr-3" @click="dialog = !dialog">
                <v-icon> mdi-delete </v-icon>
              </v-btn>
              <v-btn color="primary" fab x-small dark class="" @click="dialog = !dialog">
                <v-icon> mdi-star-box-multiple </v-icon>
              </v-btn>
            </v-col>
          </v-card-title>
          <v-data-table v-model="selected" show-select no-data-text="Nenašli sa žiadne notifikácie" :header-props="headerProps" :footer-props="footerProps" :headers="headers" :items="items" :search="search" item-key="title"
            :loading="myloadingvariable" loading-text="Načítavanie... Prosím počkajte">
            <template v-slot:header="{ props: { headers } }">
              <thead>
                <tr>
                  <th :colspan="headers.length">
                    <v-btn color="primary" dark class="" @click="sch = !sch">
                      Označiť viac
                    </v-btn>
                  </th>
                </tr>
              </thead>
            </template>
            <template v-slot:item="{isSelected, select, item}">
              <v-card class="m-3" color="primary" dark>
                <div class="d-flex flex-no-wrap justify-space-between">
                  <div>
                    <v-card-title class="headline" v-text="item.title"></v-card-title>

                    <v-card-subtitle v-text="item.artist"></v-card-subtitle>

                    <v-card-actions v-if="item.artist === 'Ellie Goulding'">
                      <v-simple-checkbox class="ml-2 mt-3" color="white white--text" :ripple="false" :value="isSelected" @input="select($event)"></v-simple-checkbox>

                      <v-btn class="ml-2 mt-3" fab icon small>
                        <v-icon>mdi-star-box-multiple-outline</v-icon>
                      </v-btn>

                      <v-btn class="ml-2 mt-3" fab icon small>
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>

                    </v-card-actions>

                    <v-card-actions v-else>
                      <v-simple-checkbox class="ml-2 mt-3" color="white white--text" :ripple="false" :value="isSelected" @input="select($event)"></v-simple-checkbox>

                      <v-btn class="ml-2 mt-3" fab icon small>
                        <v-icon>mdi-star-box-multiple-outline</v-icon>
                      </v-btn>

                      <v-btn class="ml-2 mt-3" fab icon small>
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </v-card-actions>
                  </div>

                  <v-avatar class="ma-3" size="125" tile>
                    <v-img :src="item.src"></v-img>
                  </v-avatar>
                </div>
              </v-card>
            </template>
            <!-- <template v-slot:item.title="{ item }">
              {{item.title}}
            </template>
            <template v-slot:item.text="{ item }">
              {{item.text}}
            </template>

            <template v-slot:item.date="{ item }">
              {{item.date}}
            </template>

            <template v-slot:item.actions="{ item }">
              <v-icon medium class="mr-2" @click="editItem(item)"> mdi-delete </v-icon>
              <v-icon medium @click="deleteItem(item)"> mdi-star-box-multiple </v-icon>
            </template> -->

          </v-data-table>
          <h5>Selected: {{selected}}</h5>
          <h5>Selected: {{selected.length}}</h5>
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
      selected: [],
      footerProps: {
        itemsPerPageText: 'Počet riadkov',
        itemsPerPageOptions: [5, 10, 15, -1],
      },
      headerProps: {
        sortByText: "Zoradiť podľa"
      },
      headers: [{
          text: 'Označiť',
          align: 'start',
          filterable: false,
          sortable: false,
          // value: 'data-table-select',
        },
        {
          text: 'Názov',
          filterable: true,
          sortable: true,
          value: 'title',
        },
        // {
        //   text: 'Správa',
        //   filterable: false,
        //   sortable: false,
        //   value: 'text',
        // },
        {
          text: 'Dátum',
          filterable: false,
          sortable: true,
          value: 'date',
        },
        // {
        //   text: 'Akcie',
        //   filterable: false,
        //   sortable: false,
        //   value: 'actions',
        // },
      ],
      actualUser: localStorage.getItem("user_id"),
      users: [],
      myloadingvariable: true,
      //
      items: [{
          src: 'https://cdn.vuetifyjs.com/images/cards/foster.jpg',
          title: 'Supermodel',
          text: 'Foster the Peoplesssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssadasdasdadsssssssssssssssssssssssasdasdasdasdsadasdasdasdadasdasdsssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssasdasdqwdqwdqwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww ',
          date: '2021-24-3'
        },
        {
          src: 'https://cdn.vuetifyjs.com/images/cards/halcyon.png',
          title: 'Halcyon Days',
          text: 'Ellie Goulding',
          date: '2021-25-3'
        },
      ],
      notif: [],

      //
      // headers: [{
      //   text: 'Dessert (100g serving)',
      //   align: 'left',
      //   sortable: false,
      //   value: 'name',
      // }, ],
      // desserts: [{
      //     name: 'Frozen Yogurt',
      //   },
      //   {
      //     name: 'Ice cream sandwich',
      //   },
      // ],
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
