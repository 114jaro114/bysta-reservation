<template>
<div class="moje_rezervacie w-100 h-100 mt-3">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card class="rounded" elevation="0">
          <v-card-title>
            <v-col cols="12" xs="12" sm="12" md="4" lg="6" xl="6" class="pl-0 pr-0">
              <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details clearable></v-text-field>
            </v-col>
            <v-col cols="12" xs="12" sm="12" md="4" lg="6" xl="6" class="pl-0 pr-0" v-if="user == 'admin'">
              <v-btn color="primary" dark class="mb-2" @click="dialog = !dialog"> Nová rezervácia </v-btn>
            </v-col>
          </v-card-title>
          <v-data-table no-data-text="Nenašli sa žiadne rezervácie" :header-props="headerProps" :footer-props="footerProps" :headers="headers" :items="currentEvents" :search="search" v-if="user == 'admin'" item-key="title"
            :loading="myloadingvariable" loading-text="Načítavanie... Prosím počkajte">
            <template v-slot:top>
              <!-- <v-toolbar flat> -->
              <!-- <v-toolbar-title>Rezervácie</v-toolbar-title> -->
              <!-- <v-spacer></v-spacer> -->
              <v-row justify="center">
                <v-col cols="12" xs="12" sm="12" md="4" lg="6" xl="6">
                  <v-dialog v-model="dialog" max-width="500px">
                    <!-- <template v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on"> Nová rezervácia </v-btn>
                  </template> -->
                    <v-card>
                      <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container>
                          <v-row>
                            <v-col class="d-flex" cols="12" sm="12">
                              <v-select :items="items" item-text="items" label="Status" v-model="newEvent.event_name"></v-select>
                            </v-col>
                          </v-row>
                          <v-row>
                            <v-col cols="12" sm="6">
                              <v-menu v-model="menu1" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                  <v-text-field v-model="newEvent.start_date" label="Dátum začiatku" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                </template>
                                <v-date-picker id="start_date" name="start_date" v-model="newEvent.start_date" @input="menu1 = false"></v-date-picker>
                              </v-menu>
                            </v-col>
                            <v-col cols="12" sm="6">
                              <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                  <v-text-field v-model="newEvent.end_date" label="Dátum konca" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                </template>
                                <v-date-picker id="end_date" name="end_date" v-model="newEvent.end_date" @input="menu2 = false"></v-date-picker>
                              </v-menu>
                            </v-col>
                          </v-row>
                        </v-container>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
                        <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  <v-dialog v-model="dialogDelete" max-width="500px">
                    <v-card>
                      <v-card-title class="headline text-center">Naozaj chcete zmazať rezerváciu?</v-card-title>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="closeDelete">Zatvoriť</v-btn>
                        <v-btn color="blue darken-1" text @click="deleteItemConfirm">Áno</v-btn>
                        <v-spacer></v-spacer>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-col>
              </v-row>
              <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
              <!-- <v-spacer></v-spacer> -->
              <!-- </v-toolbar> -->
            </template>
            <template v-slot:item.event_name="{ item }">
              <v-chip :color="getColor(item.event_name)" dark v-if="item.event_name == 'rezervácia'">
                <i class="fas fa-clock pr-1" style="color: white"></i> <span>Čaká sa</span>
                <!-- {{ item.title }} -->
              </v-chip>
              <v-chip :color="getColor(item.event_name)" dark v-else>
                <i class="fas fa-check-circle pr-1" style="color: white"></i> <span>Akceptované</span>
                <!-- {{ item.title }} -->
              </v-chip>
            </template>
            <template v-slot:item.adults="{ item }">
              <span>{{parseInt(item.adults) + parseInt(item.childs2to12) + parseInt(item.childsto2)}}</span>
            </template>

            <template v-slot:item.overallPriceForNight="{ item }">
              <span>{{item.overallPriceForNight}}€</span>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
              <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
            </template>
            <!-- <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
          </template> -->
          </v-data-table>
          <v-data-table no-data-text="Nenašli sa žiadne rezervácie" :header-props="headerProps" :footer-props="footerProps" :headers="headers2" :items="currentEventsForOneUser" :search="search" item-key="name" :loading="myloadingvariable"
            loading-text="Načítavanie... Prosím počkajte" v-else>
            <template v-slot:item.id="{ item }">
              <span>{{ currentEventsForOneUser.map(function(x) {return x.id; }).indexOf(item.id) + 1 }}</span>
            </template>
            <template v-slot:item.created_at="{ item }">
              <span>{{ formatCreated(item.created_at) }}</span>
            </template>
            <template v-slot:item.event_name="{ item }">
              <v-chip :color="getColor(item.event_name)" dark v-if="item.event_name == 'rezervácia'">
                <i class="fas fa-clock pr-1" style="color: white"></i> <span>Čaká sa</span>
                <!-- {{ item.title }} -->
              </v-chip>
              <v-chip :color="getColor(item.event_name)" dark v-else>
                <i class="fas fa-check-circle pr-1" style="color: white"></i> <span>Akceptované</span>
                <!-- {{ item.title }} -->
              </v-chip>
            </template>
            <template v-slot:item.start_date="{ item }">
              <span>{{ formatDate(item.start_date) }}</span>
            </template>
            <template v-slot:item.end_date="{ item }">
              <span>{{ formatDate(item.end_date) }}</span>
            </template>

            <template v-slot:item.adults="{ item }">
              <span>{{parseInt(item.adults) + parseInt(item.childs2to12) + parseInt(item.childsto2)}}</span>
            </template>

            <template v-slot:item.overallPriceForNight="{ item }">
              <span>{{item.overallPriceForNight}}€</span>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-dialog v-model="diagolShowDetail" fullscreen hide-overlay transition="dialog-bottom-transition">
                <template v-slot:activator="{ on: menu, attrs }">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on: tooltip }">
                      <v-icon v-bind="attrs" v-on="{ ...tooltip, ...menu }" medium @click="showDetail(item)">mdi-information </v-icon>
                    </template>
                    <span>Detail rezervácie</span>
                  </v-tooltip>
                </template>
                <v-card>
                  <v-toolbar dark color="primary">
                    <v-btn icon dark @click="diagolShowDetail = false">
                      <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title class="justify-center">Detail rezervácie</v-toolbar-title>
                    <!-- <v-spacer></v-spacer> -->
                    <!-- <v-toolbar-items>
                      <v-btn dark text @click="diagolShowDetail = false">
                        Save
                      </v-btn>
                    </v-toolbar-items> -->
                  </v-toolbar>
                  <v-list three-line subheader>
                    <v-subheader>Kontaktné údaje</v-subheader>
                    <v-list-item>
                      <v-list-item-content>
                        <!-- <v-list-item-title>Password</v-list-item-title>
                        <v-list-item-subtitle>Require password for purchase or use password to restrict purchase</v-list-item-subtitle> -->
                        <v-row justify="center">
                          <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                            <v-text-field ref="surname" v-model="surname" label="Meno" readonly></v-text-field>
                          </v-col>

                          <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                            <v-text-field ref="lastname" v-model="lastname" label="Priezvisko" readonly></v-text-field>
                          </v-col>

                          <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                            <v-text-field ref="address" v-model="address" label="Adresa" readonly></v-text-field>
                          </v-col>

                          <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                            <v-text-field ref="city" v-model="city" label="Mesto" readonly></v-text-field>
                          </v-col>

                          <v-col cols="12" sm="12" md="6" lg="6" class="pt-0">
                            <v-text-field ref="postcode" v-model="postcode" label="PSČ" readonly></v-text-field>
                          </v-col>

                          <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                            <v-autocomplete ref="country" v-model="country" :items="countries" label="Krajina" readonly>
                            </v-autocomplete>
                          </v-col>

                          <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                            <VueTelInputVuetify v-model="myPhone" label="Mobilné číslo" placeholder="" readonly></VueTelInputVuetify>
                          </v-col>

                          <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                            <div v-if="note == null">
                              <v-textarea value="-" label=" Poznámka" rows="1" readonly>
                              </v-textarea>
                            </div>
                            <div v-else>
                              <v-textarea v-model="note" label=" Poznámka" rows="1" readonly>
                              </v-textarea>
                            </div>
                          </v-col>
                        </v-row>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                  <v-divider></v-divider>
                  <v-list three-line subheader>
                    <v-subheader>Dátum a čas vytvorenia rezervácie</v-subheader>
                    <v-list-item>
                      <v-list-item-content>
                        <v-row>
                          <v-col cols="12">
                            <v-sheet class="p-4 mx-auto" rounded outlined>
                              <v-row class="justify-center">
                                <v-col>
                                  <v-icon>mdi-calendar-clock</v-icon>
                                  <span>{{reservationDetails.created_at}}</span>
                                </v-col>
                              </v-row>
                            </v-sheet>
                          </v-col>
                        </v-row>
                      </v-list-item-content>
                    </v-list-item>
                    <v-subheader>Dátum a čas príchodu a odchodu</v-subheader>
                    <v-list-item>
                      <v-list-item-content>
                        <v-row>
                          <v-col>
                            <v-sheet class="p-4 mx-auto" rounded outlined>
                              <v-row class="justify-center">
                                <span>Príchod</span>
                              </v-row>
                              <v-row class="justify-center">
                                <v-col>
                                  <v-icon>mdi-calendar-start</v-icon>
                                  <span>Dátum: {{reservationDetails.start_date}}</span>
                                </v-col>
                              </v-row>
                              <v-row class="justify-center">
                                <v-col>
                                  <v-icon>mdi-clock-start</v-icon>
                                  <span>Čas: {{reservationDetails.start_time}}</span>
                                </v-col>
                              </v-row>
                            </v-sheet>
                          </v-col>
                          <v-col>
                            <v-sheet class="p-4 mx-auto" rounded outlined>
                              <v-row class="justify-center">
                                <span>Odchod</span>
                              </v-row>
                              <v-row class="justify-center">
                                <v-col>
                                  <v-icon>mdi-calendar-end</v-icon>
                                  <span>Dátum: {{reservationDetails.end_date}}</span>
                                </v-col>
                              </v-row>
                              <v-row class="justify-center">
                                <v-col>
                                  <v-icon>mdi-clock-end</v-icon>
                                  <span>Čas: {{reservationDetails.end_time}}</span>
                                </v-col>
                              </v-row>
                            </v-sheet>
                          </v-col>
                        </v-row>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                  <v-divider></v-divider>
                  <v-list three-line subheader>
                    <v-subheader>Počet osôb</v-subheader>
                    <v-list-item>
                      <v-list-item-content>
                        <v-row class="m-0">
                          <v-col></v-col>
                          <v-col class="font-weight-bold">
                            <v-tooltip bottom>
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">Počet osôb</span>
                              </template>
                              <span>Maximálny počet osôb je 20!</span>
                            </v-tooltip>

                          </v-col>
                          <v-col class="font-weight-bold">
                            <v-tooltip bottom>
                              <template v-slot:activator="{ on, attrs }">
                                <v-icon v-bind="attrs" v-on="on">mdi-information</v-icon>
                                <span>Cena/noc</span>
                              </template>
                              <span v-if="counter1 > 1">Cena na jednu noc za {{counter1}} osoby</span>
                              <span v-else>Cena za 1 noc pre {{counter1}} osobu</span>
                            </v-tooltip>

                          </v-col>
                          <v-col class="font-weight-bold">
                            <v-tooltip bottom>
                              <template v-slot:activator="{ on, attrs }">
                                <v-icon v-bind="attrs" v-on="on">mdi-information</v-icon>
                              </template>
                              <span>Od {{reservationDetails.start_date}} do {{reservationDetails.end_date}}</span>
                            </v-tooltip>
                            <span v-if="reservationDetails.nights > 1">Cena/{{reservationDetails.nights}} noci</span>
                            <span v-else>Cena/{{reservationDetails.nights}} noc</span>
                          </v-col>
                        </v-row>
                        <v-row class="m-0">
                          <v-col>
                            <span>Dospelí</span>
                          </v-col>
                          <v-col>
                            <span>{{counter1}}</span>
                          </v-col>
                          <v-col>
                            <span>{{counter1*priceAdults}} €</span>
                          </v-col>
                          <v-col>
                            <span>{{counter1*priceAdults*reservationDetails.nights}} €</span>
                          </v-col>
                        </v-row>

                        <v-divider v-if="counter2 > 0" />
                        <v-row class="m-0" v-if="counter2 > 0">
                          <v-col>
                            <span>Deti od 2 do 12 rokov</span>
                          </v-col>
                          <v-col>
                            <span>{{counter2}}</span>
                          </v-col>
                          <v-col>
                            <span>{{counter2*priceChilds2to12}} €</span>
                          </v-col>
                          <v-col>
                            <span>{{counter2*priceChilds2to12*reservationDetails.nights}} €</span>
                          </v-col>
                        </v-row>

                        <v-divider v-if="counter3 > 0" />
                        <v-row class="m-0" v-if="counter3 > 0">
                          <v-col>
                            <span>Deti do 2 rokov</span>
                          </v-col>
                          <v-col>
                            <span>{{counter3}}</span>
                          </v-col>
                          <v-col>
                            <span>{{counter3*priceChildsto2}} €</span>
                          </v-col>
                          <v-col>
                            <span>{{counter3*priceChildsto2*reservationDetails.nights}} €</span>
                          </v-col>
                        </v-row>

                        <v-divider />
                        <v-row class="m-0">
                          <v-col>
                            <span class="font-weight-bold">Spolu</span>
                          </v-col>
                          <v-col>
                            <v-tooltip bottom>
                              <template v-slot:activator="{ on, attrs }">
                                <span class="font-weight-bold" v-bind="attrs" v-on="on">{{counter1+counter2+counter3}}</span>
                              </template>
                              <span>Celkový počet osôb: {{counter1+counter2+counter3}}</span>
                            </v-tooltip>
                          </v-col>
                          <v-col>
                            <v-tooltip bottom>
                              <template v-slot:activator="{ on, attrs }">
                                <span class="font-weight-bold" v-bind="attrs" v-on="on">{{counter1*priceAdults + counter2*priceChilds2to12 + counter3*priceChildsto2}} €</span>
                              </template>
                              <span v-if="counter1+counter2+counter3 > 1">Cena je za {{counter1+counter2+counter3}} osoby na 1 noc</span>
                              <span v-else>Celková cena za {{counter1+counter2+counter3}} osobu na 1 noc</span>
                            </v-tooltip>
                          </v-col>
                          <v-col>
                            <v-tooltip bottom>
                              <template v-slot:activator="{ on, attrs }">
                                <span class="text-decoration-underline font-weight-bold" v-bind="attrs" v-on="on">
                                  {{reservationDetails.overallPriceForNight}} €</span>
                              </template>
                              <span v-if="counter1+counter2+counter3 > 1">Celková cena za {{counter1 + counter2 + counter3}} osoby na {{reservationDetails.nights}} noci</span>
                              <span v-else>Celková cena za {{counter1+counter2+counter3}} osobu na {{reservationDetails.nights}} noci</span>
                            </v-tooltip>
                          </v-col>
                        </v-row>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </v-card>
              </v-dialog>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import VueTelInputVuetify from "vue-tel-input-vuetify/lib/vue-tel-input-vuetify.vue"

