<template>
<div class="saved_reservations w-100 h-100 mt-16">
  <v-overlay :value="overlay">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>

  <v-container>
    <v-row justify="center" class="m-0">
      <v-col class="p-0">
        <v-card class="rounded" elevation="0">
          <v-toolbar class="reservationtoolbar rounded-top" color="primary" flat dark>
            <v-col cols="12" xs="12" sm="12" md="4" lg="6" xl="6" class="pl-0 pr-0">
              <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details filled rounded dense clearable></v-text-field>
            </v-col>
          </v-toolbar>

          <!-- start table for users -->
          <v-data-table :mobile-breakpoint="0" no-data-text="Nenašli sa žiadne rozpracované rezervácie" no-results-text="Nenašli sa žiadne rozpracované rezervácie" :header-props="headerProps" :footer-props="footerProps"
            :headers="headerSavedReservation" :items="savedReservation" :search="search" item-key="name" loading-text="Načítavanie... Prosím počkajte">
            <!-- reservation detail for users only-->
            <template v-slot:top>
              <v-dialog v-model="dialogShowDetail" fullscreen hide-overlay transition="dialog-bottom-transition" persistent>
                <v-card>
                  <v-toolbar extended extension-height="4" color="primary" class="rounded-0" flat dark>
                    <v-btn icon dark @click="dialogShowDetail = false">
                      <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title class="justify-center">Detail rezervácie</v-toolbar-title>
                  </v-toolbar>
                  <v-container v-if="userDetailSavedReservation != null">

                    <v-list class="pb-0" three-line subheader>
                      <v-subheader class="p-0">Status rezervácie</v-subheader>
                      <v-list-item class="p-0">
                        <v-list-item-content class="pb-0 pt-0">
                          <v-btn class="card-color-administration p-3" block rounded large>
                            <v-icon class="pr-1" small>mdi-progress-alert</v-icon> <span>Rozpracovaná rezervácia</span>
                          </v-btn>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list class="pb-0" three-line subheader>
                      <v-subheader class="p-0">Kontaktné údaje</v-subheader>
                      <v-list-item class="p-0">
                        <v-list-item-content class="pb-0">
                          <v-row justify="center">
                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <v-text-field ref="surname" v-model="userDetailSavedReservation.usercontactmodel.surname" label="Meno" readonly filled rounded v-if="userDetailSavedReservation.usercontactmodel.surname"></v-text-field>
                              <v-text-field ref="surname" value="-" label="Meno" readonly filled rounded v-else></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <v-text-field ref="lastname" v-model="userDetailSavedReservation.usercontactmodel.lastname" label="Priezvisko" readonly filled rounded v-if="userDetailSavedReservation.usercontactmodel.lastname"></v-text-field>
                              <v-text-field ref="lastname" value="-" label="Priezvisko" readonly filled rounded v-else></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                              <v-text-field ref="address" v-model="userDetailSavedReservation.usercontactmodel.address" label="Adresa" readonly filled rounded v-if="userDetailSavedReservation.usercontactmodel.address"></v-text-field>
                              <v-text-field ref="address" value="-" label="Adresa" readonly filled rounded v-else></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <v-text-field ref="city" v-model="userDetailSavedReservation.usercontactmodel.city" label="Mesto" readonly filled rounded v-if="userDetailSavedReservation.usercontactmodel.city"></v-text-field>
                              <v-text-field ref="city" value="-" label="Mesto" readonly filled rounded v-else></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0">
                              <v-text-field ref="postcode" v-model="userDetailSavedReservation.usercontactmodel.postcode" label="PSČ" readonly filled rounded v-if="userDetailSavedReservation.usercontactmodel.postcode"></v-text-field>
                              <v-text-field ref="postcode" value="-" label="PSČ" readonly filled rounded v-else></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <v-text-field ref="country" v-model="userDetailSavedReservation.usercontactmodel.country" label="Krajina" readonly filled rounded v-if="userDetailSavedReservation.usercontactmodel.country"></v-text-field>
                              <v-text-field ref="country" value="-" label="Krajina" readonly filled rounded v-else></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <VueTelInputVuetify class="mobpho" v-model="userDetailSavedReservation.usercontactmodel.phone" label="Mobilné číslo" placeholder="" disabled readonly filled rounded
                                v-if="userDetailSavedReservation.usercontactmodel.phone"></VueTelInputVuetify>
                              <VueTelInputVuetify class="mobpho" value="-" label="Mobilné číslo" placeholder="" disabled readonly filled rounded v-else></VueTelInputVuetify>
                            </v-col>

                            <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                              <div v-if="userDetailSavedReservation.note  == null">
                                <v-textarea value="-" label=" Poznámka" rows="1" readonly filled rounded auto-grow>
                                </v-textarea>
                              </div>
                              <div v-else>
                                <v-textarea v-model="userDetailSavedReservation.note " label=" Poznámka" rows="1" readonly filled rounded auto-grow>
                                </v-textarea>
                              </div>
                            </v-col>
                          </v-row>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list three-line subheader>
                      <v-subheader class="p-0">Dátum a čas vytvorenia rezervácie</v-subheader>
                      <v-list-item class="p-0">
                        <v-list-item-content>
                          <v-row>
                            <v-col cols="12">
                              <v-card class="p-4 card-color-administration rounded-pill" flat>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-calendar-clock</v-icon>
                                    <span class="pl-1">{{formatCreated(userDetailSavedReservation.created_at)}}</span>
                                  </v-col>
                                </v-row>
                              </v-card>
                            </v-col>
                          </v-row>
                        </v-list-item-content>
                      </v-list-item>

                      <v-subheader class="p-0">Dátum a čas príchodu a odchodu</v-subheader>
                      <v-list-item class="p-0">
                        <v-list-item-content>
                          <v-row>
                            <v-col cols="12" lg="6" md="6">
                              <v-card class="p-4 card-color-administration rounded-pill" flat>
                                <v-row class="justify-center">
                                  <span>Príchod</span>
                                </v-row>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-calendar-start</v-icon>
                                    <span class="pl-1">{{formatDate(userDetailSavedReservation.start_date)}}</span>
                                  </v-col>
                                </v-row>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-clock-start</v-icon>
                                    <span class="pl-1">{{userDetailSavedReservation.start_time}}</span>
                                  </v-col>
                                </v-row>
                              </v-card>
                            </v-col>
                            <v-col cols="12" lg="6" md="6">
                              <v-card class="p-4 card-color-administration rounded-pill" flat>
                                <v-row class="justify-center">
                                  <span>Odchod</span>
                                </v-row>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-calendar-end</v-icon>
                                    <span class="pl-1">{{formatDate(userDetailSavedReservation.end_date)}}</span>
                                  </v-col>
                                </v-row>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-clock-end</v-icon>
                                    <span class="pl-1">{{userDetailSavedReservation.end_time}}</span>
                                  </v-col>
                                </v-row>
                              </v-card>
                            </v-col>
                          </v-row>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list three-line subheader>
                      <v-subheader class="p-0">Suma rezervácie</v-subheader>
                      <v-row class="m-0 mt-3">
                        <v-col class="pl-0 pr-0" align="left">
                          <v-icon class="mb-1" color="orange">mdi-information</v-icon>
                          <span class="ml-1">Deti do 2 rokov sa do počtu hostí nezapočítavajú.</span>
                        </v-col>
                      </v-row>
                      <v-data-table :headers="headersDetail" :items="prices" class="elevation-0" disable-sort hide-default-header hide-default-footer :mobile-breakpoint="0">
                        <template v-slot:header="{ props: { headers } }">
                          <thead>
                            <tr>
                              <th v-for="(h, i) in headers" :key="i">
                                <v-tooltip bottom v-if="i != 3">
                                  <template v-slot:activator="{ on }">
                                    <span v-on="on">{{h.text}}</span>
                                  </template>
                                  <span>{{headerDetailTooltips[i - 1]}}</span>
                                </v-tooltip>
                                <span v-if="i == 3">{{h.text}}</span>
                              </th>
                            </tr>
                          </thead>
                        </template>
                      </v-data-table>
                    </v-list>
                  </v-container>
                </v-card>
              </v-dialog>

              <!-- start delete saved reservation -->
              <v-dialog v-model="dialogDelete" max-width="500px" persistent>
                <v-card>
                  <v-toolbar class="rounded-top" color="primary" flat dark tile justify="center">
                    <v-toolbar-title>Naozaj chcete zmazať rozpracovanú rezerváciu?</v-toolbar-title>
                  </v-toolbar>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="dialogDelete = false">Zatvoriť</v-btn>
                    <v-btn color="error" outlined @click="deleteItemConfirm(editSavedReservation)">Áno</v-btn>
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <!-- end delete saved reservation -->
            </template>

            <template v-slot:item.id="{ item }">
              <span>{{ savedReservation.map(function(x) {return x.id; }).indexOf(item.id) + 1 }}</span>
            </template>

            <template v-slot:item.created_at="{ item }">
              <span>{{ formatCreated(item.created_at) }}</span>
            </template>

            <template v-slot:item.event_name="{ }">
              <v-chip dark small>
                <v-icon class="pr-1" small>mdi-progress-alert</v-icon> <span>Rozpracovaná</span>
              </v-chip>
            </template>

            <template v-slot:item.start_date="{ item }">
              <span>{{ formatDate(item.start_date) }}</span>
            </template>

            <template v-slot:item.end_date="{ item }">
              <span>{{ formatDate(item.end_date) }}</span>
            </template>

            <template v-slot:item.overall_price="{ item }">
              <span>{{item.overall_price}} €</span>
            </template>

            <template v-slot:item.detail="{ item }">
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-icon v-bind="attrs" v-on="on" small @click="showDetail(item)">mdi-information</v-icon>
                </template>
                <span>Detail rezervácie</span>
              </v-tooltip>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
              <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
          </v-data-table>

          <!-- snackbar after successfully created reservation -->
          <v-snackbar v-model="snackbarDelete" :multi-line="multiLine" :color="snackbarDeleteColor" bottom left>
            <v-icon>mdi-check-circle</v-icon>
            <span class="pl-1">{{snackbarDeleteText}}</span>
            <template v-slot:action="{ attrs }">
              <v-btn color="white" fab text small v-bind="attrs" @click="snackbarDelete = false">
                <v-icon>mdi-close-circle</v-icon>
              </v-btn>
            </template>
          </v-snackbar>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import VueTelInputVuetify from "vue-tel-input-vuetify/lib/vue-tel-input-vuetify.vue"
