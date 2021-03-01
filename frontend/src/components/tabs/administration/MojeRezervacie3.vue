<template>
  <div class="moje_rezervacie w-100 h-100 text-uppercase secondary-color">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="row justify-content-center mr-0 ml-0">
      <div class="col pl-0 pr-0 mt-3">
        <v-card v-if="user == 'admin'">
          <v-card-title>
            Rezervácie
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
          </v-card-title>
          <v-data-table :headers="headers" :items="currentEvents" :search="search">
            <template v-slot:item.title="{ item }">
              <v-chip :color="getColor(item.calories)" dark v-if="item.title == 'rezervácia'">
                <i class="fas fa-clock pr-1" style="color: orange"></i> <span>Čaká sa</span>
                <!-- {{ item.title }} -->
              </v-chip>
              <v-chip :color="getColor(item.calories)" dark v-else>
                <i class="fas fa-check-circle pr-1" style="color: green"></i> <span>Akceptované</span>
                <!-- {{ item.title }} -->
              </v-chip>
            </template>

            <template>
              <v-btn color="blue darken-1" text @click="close">
                Cancel
              </v-btn>
              <v-btn color="blue darken-1" text @click="save">
                Save
              </v-btn>
            </template>


            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">
                Cancel
              </v-btn>
              <v-btn color="blue darken-1" text @click="save">
                Save
              </v-btn>
            </v-card-actions>
          </v-data-table>
        </v-card>
        <v-card v-else>
          <v-card-title>
            Rezervácie
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
          </v-card-title>
          <v-data-table :headers="headers" :items="currentEvents" :search="search">
            <template v-slot:item.title="{ item }">
              <v-chip :color="getColor(item.calories)" dark v-if="item.title == 'rezervácia'">
                <i class="fas fa-clock pr-1" style="color: orange"></i> <span>Čaká sa</span>
                <!-- {{ item.title }} -->
              </v-chip>
              <v-chip :color="getColor(item.calories)" dark v-else>
                <i class="fas fa-check-circle pr-1" style="color: green"></i> <span>Akceptované</span>
                <!-- {{ item.title }} -->
              </v-chip>
            </template>
          </v-data-table>
        </v-card>
        <v-data-table :headers="headers" :items="desserts" sort-by="calories" class="elevation-1">
          <template v-slot:top>
            <v-toolbar flat>
              <v-toolbar-title>Rey</v-toolbar-title>
              <v-divider class="mx-4" inset vertical></v-divider>
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                    Nová rezervácia
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field v-model="editedItem.name" label="Dessert name"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field v-model="editedItem.calories" label="Calories"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field v-model="editedItem.fat" label="Fat (g)"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field v-model="editedItem.carbs" label="Carbs (g)"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                          <v-text-field v-model="editedItem.protein" label="Protein (g)"></v-text-field>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">
                      Cancel
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="save">
                      Save
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">
              mdi-pencil
            </v-icon>
            <v-icon small @click="deleteItem(item)">
              mdi-delete
            </v-icon>
          </template>
          <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">
              Reset
            </v-btn>
          </template>
        </v-data-table>
        <md-table v-model="searched" md-sort="username" md-sort-order="asc" md-card md-fixed-header class="mt-3">
          <md-table-toolbar>
            <div class="md-toolbar-section-start">
              <h1 class="md-title">Rezervácie</h1>
            </div>
            <md-field class="md-toolbar-section-end" md-clearable :class="messageClass" v-if="user == 'admin'">
              <md-icon class="fa fa-search"></md-icon>
              <label for="search">Vyhľadať podľa mena</label>
              <md-input name="search" id="search" v-model="search" @input="searchOnTable" />
              <span class="md-error md-error-pl">Oops</span>
            </md-field>
          </md-table-toolbar>

          <div v-if="user == 'admin'">
            <md-table-row slot="md-table-row" class="test-center" v-for="(data, name) in searched" :key="name">
              <md-table-cell class="text-center" md-label="ID">{{ name + 1 }}</md-table-cell>
              <md-table-cell class="text-center" md-label="STATUS" md-sort-by="title">{{ data.title }}</md-table-cell>
              <md-table-cell class="text-center" md-label="DÁTUM ZAČIATKU" md-sort-by="start">{{ data.start }}</md-table-cell>
              <md-table-cell class="text-center" md-label="DÁTUM KONCA" md-sort-by="end">{{ data.end }}</md-table-cell>
              <md-table-cell class="text-center" md-label="POUŽÍVATEĽ" md-sort-by="username">{{ data.username }}</md-table-cell>
              <md-table-cell class="text-center" md-label="Editácia">
                <md-button class="md-primary md-raised md-accent text-center" @click="showDialog = true; setVal(data.id, data.title, data.start, data.end, data.color, data.username)" style="background-color: orange">Editovať</md-button>
              </md-table-cell>
              <md-table-cell class="text-center" md-label="Zmazanie">
                <md-button class="md-primary md-raised md-accent text-center" @click="setVal(data.id, data.title, data.start, data.end, data.color, data.username); deleteEvent()" style="background-color: red">Zmazať</md-button>
              </md-table-cell>
            </md-table-row>
          </div>
          <div v-else>
            <md-table-row slot="md-table-row" class="test-center" v-for="(data, name) in searched" :key="name">
              <div class="test" v-if="data.username == user">
                <md-table-cell class="text-center" md-label="ID">{{ name + 1 }}</md-table-cell>
                <md-table-cell class="text-center" md-label="STATUS" v-if="data.title == 'rezervované'"><i class="fas fa-check-circle" style="color: green"></i> AKCEPTOVNÉ</md-table-cell>
                <md-table-cell class="text-center" md-label="STATUS" v-else><i class="fas fa-clock" style="color: orange"></i> ČAKÁ SA</md-table-cell>
                <md-table-cell class="text-center" md-label="DÁTUM ZAČIATKU" md-sort-by="start">{{ data.start }}</md-table-cell>
                <md-table-cell class="text-center" md-label="DÁTUM KONCA" md-sort-by="end">{{ data.end }}</md-table-cell>
                <md-table-cell class="text-center" md-label="POUŽÍVATEĽ">{{ data.username }}</md-table-cell>
              </div>
            </md-table-row>
          </div>

        </md-table>
        <md-dialog :md-active.sync="showDialog">
          <md-tabs md-dynamic-height>
            <md-tab md-label="Editácia">
              <form @submit.prevent>
                <div class="row ml-0 mr-0">
                  <div class="col-6 pl-0">
                    <div class="form-group">
                      <label for="event_name">Názov</label>
                      <select id="event_name" name="event_name" class="form-control" v-model="newEvent.event_name">
                        <option>rezervácia</option>
                        <option>rezervované</option>
                      </select>
                    </div>
                  </div>

                  <!-- <div class="col-6 pr-0">
                  <div class="form-group">
                    <label for="color">Example select</label>
                    <select id="color" name="color" class="form-control" v-model="newEvent.color">
                      <option>orange</option>
                      <option>red</option>
                    </select>
                  </div>
                </div> -->
                </div>
                <div class="row ml-0 mr-0">
                  <div class="col-6 pl-0">
                    <div class="form-group">
                      <label for="start_date">Dátum začiatku</label>
                      <input type="date" id="start_date" name="start_date" class="form-control" required="required" v-model="newEvent.start_date">
                    </div>
                  </div>

                  <div class="col-6 pr-0">
                    <div class="form-group">
                      <label for="end_date">Dátum konca</label>
                      <input type="date" id="end_date" name="end_date" class="form-control" required="required" v-model="newEvent.end_date">
                    </div>
                  </div>
                </div>
              </form>
            </md-tab>
          </md-tabs>

          <md-dialog-actions class="reservation-dialog">
            <md-button class="md-primary md-raised" @click="showDialog = false">Close</md-button>
            <md-button class="md-primary md-raised" @click="updateEvent(); showDialog = false">Editovať</md-button>
            <md-button class="md-primary md-raised" @click="deleteEvent(); showDialog = false">Zmazať</md-button>
          </md-dialog-actions>
        </md-dialog>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';

  const toLower = text => {
    return text.toString().toLowerCase()
  }

  const searchByName = (datas, term) => {
    if (term) {
      return datas.filter(data => toLower(data.username).includes(toLower(term)))
    }

    return datas
  }
  export default {
    name: "MojeRezervacie",
    components: {},
    data() {
      return {
        currentEvents: [],
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

        headers: [{
            text: 'ID',
            align: 'start',
            sortable: false,
            value: 'id',
          },
          {
            text: 'Status',
            value: 'title',
            sortable: false,
          },
          {
            text: 'Dátum začiatku',
            value: 'start'
          },
          {
            text: 'Dátum konca',
            value: 'end'
          },
          {
            text: 'Používateľ',
            value: 'username',
            sortable: false,
          },
          {
            text: 'Actions',
            value: 'actions',
            sortable: false
          },
        ],
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
    },

    computed: {
      rows() {
        return this.currentEvents.length
      },
      messageClass() {
        return {
          'md-invalid': this.hasMessages
        }
      }
    },

    mounted: function mounted() {
      this.getEvents();
    },

    methods: {
      newUser() {
        window.alert('Noop')
      },
      searchOnTable() {
        this.searched = searchByName(this.currentEvents, this.search);
        if (!this.search) {
          this.hasMessages = false;
        } else {
          if (this.searched.length == 0) {
            this.hasMessages = true;
            this.showTable = false;
          } else {
            this.hasMessages = false;
            this.showTable = true;
          }
        }
      },

      addReservation() {
        this.$router.push("/administration/create_reservation");
      },

      addNewEvent() {
        this.newEvent.event_name = "rezervácia";
        this.newEvent.username = this.user;
        this.newEvent.color = "orange";
        axios.post('http://127.0.0.1:8000/api/calendar/store', {
            ...this.newEvent
          })
          .then(resp => {
            console.log(resp);
            this.getEvents();
            this.resetForm();
          })
          .catch(err =>
            console.log("nepodarilo sa pridat event", err.response.data)
          );
        this.resetForm();
      },

      setVal(val_id, val_title, val_start, val_end, val_color, val_username) {
        this.idForRemove = val_id;
        this.newEvent.id = val_id;
        this.newEvent.event_name = val_title;
        this.newEvent.start_date = val_start;
        this.newEvent.end_date = val_end;
        this.newEvent.color = val_color;
        this.newEvent.username = val_username;
      },
      getEvents() {
        axios.get('http://127.0.0.1:8000/api/calendar')
          .then(resp => {
            console.log(resp);
            this.currentEvents = resp.data.data
            this.searched = this.currentEvents
            console.log(this.currentEvents);
          })
          .catch(err => console.log(err.resp.data));
      },

      updateEvent() {
        console.log(this.newEvent);
        if (this.newEvent.event_name == 'rezervované') {
          this.newEvent.color = 'red';
        } else {
          this.newEvent.color = 'orange';
        }

        axios.post('http://127.0.0.1:8000/api/calendar/update', {
            // ...this.newEvent
            id: this.newEvent.id,
            event_name: this.newEvent.event_name,
            start_date: this.newEvent.start_date,
            end_date: this.newEvent.end_date,
            color: this.newEvent.color
          })
          .then(resp => {
            console.log(resp);
            this.getEvents();
          })
          .catch(err =>
            console.log("Unable to update event!", err.response.data)
          );
      },

      deleteEvent() {
        if (confirm("Naozaj chceš vymazať rezerváciu?")) {
          axios.post('http://127.0.0.1:8000/api/calendar/delete', {
              id: this.newEvent.id
            })
            .then(resp => {
              console.log(resp);
              this.getEvents();
            })
            .catch(err =>
              console.log("Unable to delete event!", err.response.data)
            );
        }
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
