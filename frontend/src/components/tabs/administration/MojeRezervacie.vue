<template>
<div class="moje_rezervacie w-100 h-100 text-uppercase mt-1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <v-row justify="center" class="ml-0 mr-0">
    <v-col>
      <v-card color="primary">
        <v-data-table no-data-text="Nenašli sa žiadne rezervácie" :header-props="headerProps" :footer-props="footerProps" :headers="headers" :items="currentEvents" :search="search" sort-by="id" v-if="user == 'admin'" item-key="title"
          :loading="myloadingvariable" loading-text="Načítavanie... Prosím počkajte">
          <template v-slot:top>
            <v-toolbar flat>
              <!-- <v-toolbar-title>Rezervácie</v-toolbar-title> -->
              <!-- <v-spacer></v-spacer> -->
              <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details></v-text-field>
              <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on"> Nová rezervácia </v-btn>
                </template>
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
            </v-toolbar>
          </template>
          <template v-slot:item.title="{ item }">
            <v-chip :color="getColor(item.title)" dark v-if="item.title == 'rezervácia'">
              <i class="fas fa-clock pr-1" style="color: orange"></i> <span>Čaká sa</span>
              <!-- {{ item.title }} -->
            </v-chip>
            <v-chip :color="getColor(item.title)" dark v-else>
              <i class="fas fa-check-circle pr-1" style="color: green"></i> <span>Akceptované</span>
              <!-- {{ item.title }} -->
            </v-chip>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
            <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
          </template>
          <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
          </template>
        </v-data-table>
        <v-data-table no-data-text="Nenašli sa žiadne rezervácie" :header-props="headerProps" :footer-props="footerProps" :headers="headers2" :items="currentEventsForOneUser" :search="search" item-key="name" :loading="myloadingvariable"
          loading-text="Načítavanie... Prosím počkajte" v-else>
          <template v-slot:item.id="{ item }">
            <span>{{ currentEventsForOneUser.map(function(x) {return x.id; }).indexOf(item.id) + 1 }}</span>
          </template>
          <template v-slot:item.title="{ item }">
            <v-chip :color="getColor(item.title)" dark v-if="item.title == 'rezervácia'">
              <i class="fas fa-clock pr-1" style="color: orange"></i> <span>Čaká sa</span>
              <!-- {{ item.title }} -->
            </v-chip>
            <v-chip :color="getColor(item.title)" dark v-else>
              <i class="fas fa-check-circle pr-1" style="color: green"></i> <span>Akceptované</span>
              <!-- {{ item.title }} -->
            </v-chip>
          </template>
          <template v-slot:item.start="{ item }">
            <span>{{ formatStart_date(item.start) }}</span>
          </template>
          <template v-slot:item.end="{ item }">
            <span>{{ formatEnd_date(item.end) }}</span>
          </template>

          <template v-slot:item.username="{ item }">
            <v-icon>mdi-account</v-icon>
            <span>{{item.username}}</span>
          </template>
        </v-data-table>
      </v-card>
    </v-col>
  </v-row>
</div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';

export default {
  name: "MojeRezervacie",
  components: {},
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
        color: "",
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
        align: 'start',
        sortable: false,
        value: 'id',
      }, {
        text: 'Status',
        value: 'title',
        sortable: false,
      }, {
        text: 'Dátum začiatku',
        value: 'start'
      }, {
        text: 'Dátum konca',
        value: 'end'
      }, {
        text: 'Používateľ',
        value: 'username',
        sortable: false,
      }, {
        text: 'Actions',
        value: 'actions',
        sortable: false
      }, ],
      headers2: [{
        text: 'ID',
        align: 'start',
        sortable: false,
        value: 'id',
      }, {
        text: 'Status',
        value: 'title',
        sortable: false,
      }, {
        text: 'Dátum začiatku',
        value: 'start'
      }, {
        text: 'Dátum konca',
        value: 'end'
      }, {
        text: 'Používateľ',
        value: 'username',
        sortable: false,
      }, ],
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
    }
  },
  async created() {
    try {
      let response = await axios.get('http://127.0.0.1:8000/api/calendar')
      this.currentEvents = response.data.data
      this.searched = this.currentEvents
      console.log(response.data.data)
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
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
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
    formatStart_date(value) {
      return moment(value).format("YYYY-MM-DD")
    },
    formatEnd_date(value) {
      return moment(value).format("YYYY-MM-DD")
    },
    addReservation() {
      this.$router.push("/administration/create_reservation");
    },
    getEvents() {
      axios.get('http://127.0.0.1:8000/api/calendar').then(resp => {
        console.log(resp);
        this.currentEvents = resp.data.data
        this.searched = this.currentEvents
        for (var i = 0; i < resp.data.data.length; i++) {
          console.log(resp.data.data);
          if (resp.data.data[i].username == this.user) {
            this.currentEventsForOneUser.push(resp.data.data[i]);
          }
        }
        console.log(this.currentEventsForOneUser);
        this.myloadingvariable = false;
      }).catch(err => console.log(err.resp.data));
    },
    resetForm() {
      Object.keys(this.newEvent).forEach(key => {
        return (this.newEvent[key] = "");
      });
    },
    //vueify table
    getColor(title) {
      if (title == 'rezervacia') return 'orange'
      else if (title == 'rezervované') return 'red'
    },
    initialize() {
      this.currentEvents;
    },
    editItem(item) {
      // console.log(item);
      this.editedIndex = this.currentEvents.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.newEvent.id = item.id;
      this.newEvent.event_name = item.title;
      this.newEvent.start_date = item.start;
      this.newEvent.end_date = item.end;
      this.newEvent.color = item.color;
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
      axios.post('http://127.0.0.1:8000/api/calendar/delete', {
        id: this.editedIndex
      }).then(resp => {
        console.log(resp);
        this.getEvents();
      }).catch(err => console.log("Unable to delete event!", err.response.data));
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
        if (this.newEvent.event_name == 'rezervované') {
          this.newEvent.color = 'red';
        } else {
          this.newEvent.color = 'orange';
        }
        axios.post('http://127.0.0.1:8000/api/calendar/update', {
          id: this.newEvent.id,
          event_name: this.newEvent.event_name,
          start_date: this.newEvent.start_date,
          end_date: this.newEvent.end_date,
          color: this.newEvent.color
        }).then(resp => {
          console.log(resp);
          this.getEvents();
          console.log("jupi")
        }).catch(err => console.log("Unable to update event!", err.response.data));
        Object.assign(this.currentEvents[this.editedIndex], this.editedItem)
      } else {
        //add
        this.newEvent.event_name = "rezervácia";
        this.newEvent.username = this.user;
        this.newEvent.color = "orange";
        axios.post('http://127.0.0.1:8000/api/calendar/store', {
          ...this.newEvent
        }).then(resp => {
          console.log(resp);
          this.getEvents();
          this.resetForm();
        }).catch(err => console.log("nepodarilo sa pridat event", err.response.data));
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
</style>