export default {
  name: "SavedReservations",
  components: {
    VueTelInputVuetify
  },
  data() {
    return {
      username: localStorage.getItem("username"),
      show: false,
      overlay: true,
      savedReservation: [],
      search: null,
      searched: [],

      // Snackbar
      multiLine: true,
      snackbarDelete: false,
      snackbarDeleteText: '',
      snackbarDeleteColor: '',

      footerProps: {
        itemsPerPageText: 'Počet riadkov',
        itemsPerPageOptions: [5, 10, 15, -1],
      },
      headerProps: {
        sortByText: "Zoradiť podľa"
      },

      headerSavedReservation: [{
          text: 'ID',
          align: 'center',
          sortable: true,
          value: 'id',
        }, {
          text: 'Vytvorená',
          align: 'center',
          value: 'created_at',
          sortable: true,
        }, {
          text: 'Status',
          align: 'center',
          value: 'event_name',
          sortable: false,
        }, {
          text: 'Dátum začiatku',
          align: 'center',
          value: 'start_date',
          sortable: true,
        }, {
          text: 'Dátum konca',
          align: 'center',
          value: 'end_date',
          sortable: true,
        }, {
          text: 'Počet nocí',
          align: 'center',
          value: 'nights',
          sortable: false,
        }, {
          text: 'Počet osôb',
          align: 'center',
          value: 'total_persons',
          sortable: true,
        }, {
          text: 'Cena',
          align: 'center',
          value: 'overall_price',
          sortable: true,
        }, {
          text: 'Detail',
          align: 'center',
          value: 'detail',
          sortable: false
        },
        {
          text: 'Úkony',
          align: 'center',
          value: 'actions',
          sortable: false
        },
      ],

      // for user
      headersDetail: [{
          id: 1,
          text: '',
          sortable: false,
          value: 'text',
        },
        {
          id: 2,
          text: 'Počet osôb',
          value: 'p1',
          sortable: false,
        },
        {
          id: 3,
          text: 'Jednotková cena',
          value: 'p2',
          sortable: false,
        },
        {
          id: 4,
          text: 'Cena/noc',
          value: 'p3',
          sortable: false,
        },
        {
          id: 5,
          text: '',
          value: 'p4',
          sortable: false,
        },
      ],
      prices: [],
      headerDetailTooltips: [],

      dialogShowDetail: false,
      userDetailSavedReservation: null,
      editSavedReservation: null,
      dialogDelete: false,


    }
  },
  mounted() {
    this.getEvents();
    this.markAsRead();
  },

  updated() {},

  methods: {
    formatDate(value) {
      return new Date(Date.parse(value)).toLocaleDateString('sk-SK')
    },

    formatCreated(value) {
      return new Date(Date.parse(value)).toLocaleString('sk-SK', {
        timeZone: 'UTC'
      })
    },

    getColor(title) {
      if (title == 'rezervácia') return 'orange'
      else if (title == 'rezervované') return 'green'
    },

    editItem(item) {
      console.log(item);
    },

    deleteItem(item) {
      this.editSavedReservation = item;
      this.dialogDelete = true;
    },

    deleteItemConfirm(item) {
      axios.post(`${process.env.VUE_APP_API_URL}/savedReservation/delete`, {
          id: item.id
        })
        .then(res => {
          this.snackbarDelete = true;
          this.snackbarDeleteText = "Rezervácia bola úspešne vymazaná.";
          this.snackbarDeleteColor = 'success';
          this.dialogDelete = false;
          this.savedReservation.map((event, index) => {
            if (event.id == res.data[0].id) {
              this.savedReservation.splice(index, 1)
              this.searched.splice(index, 1)
            }
          })

          const api = `${process.env.VUE_APP_API_URL}/sendNotification`;
          const config = {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.getItem("authToken"),
            },
          };

          axios.post(api, {
              from: 1,
              recipient: item.user_id,
              title: "Chata Byšta",
              subtitle: "Vymazanie uloženej rezervácie",
              text: "Dobrý deň, Vaša uložená rezervácia bola vymazaná.",
              date: moment(new Date())
                .format('YYYY-MM-DD HH:mm'),
              status: "new",
            }, config)
            .then(() => {})
        })
    },

    showDetail(item) {
      this.dialogShowDetail = true;
      this.userDetailSavedReservation = item;
      this.updateTable(item, 'detail');
    },

    updateTable(item, type) {
      var nights = null;
      var counter1 = parseInt(item.adults);
      var counter2 = parseInt(item.childs_2_to_12)
      var counter3 = parseInt(item.childs_to_2);
      var cleaning_fee = parseInt(item.cleaning_fee);

      if (type == 'edit') {
        this.adminEditReservation.nights = String(moment(this.adminEditReservation.end_date, 'YYYY-MM-DD').diff(moment(this.adminEditReservation.start_date, 'YYYY-MM-DD'), 'days'));
        nights = this.adminEditReservation.nights;

        this.adminEditReservation.total_persons = String(counter1 + counter2 + counter3);

        if (counter1 + counter2 > 5) {
          this.adminEditReservation.overall_price = String(cleaning_fee +
            (counter1 * this.$root.prices.priceAdults * nights) +
            (counter2 * this.$root.prices.priceChilds2to12 * nights) +
            (counter3 * this.$root.prices.priceChildsto2 * nights));
        } else {
          this.adminEditReservation.overall_price = String(this.$root.prices.priceCabinUnderSixPpl * nights + cleaning_fee);
        }
      } else {
        nights = String(moment(item.end_date, 'YYYY-MM-DD').diff(moment(item.start_date, 'YYYY-MM-DD'), 'days'));
      }

      if (nights > 1) {
        this.headersDetail[4].text = 'Cena/' + nights + 'noci';
      } else {
        this.headersDetail[4].text = 'Cena/' + nights + 'noc';
      }

      this.headerDetailTooltips = [];
      this.headerDetailTooltips.push('Maximálny počet osôb je 20!');

      if (counter1 + counter2 > 5) {
        this.headerDetailTooltips.push('Cena za osobu na noc');
        this.headerDetailTooltips.push('');
      } else {
        this.headerDetailTooltips.push('Cena za celú chatu na 1 noc pri počte osôb <6');
        this.headerDetailTooltips.push('');
      }
      this.headerDetailTooltips.push(`${'Od ' + this.formatDate(item.start_date) + ' do ' + this.formatDate(item.end_date)}`);

      this.prices = [];

      if (counter1 + counter2 > 5) {
        if (counter2 > 0) {
          this.prices.splice(1, 0, {
            text: 'Deti od 2 do 12 rokov',
            p1: counter2,
            p2: this.$root.prices.priceChilds2to12 + '€',
            p3: counter2 * this.$root.prices.priceChilds2to12 + '€',
            p4: counter2 * this.$root.prices.priceChilds2to12 * nights + '€',
          });
        }
        if (counter3 > 0) {
          this.prices.splice(2, 0, {
            text: 'Deti do 2 rokov',
            p1: counter3,
            p2: this.$root.prices.priceChildsto2 + '€',
            p3: counter3 * this.$root.prices.priceChildsto2 + '€',
            p4: counter3 * this.$root.prices.priceChildsto2 * nights + '€',
          });
        }
        this.prices.splice(0, 0, {
          text: 'Dospelí',
          p1: counter1,
          p2: this.$root.prices.priceAdults + '€',
          p3: counter1 * this.$root.prices.priceAdults + '€',
          p4: counter1 * this.$root.prices.priceAdults * nights + '€',
        });

        this.prices.push({
          text: 'Upratovanie',
          p1: '',
          p2: '',
          p3: '',
          p4: cleaning_fee + '€',
        }, {
          text: 'Spolu',
          p1: counter1 + counter2 + counter3,
          p2: ((counter1 * this.$root.prices.priceAdults) / counter1) + ((counter2 * this.$root.prices.priceChilds2to12) / counter2 || 0) + ((counter3 * this.$root.prices.priceChildsto2) / counter3 || 0) + '€',
          p3: counter1 * this.$root.prices.priceAdults + counter2 * this.$root.prices.priceChilds2to12 + counter3 * this.$root.prices.priceChildsto2 + '€',
          p4: ((counter1 * this.$root.prices.priceAdults) * nights) + ((counter2 * this.$root.prices.priceChilds2to12) * nights || 0) + ((counter3 * this.$root.prices.priceChildsto2) * nights || 0) + cleaning_fee +
            '€',
        });
      } else {
        this.prices.push({
          text: 'Dospelí',
          p1: counter1,
          p2: '-',
          p3: '-',
          p4: '-',
        }, {
          text: 'Deti od 2 do 12 rokov',
          p1: counter2,
          p2: '-',
          p3: '-',
          p4: '-',
        }, {
          text: 'Deti do 2 rokov',
          p1: counter3,
          p2: '-',
          p3: '-',
          p4: '-',
        }, {
          text: 'Cena za celú chatu (<6 osôb)',
          p1: counter1 + counter2,
          p2: (item.overall_price - cleaning_fee) / nights + '€',
          p3: (item.overall_price - cleaning_fee) / nights + '€',
          p4: ((item.overall_price - cleaning_fee) / nights) * nights + '€',
        }, {
          text: 'Upratovanie',
          p1: '',
          p2: '',
          p3: '',
          p4: cleaning_fee + '€',
        }, {
          text: 'Spolu',
          p1: counter1 + counter2 + counter3,
          p2: (item.overall_price - cleaning_fee) / nights + '€',
          p3: (item.overall_price - cleaning_fee) / nights + '€',
          p4: (this.$root.prices.priceCabinUnderSixPpl * nights) + cleaning_fee + '€',
        });
      }
    },

    getEvents() {
      const api = `${process.env.VUE_APP_API_URL}/savedReservation`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.get(api, config)
        .then(res => {
          this.savedReservation = res.data;
          this.searched = this.savedReservation;
          this.overlay = false;
        })
    },

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
          this.$store.dispatch('savedReservationCounter', {
            savedReservCounter: res.data
          });
        });
    },

    markAsRead() {
      this.$store.dispatch('savedReservationCounter', {
        savedReservCounter: 0
      });
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      const api2 = `${process.env.VUE_APP_API_URL}/savedReservation/markAsRead`;

      axios.post(api2, {}, config)
        .then(() => {})
    }
  },

  created() {
    window.Echo.join('saved_reservation.' + localStorage.getItem("user_id"))
      .listen('SavedReservations', (e) => {
        if (e.status == 'created') {
          this.savedReservation.push(e.reservation[0])
        } else if (e.status == 'deleted') {
          this.savedReservation.map((event, index) => {
            if (event.id == e.reservation[0].id) {
              this.savedReservation.splice(index, 1);
            }
          })
        }
      })
  },
}
</script>

<style lang="scss" scoped>
.theme--light .v-card .card-color-administration {
    background: rgba(0, 0, 0, 0.06);
}

.theme--dark .v-card .card-color-administration {
    background: rgba(255, 255, 255, 0.08);
}

.v-application--is-ltr .v-text-field .v-input__append-inner {
    margin-left: auto;
    padding-left: 22px !important;
}

::v-deep .mobpho .v-input__icon--append {
    padding-left: 30px !important;
}

::v-deep .mobpho .country-code .v-input {
    border-bottom-right-radius: inherit;
    border-top-right-radius: inherit;
    border-bottom-left-radius: 50px;
    border-top-left-radius: 50px;
}

::v-deep .mobpho .v-input {
    border-bottom-left-radius: inherit;
    border-top-left-radius: inherit;
}

::v-deep .select-stat-reserv .v-label {
    top: 13px !important;
}
</style>