export default {
  name: "MojeRezervacie",
  components: {
    VueTelInputVuetify
  },
  data() {
    return {
      currentEvents: [],
      currentEventsForOneUser: [],
      indexToUpdate: "",
      newEvent: {
        id: "",
        event_name: "",
        start_date: "",
        end_date: "",
        // color: "",
        username: "",
      },
      user: localStorage.getItem("username"),
      perPage: 3,
      currentPage: 1,
      showDialog: false,
      search: null,
      searched: [],
      menu1: false,
      menu2: false,
      dialog: false,
      diagolShowDetail: false,
      dialogDelete: false,
      footerProps: {
        itemsPerPageText: 'Počet riadkov',
        itemsPerPageOptions: [5, 10, 15, -1],
      },
      headerProps: {
        sortByText: "Zoradiť podľa"
      },
      headers: [{
        text: 'ID',
        align: 'id',
        sortable: true,
        value: 'id',
      }, {
        text: 'Status',
        value: 'event_name',
        sortable: false,
      }, {
        text: 'Dátum začiatku',
        value: 'start_date',
        sortable: true,
      }, {
        text: 'Dátum konca',
        value: 'end_date',
        sortable: true,
      }, {
        text: 'Používateľ',
        value: 'username',
        sortable: true,
      }, {
        text: 'Čas príchodu',
        value: 'start_time',
        sortable: true,
      }, {
        text: 'Čas odchodu',
        value: 'end_time',
        sortable: false,
      }, {
        text: 'Počet nocí',
        value: 'nights',
        sortable: false,
      }, {
        text: 'Počet osôb',
        value: 'adults',
        sortable: true,
      }, {
        text: 'Cena',
        value: 'overallPriceForNight',
        sortable: true,
      }, {
        text: 'Úkony',
        value: 'actions',
        sortable: false
      }, ],
      headers2: [{
          text: 'ID',
          align: 'id',
          sortable: false,
          value: 'id',
        }, {
          text: 'Vytvorená',
          value: 'created_at',
          sortable: true,
        }, {
          text: 'Status',
          value: 'event_name',
          sortable: false,
        }, {
          text: 'Dátum začiatku',
          value: 'start_date',
          sortable: true,
        }, {
          text: 'Dátum konca',
          value: 'end_date',
          sortable: true,
        },
        // {
        //   text: 'Čas príchodu',
        //   value: 'start_time',
        //   sortable: false,
        // }, {
        //   text: 'Čas odchodu',
        //   value: 'end_time',
        //   sortable: false,
        // }, {
        //   text: 'Počet nocí',
        //   value: 'nights',
        //   sortable: true,
        // }, {
        //   text: 'Počet osôb',
        //   value: 'adults',
        //   sortable: true,
        // }, {
        //   text: 'Cena',
        //   value: 'overallPriceForNight',
        //   sortable: true,
        // },
        {
          text: 'Detail',
          value: 'actions',
          sortable: false
        }
      ],
      editedIndex: -1,
      editedItem: {
        id: "",
        event_name: "",
        start_date: "",
        end_date: "",
        color: "",
        username: "",
      },
      defaultItem: {
        id: "",
        event_name: "",
        start_date: "",
        end_date: "",
        color: "",
        username: "",
      },
      items: ['rezervácia', 'rezervované'],
      myloadingvariable: true,
      numberOfPersons: null,

      reservationDetails: {
        id: "",
        event_name: "",
        created_at: "",
        start_date: "",
        end_date: "",
        start_time: "",
        end_time: "",
        adults: "",
        childs2to12: "",
        childsto2: "",
        nights: "",
        overallPriceForNight: "",
        priceForNight: "",
      },
      counter1: "",
      counter2: "",
      counter3: "",
      counter4: "",
      priceAdults: 18,
      priceChildsto2: 0,
      priceChilds2to12: 18,
    }
  },
  async created() {
    try {
      let response = await axios.get('http://127.0.0.1:8000/api/reservation')
      console.log(response);
      this.currentEvents = response.data.data
      this.searched = this.currentEvents
    } catch (err) {
      console.log(err)
    }
    this.initialize()
  },
  computed: {
    rows() {
      return this.currentEvents.length
    },
    messageClass() {
      return {
        'md-invalid': this.hasMessages
      }
    },
    formTitle() {
      return this.editedIndex === -1 ? 'Pridať rezerváciu' : 'Editácia rezervácie'
    },
  },
  watch: {
    dialog(val) {
      val || this.close()
    },
    dialogDelete(val) {
      val || this.closeDelete()
    },
  },
  mounted: function mounted() {
    this.getEvents();
  },
  methods: {
    formatDate(value) {
      return moment(value)
        .format("YYYY-MM-DD")
    },

    formatCreated(value) {
      return moment(value)
        .format("YYYY-MM-DD HH:mm:ss")

    },

    showDetail(item) {
      console.log(item);
      this.dialogShowDetail = true;
      console.log(this.dialogShowDetail)
      this.reservationDetails.id = item.id;
      this.reservationDetails.event_name = item.event_name;
      this.reservationDetails.created_at = moment(item.created_at)
        .format('YYYY/MM/DD HH:mm:ss');
      this.reservationDetails.start_date = item.start_date;
      this.reservationDetails.end_date = item.end_date;
      this.reservationDetails.start_time = item.start_time;
      this.reservationDetails.end_time = item.end_time;
      this.reservationDetails.adults = item.adults;
      this.reservationDetails.childs2to12 = item.childs2to12;
      this.reservationDetails.childsto2 = item.childsto2;
      this.reservationDetails.nights = item.nights;
      this.reservationDetails.overallPriceForNight = item.overallPriceForNight;
      this.reservationDetails.priceForNight = item.priceForNight;
      this.counter1 = parseInt(item.adults);
      this.counter2 = parseInt(item.childs2to12);
      this.counter3 = parseInt(item.childsto2);
    },

    addReservation() {
      this.$router.push("/administration/create_reservation");
    },
    getEvents() {
      axios.get('http://127.0.0.1:8000/api/reservation')
        .then(resp => {
          console.log(resp.data);
          this.currentEvents = resp.data
          this.searched = this.currentEvents
          for (var i = 0; i < resp.data.length; i++) {
            if (resp.data[i].username == this.user) {
              this.currentEventsForOneUser.push(resp.data[i]);
            }
          }
          // console.log(this.currentEventsForOneUser);
          this.myloadingvariable = false;
        })
        .catch(err => console.log(err.resp.data));
    },
    resetForm() {
      Object.keys(this.newEvent)
        .forEach(key => {
          return (this.newEvent[key] = "");
        });
    },
    //vueify table
    getColor(title) {
      if (title == 'rezervácia') return 'orange'
      else if (title == 'rezervované') return 'green'
    },
    initialize() {
      this.currentEvents;
    },
    editItem(item) {
      // console.log(item);
      this.editedIndex = this.currentEvents.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.newEvent.id = item.id;
      this.newEvent.event_name = item.event_name;
      this.newEvent.start_date = item.start_date;
      this.newEvent.end_date = item.end_date;
      // this.newEvent.color = item.color;
      this.newEvent.username = item.username;
      this.dialog = true
    },
    deleteItem(item) {
      this.editedIndex = item.id
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },
    deleteItemConfirm() {
      this.currentEvents.splice(this.editedIndex, 1)
      axios.post('http://127.0.0.1:8000/api/reservation/delete', {
          id: this.editedIndex
        })
        .then(() => {
          this.getEvents();
        })
        .catch(err => console.log("Unable to delete event!", err.response.data));
      this.closeDelete()
    },
    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
    closeDelete() {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
    save() {
      if (this.editedIndex > -1) {
        //update
        console.log(this.newEvent.event_name)
        axios.post('http://127.0.0.1:8000/api/reservation/update', {
            id: this.newEvent.id,
            event_name: this.newEvent.event_name,
            start_date: this.newEvent.start_date,
            end_date: this.newEvent.end_date,
          })
          .then((res) => {
            const api = 'http://127.0.0.1:8000/api/sendNotification';
            const config = {
              headers: {
                Accept: "application/json",
                Authorization: "Bearer " + localStorage.getItem("authToken"),
              },
            };
            axios.post(api, {
                recipient: res.data[0].id,
                title: "Chata Byšta",
                subtitle: "Potvrdenie rezervácie",
                text: "Dobrý deň, Vaša rezervácia bola potvrdená. Tešíme sa na Vašu návštevu.",
                date: moment(new Date())
                  .format('YYYY-MM-DD HH:mm'),
                status: "new",
              }, config)
              .then(() => {})
            this.getEvents();
          })
          .catch(err => console.log("Unable to update event!", err.response.data));
        Object.assign(this.currentEvents[this.editedIndex], this.editedItem)
      } else {
        //add
        this.newEvent.event_name = "rezervácia";
        this.newEvent.username = this.user;
        axios.post('http://127.0.0.1:8000/api/reservation/store', {
            ...this.newEvent
          })
          .then(() => {
            this.getEvents();
            this.resetForm();
          })
          .catch(err => console.log("nepodarilo sa pridat event", err.response.data));
        this.resetForm();
        // this.currentEvents.push(this.editedItem)
      }
      this.close()
    },
  },
}
</script>
<style lang="scss">
.friend-search .md-field.md-theme-default:after {
    background-color: unset !important;
}

.md-dialog .md-tabs-content,
.md-table .md-content {
    min-height: 0 !important;
    display: flex;
    flex-wrap: wrap;
    padding: 0 !important;
}

.md-dialog .md-dialog-actions {
    padding: 12px !important;
}

// data-table animations
// .list-enter-active,
// .list-leave-active {
//     transition: all 0.8s;
// }
// .list-enter,
// .list-leave-to {
//     opacity: 0;
//     transform: translateY(100%);
// }
// .list-move {
//     transition: transform 0.5s;
// }
// .item-row {
//     display: table-row;
// }
</style>
