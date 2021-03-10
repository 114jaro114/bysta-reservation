<template>
<div class='calendar'>
  <form @submit.prevent>
    <div class="row ml-0 mr-0" v-show="showInputs">
      <!-- <div class="form-group">
          <label for="event_id">id</label>
          <input type="text" id="event_id" name="event_id" class="form-control" v-model="newEvent.event_id">
          </select>
        </div> -->
      <div class="col-6 pl-0">
        <div class="md-layout-item">
          <md-field>
            <md-select v-model="newEvent.event_name" name="event_name" id="event_name">
              <md-option value="rezervácia">rezervácia</md-option>
              <md-option value="rezervované">rezervované</md-option>
            </md-select>
          </md-field>
        </div>
      </div>
      <div class="col-6 pr-0">
        <div class="md-layout-item">
          <md-field>
            <md-select v-model="newEvent.color" name="color" id="color">
              <md-option value="orange">orange</md-option>
              <md-option value="red">red</md-option>
            </md-select>
          </md-field>
        </div>
      </div>
    </div>
    <v-alert v-model="alert3" type="success" dismissible> Rezervácia bola úspešne vytvorená. </v-alert>
    <v-alert v-model="alert2" type="info" dismissible> Už je evidovaná rezervácia s tvojím menom a zatiaľ nie je potvrdená. Po potvrdení rezervácie je možné vytvoriť ďalšiu! </v-alert>
    <v-alert v-model="alert1" type="warning"> Dátum začiatku/Dátum konca je povinný údaj! </v-alert>
    <v-alert v-model="alert4" type="success" dismissible> Rezervácia bola úspešne aktualizovaná. </v-alert>
    <v-alert v-model="alert5" type="success" dismissible> Rezervácia bola úspešne vymazaná. </v-alert>
    <div class="row bb ml-0 mr-0">
      <DatePicker ref="DatePicker" clickOutsideElementId="clickOutsideElement" :showCloseButton="false" :closeDatepickerOnClickOutside="true" @periodSelected="periodSelected" :disabledDates="disabledDates" :key="disabledDates.length" :halfDay="false"
        :i18n="ptSK" :gridStyle="false" :hoveringTooltip="false">
      </DatePicker>
      <!-- <DatePicker :endDate="new Date(new Date().getFullYear(), 11, 31)" /> -->

      <!-- <HotelDatePicker :gridStyle="false" :hoveringTooltip="true" /> -->
      <!-- {{ disabledDates }} -->
    </div>
    <div class="row bb ml-0 mr-0 pt-3">
      <DatePicker2 ref="DatePicker2" v-model="range" color="blue" mode="date" is-range :attributes='attrs' :min-date='new Date()' :disabled-dates="disabledDates" :timezone="timezone" is-expanded>
        <template v-slot:footer>
          <div class="bg-gray-100 text-center p-2 border-t rounded-b-lg">
            <v-divider></v-divider>
            <v-btn color="info" @click="moveToToday" block>
              Dnes
            </v-btn>
            <v-btn color="grey" @click="resetDate" block>
              X
            </v-btn>
          </div>
        </template>
      </DatePicker2>
    </div>
    <div class="row bb ml-0 mr-0 pt-3 pb-3" v-if="addingMode">
      <v-btn elevation="2" color="info" tile block @click="addNewEvent(), clearDates()"> Pridať rezerváciu</v-btn>
      <!-- <md-button class="add md-primary md-raised" @click="addNewEvent(), clearDates()">Pridať</md-button> -->
    </div>
    <div class="row bb ml-0 mr-0" v-else>
      <div class="col pl-0">
        <v-btn elevation="2" color="warning" tile block @click="updateEvent"> Zmeniť</v-btn>
        <!-- <md-button class="md-primary md-raised change" @click="updateEvent" style="background: orange">Zmeniť</md-button> -->
      </div>
      <div class="col pl-0 pr-0">
        <v-btn elevation="2" color="error" tile block @click="deleteEvent()"> Zmazať</v-btn>
        <!-- <md-button class="md-primary md-raised delete" @click="deleteEvent()" style="background: red">Zmazať</md-button> -->
      </div>
      <div class="col pr-0">
        <v-btn elevation="2" color="blue-grey" class="white--text" tile block @click="cancelEvent"> Zrušiť</v-btn>
        <!-- <md-button class="md-primary md-raised cancel" @click="cancelEvent" style="background: grey">Zrušiť</md-button> -->
      </div>
    </div>
  </form>

  <v-divider></v-divider>
  <!-- <hr class="mt-0 mb-1"> -->
  <FullCalendar id="myCalendar" @eventClick="showEvent" :options='calendarOptions'></FullCalendar>
</div>
</template>
<script>
import axios from 'axios';
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import bootstrapPlugin from '@fullcalendar/bootstrap';
import moment from 'moment';
import DatePicker from 'vue-hotel-datepicker2'
import DatePicker2 from 'v-calendar/lib/components/date-picker.umd'
export default {
  components: {
    FullCalendar, // make the <FullCalendar> tag available
    DatePicker,
    DatePicker2
  },
  props: ['selectStartDate'],
  data: function() {
    return {
      calendarOptions: {
        contentHeight: "auto",
        events: null,
        plugins: [
          dayGridPlugin,
          timeGridPlugin,
          interactionPlugin,
          bootstrapPlugin
        ],
        themeSystem: 'bootstrap',
        headerToolbar: {
          left: 'dayGridMonth,timeGridWeek,timeGridDay',
          // center: 'title',
          right: 'prev today next'
        },
        buttonText: {
          today: 'dnes',
          month: 'mesiac',
          week: 'týždeň',
          day: 'deň',
          list: 'list'
        },
        textEscape: false,
        locale: 'sk',
        editable: true,
        selectable: true,
        selectOverlap: false,
        selectMirror: true,
        displayEventTime: false,
        eventOverlap: false,
        eventResizableFromStart: true,
        eventDragMinDistance: 1,
        // dayMaxEvents: true,

        // timezone: 'local',
        // allDay: true,
        // allDayDefault: true,
        // displayEventTime: false,
        nextDayThreshold: '00:00:00',
        dayMaxEvents: 1,
        weekends: true,
        select: this.handleDateSelect,
        eventClick: this.showEvent,
        eventsSet: this.handleEvents,
        validRange: {
          start: moment(new Date())
            .format('YYYY-MM-DDTHH:mm:SS')
        }
      },
      // selectedDatesArray: [],
      // selectedDates: {
      //   startDate: "",
      //   endDate: ""
      // },
      // disabledDates: {
      //   to: new Date(2020, 0, 5), // Disable all dates up to specific date
      //   from: new Date(2020, 0, 26), // Disable all dates after specific date
      // },
      newEvent: {
        // event_id: "",
        event_name: "",
        start_date: "",
        end_date: "",
        color: "",
        username: "",
      },
      user: localStorage.getItem("username"),
      addingMode: true,
      showInputs: false,
      indexToUpdate: "",
      currentEvents: [],
      last_index: "",
      test: [],
      isPossibleAddEvent: 0,
      disabledDates: [],
      newCheckInDate: null,
      newCheckOutDate: null,
      minNights: 3,
      ptSK: {
        night: "Noc",
        nights: "Noci",
        "day-names": ["PO", "UT", "ST", "ŠT", "PI", "SO", "NE"],
        "check-in": "Od",
        "check-out": "Do",
        "month-names": ["Január", "Február", "Marec", "Apríl", "Máj", "Jún", "Júl", "August", "Septemer", "Október", "November", "December"],
        tooltip: {
          // halfDayCheckIn: "Reservas possíveis",
          // halfDayCheckOut: "Reservas possíveis",
          // saturdayToSaturday: "Sábado a Sábado<br/> apenas",
          // sundayToSunday: "Domingo a domingo<br/> apenas",
          minimumRequiredPeriod: "%{minNightInPeriod} %{night}"
        },
        checkIn: "2020-11-15",
        avatarImageUrl: null,
        // week: "semana",
        // weeks: "semanas"
      },

      alert1: false,
      alert2: false,
      alert3: false,
      alert4: false,
      alert5: false,


      // DatePicker2
      range: {
        start: null,
        end: null,
      },
      attrs: [{
        key: 'today',
        // highlight: true,
        bar: true,
        // dot: true,
        highlight: {
          // color: 'blue',
          // fillMode: 'solid',
        },
        dates: new Date(),
      }, ],
      // disabledDates: ['2021-02-02', '2021-02-11'],
      // {
      //   start: '2021-02-02',
      //   end: '2021-02-11'
      // }
      timezone: '',
    }
  },
  mounted: function mounted() {
    this.getEvents();
    const api = 'http://127.0.0.1:8000/api/user';
    const config = {
      headers: {
        Accept: "application/json",
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    axios.get(api, config)
      .then((response) => {
        if (response.data.avatar) {
          this.avatarImageUrl = "http://127.0.0.1:8000/storage/user-avatar/" + response.data.avatar;
        }
      })
      .catch((error) => {
        console.log(error)
      })
  },
  created() {
    this.getEvents();
  },
  methods: {
    moveToToday() {
      this.$refs.DatePicker2.move(new Date());
    },
    resetDate() {
      this.range.start = null;
      this.range.end = null;
    },
    periodSelected(event, checkIn, checkOut) {
      this.newEvent.start_date = moment(checkIn)
        .format('YYYY-MM-DDTHH:mm:SS');
      this.newEvent.end_date = moment(checkOut)
        .add(23, 'hours')
        .add(59, 'minutes')
        .format('YYYY-MM-DDTHH:mm:SS');
    },
    clearDates() {
      this.$refs.DatePicker.clearSelection();
    },
    handleDateSelect(selectInfo) {
      if (this.test != null) {
        for (var i = 0; i < this.test.length; i++) {
          if (this.user == this.test[i].username && this.test[i].color == "orange") {
            this.isPossibleAddEvent = 1;
          } else {
            this.isPossibleAddEvent = 0;
          }
        }
      }
      if (this.isPossibleAddEvent == 0) {
        this.last_index++
        let title = "rezervácia";
        let calendarApi = selectInfo.view.calendar
        calendarApi.unselect() // clear date selection
        console.log(new Date()
          .toISOString()
          .slice(0, 10));
        this.newEvent = {
          event_name: title,
          start_date: moment(selectInfo.start)
            .format('YYYY-MM-DDTHH:mm:SS'),
          end_date: moment(selectInfo.end)
            .subtract(1, 'days')
            .add(23, 'hours')
            .add(59, 'minutes')
            .format('YYYY-MM-DDTHH:mm:SS'),
          // start_date: selectInfo.startStr,
          // end_date: selectInfo.endStr,
          color: 'orange',
          username: this.user
        }

        console.log(this.newEvent);
        axios.post('http://127.0.0.1:8000/api/calendar/store', {
            ...this.newEvent
          })
          .then(res => {
            console.log(res);
            this.alert3 = true;
            this.$store.dispatch('actionSuccessReservation', {
              success: true
            });
            this.getEvents();
            this.resetForm();
          })
          .catch(err => console.log("nepodarilo sa pridat event", err));
      } else {
        this.alert2 = true;
      }
    },
    handleEvents(events) {
      this.currentEvents = events;
      for (var i = 0; i < events.length; i++) {
        if (this.calendarOptions.events[i] == null) {
          this.newEvent = {
            event_name: this.currentEvents[i].title,
            start_date: this.currentEvents[i].startStr,
            end_date: this.currentEvents[i].endStr,
            color: this.currentEvents[i].borderColor,
          }

          if (this.currentEvents[i].borderColor == 'orange') {
            axios.post('http://127.0.0.1:8000/api/calendar/update', {
                ...this.newEvent,
                id: this.currentEvents[i].id
              })
              .then(res => {
                console.log(res);
                console.log("cau");
                this.updateDatePicker();
              })
          }
        } else {
          if (this.calendarOptions.events[i].username == this.user) {
            this.newEvent = {
              event_name: this.currentEvents[i].title,
              start_date: this.currentEvents[i].startStr,
              end_date: this.currentEvents[i].endStr,
              color: this.currentEvents[i].borderColor,
            }
            if (this.currentEvents[i].borderColor == 'orange') {
              axios.post('http://127.0.0.1:8000/api/calendar/update', {
                  ...this.newEvent,
                  id: this.currentEvents[i].id
                })
                .then(res => {
                  console.log(res);
                  console.log("cau");
                  this.updateDatePicker();
                })
              this.resetForm();
            }
          }
        }
      }
      this.newEvent.start_date = '';
      this.newEvent.end_date = '';
    },
    ///////////////////////////////////////////////////////////
    addNewEvent() {
      if (this.test != null) {
        for (var i = 0; i < this.test.length; i++) {
          if (this.user == this.test[i].username && this.test[i].color == "orange") {
            this.isPossibleAddEvent = 1;
          } else {
            this.isPossibleAddEvent = 0;
          }
        }
      }
      if (this.isPossibleAddEvent == 0) {
        this.newEvent.event_name = "rezervácia";
        this.newEvent.username = this.user;
        this.newEvent.color = "orange";

        if (this.newEvent.start_date == "" || this.addNewEvent.end_date == "") {
          this.alert1 = true;
        } else {
          axios.post('http://127.0.0.1:8000/api/calendar/store', {
              ...this.newEvent
            })
            .then(res => {
              console.log(res);
              this.$store.dispatch('actionSuccessReservation', {
                success: true
              });
              this.getEvents();
              this.resetForm();
              this.alert3 = true;
            })
            .catch(err => console.log("nepodarilo sa pridat event", err));
        }
      } else {
        this.alert2 = true;
      }
    },
    showEvent(arg) {
      const {
        id,
        title,
        start,
        end,
        color,
        username
      } = this.calendarOptions.events.find(event => event.id === +arg.event.id);
      if (this.user == "admin") {
        this.addingMode = false;
        this.showInputs = true;
      }
      if (this.user == username && color == 'orange' || this.user == "admin") {
        this.addingMode = false;
      } else {
        return;
      }
      this.indexToUpdate = id;
      this.newEvent = {
        id: this.indexToUpdate,
        event_name: title,
        start_date: start,
        end_date: end,
        color,
      };
    },
    updateEvent() {
      this.newEvent.username = this.user;
      axios.post('http://127.0.0.1:8000/api/calendar/update', {
          ...this.newEvent
        })
        .then(res => {
          console.log("cau");
          console.log(res);
          this.getEvents();
          this.showInputs = false;
          this.addingMode = !this.addingMode;
          this.resetForm();
          this.alert4 = true;
        })
        .catch(err => console.log("Unable to update event!", err));
    },
    deleteEvent() {
      if (confirm("Naozaj chceš vymazať rezerváciu?")) {
        this.isPossibleAddEvent = 0;
        axios.post('http://127.0.0.1:8000/api/calendar/delete', {
            id: this.indexToUpdate
          })
          .then(res => {
            console.log(res);
            // this.disabledDates = null;
            this.$store.dispatch('actionSuccessReservation', {
              success: false
            });
            this.getEvents();
            this.resetForm();
            this.addingMode = !this.addingMode;
            this.showInputs = false;
            this.alert5 = true;
          })
          .catch(err => console.log("Unable to delete event!", err));
      }
    },
    cancelEvent() {
      this.showInputs = false;
      this.addingMode = !this.addingMode;
      this.resetForm();
    },
    getEvents() {
      axios.get('http://127.0.0.1:8000/api/calendar')
        .then(resp => {
          this.calendarOptions.events = resp.data.data;
          //this code contains disabled dates in datepicker
          this.disabledDates = [];
          for (var i = 0; i < resp.data.data.length; i++) {
            var day1 = moment(resp.data.data[i].end);
            var day2 = moment(resp.data.data[i].start);
            var result = [moment({
              ...day2
            })];
            while (day1.date() != day2.date()) {
              day2.add(1, 'day');
              result.push(moment({
                ...day2
              }));
            }
            var allDates = result.map(x => x.format("YYYY-MM-DD"));
            for (var a = 0; a < allDates.length; a++) {
              this.disabledDates.push(allDates[a])
            }
          }
          // get data
          this.test = resp.data.data;
          if (resp.data.data != undefined) {
            this.last_index = resp.data.data[resp.data.data.length - 1].id;
          }
        })
        .catch(err => console.log(err));
    },

    resetForm() {
      Object.keys(this.newEvent)
        .forEach(key => {
          return (this.newEvent[key] = "");
        });
    },

    updateDatePicker() {
      axios.get('http://127.0.0.1:8000/api/calendar')
        .then(resp => {
          // this.calendarOptions.events = resp.data.data;
          //this code contains disabled dates in datepicker
          console.log(resp.data.data);
          this.disabledDates = [];
          for (var i = 0; i < resp.data.data.length; i++) {
            var day1 = moment(resp.data.data[i].end);
            var day2 = moment(resp.data.data[i].start);
            var result = [moment({
              ...day2
            })];
            while (day1.date() != day2.date()) {
              day2.add(1, 'day');
              result.push(moment({
                ...day2
              }));
            }
            var allDates = result.map(x => x.format("YYYY-MM-DD"));
            for (var a = 0; a < allDates.length; a++) {
              this.disabledDates.push(allDates[a])
            }
          }

          console.log(this.disabledDates);
        })
    },
  },
  watch: {
    indexToUpdate() {
      return this.indexToUpdate;
    },
  },

  updated() {
    console.log("this is updated");
    this.newEvent.start_date = moment(this.range.start)
      .format('YYYY-MM-DDTHH:mm:SS');
    this.newEvent.end_date = moment(this.range.end)
      .add(23, 'hours')
      .add(59, 'minutes')
      .format('YYYY-MM-DDTHH:mm:SS');
    console.log(this.newEvent.start_date);
    console.log(this.newEvent.end_date);
    // this.updateDatePicker();
    // this.getEvents();
    // console.log(this.newEvent.start_date);
    // console.log(this.newEvent.end_date);
    // if (this.newEvent.start_date && this.newEvent.end_date) {
    //   console.log("supeer");
    //   this.addNewEvent();
    // }
    //do something after updating vue instance
  }
}
</script>
<style lang='css'>
  .content-body {
    flex-grow: 1;
    padding: 3em;
  }

  .calendar .md-button {
    margin: 0 !important;
  }

  .fc .fc-button-primary {
    color: #fff !important;
    background-color: #007bff !important;
    border: unset !important;
    border-color: unset !important;
    transition: all .2s ease-in-out;
  }

  .fc .fc-button-primary:focus {
    box-shadow: unset !important;
    transform: scale(1.1);
    transition: all .2s ease-in-out;
  }

  .calendar .md-field:last-child {
    margin-bottom: 20px;
  }

  /* SHADE DAYS IN THE PAST */
  td.fc-day.fc-past {
    background-color: #EEEEEE;
  }

  /* .datepicker__close-button {
    color: #007bff !important;
    font-size: 34px !important;
    left: 4px !important;
    right: unset !important;
    top: 120px !important;
  } */

.fc-toolbar-chunk .btn {
  border-radius: 0 !important;
  padding: 0.3rem 0.5rem;
}
  /* .demo {
  margin-bottom: 200px;
  &-example {
    margin-bottom: 60px;
  }
  code {
    padding: 4px;
    color: #0088ff;
    font-weight: 700;
    background-color: #ececec;
    border-radius: 4px;
  }
} */

/* datepicker2 */
.vc-day.is-not-in-month *[data-v-005dafc8] {
    opacity: 1;
    color: #2196f3;
    pointer-events: inherit;
}

.vc-day-content.is-disabled[data-v-005dafc8] {
    color: var(--gray-400) !important;
}
</style>
