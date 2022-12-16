<template>
<div class='calendar'>
  <v-container class="p-0">
    <v-card class="rounded" elevation="0">
      <DatePicker2 ref="DatePicker2" v-model="range" :is-dark="this.$vuetify.theme.dark" color="blue" mode="dateTime" is24hr :model-config="modelConfig" is-range :attributes='attrs' :min-date='new Date()' :disabled-dates="disabledDates"
        :timezone="timezone" is-expanded>
        <template v-slot:footer>
          <div class="text-center p-2 pt-0 border-t rounded-b-lg">
            <v-divider class="mt-0"></v-divider>
            <v-btn color="primary" @click="moveToToday" class="mr-3">
              Dnes
            </v-btn>
            <v-btn color="primary" @click="resetDate" outlined>
              Resetovať výber
            </v-btn>
          </div>
        </template>
      </DatePicker2>
    </v-card>
  </v-container>
</div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import DatePicker2 from 'v-calendar/lib/components/date-picker.umd'

export default {
  components: {
    DatePicker2
  },

  props: {
    adminEditReservation: {
      type: Object,
      default: null
    },

    currentEvents: {
      type: Array,
      default: null
    }
  },

  data() {
    return {
      disabledDates: [],
      disabledDatesCopy: [],
      calendarData: [],
      calendarDataCopy: [],
      newEvent: {
        event_name: "",
        start_date: "",
        end_date: "",
        username: "",
      },

      user: localStorage.getItem("username"),
      // DatePicker2
      range: {
        start: '',
        end: '',
      },

      timezone: '',

      modelConfig: {
        type: 'string',
        mask: 'iso',
        timeAdjust: 'now',
      },

      detail: null,
    }
  },

  watch: {
    currentEvents: {
      handler: function() {
        console.log("current data");
        this.disabledDates = [];

        this.$emit('loaded-events', false);

        for (var i = 0; i < this.currentEvents.length; i++) {
          var day1 = moment(this.currentEvents[i].end_date);
          var day2 = moment(this.currentEvents[i].start_date);
          var result = [moment({
            ...day2
          })];

          while (day1.date() != day2.date()) {
            day2.add(1, 'day');
            result.push(moment({
              ...day2
            }));
          }

          result.map(x => {
            this.disabledDates.push(x.format("YYYY-MM-DD"))
          })

          result.map(x => {
            this.disabledDatesCopy.push(x.format("YYYY-MM-DD"))
          })
        }
        // get data
        this.calendarData = this.currentEvents;
        this.calendarDataCopy = this.currentEvents;
      },
      deep: true
    },

    adminEditReservation: {
      handler: function() {
        console.log("watch");
        this.detail = this.adminEditReservation;
        var day1 = moment(this.adminEditReservation.end_date);
        var day2 = moment(this.adminEditReservation.start_date);
        var result = [moment({
          ...day2
        })];

        while (day1.date() != day2.date()) {
          day2.add(1, 'day');
          result.push(moment({
            ...day2
          }));
        }

        var dates = [];
        result.map(x => {
          dates.push(x.format("YYYY-MM-DD"))
        })

        this.disabledDates = [];
        this.disabledDates.push(...this.disabledDatesCopy)

        dates.map(value1 => {
          this.disabledDates.map((value2, index2) => {
            if (value2 == value1) {
              this.disabledDates.splice(index2, 1);
            }
          })
        })

        this.calendarData = [];
        this.calendarData.push(...this.calendarDataCopy);

        this.calendarData.map((d, i) => {
          if (d.id == this.adminEditReservation.id) {
            this.calendarData.splice(i, 1)
          }
        })
      },
      deep: true
    },
  },

  computed: {
    attrs() {
      return [
        // Today attribute
        {
          key: 'today',
          dot: {
            style: {
              color: 'white',
              borderColor: 'red'
            }
          },
          dates: new Date(),
        },
        // Attributes for todos
        ...this.calendarData.map(todo => ({
          key: todo.id,
          dates: {
            start: todo.start_date,
            end: todo.end_date
          },
          customData: todo,
          order: todo.id,
          highlight: {
            start: {
              color: this.color(todo.event_name),
              fillMode: 'solid'
            },
            base: {
              color: this.color(todo.event_name),
              fillMode: 'light'
            },
            end: {
              color: this.color(todo.event_name),
              fillMode: 'solid'
            },
            opacity: todo.isComplete ? 0.3 : 1,
          },
          contentStyle: {
            color: 'white', // White text
          },
          contentHoverStyle: {
            backgroundColor: 'rgba(0, 0, 0, 0.1)',
            cursor: 'pointer',
          },
          popover: {
            slot: 'add-todo',
            label: todo.event_name + ' - používateľ ' + todo.username,
            visibility: 'focus',
            // hideIndicator: true,
          },
        })),
      ];
    },
  },

  mounted() {
    this.getEvents();
  },

  created() {
    // window.Echo.join('reservation.' + this.$root.me.id)
    //   .listen('Reservations', (e) => {
    //     console.log("echo calendar admin");
    //     if (this.$route.fullPath == '/administration') {
    //       if (this.$root.me.id == 1) {
    //         console.log("admin");
    //         if (e.status == 'created') {
    //           var day1 = moment(e.reservation[0].end_date);
    //           var day2 = moment(e.reservation[0].start_date);
    //           var result = [moment({
    //             ...day2
    //           })];
    //
    //           while (day1.date() != day2.date()) {
    //             day2.add(1, 'day');
    //             result.push(moment({
    //               ...day2
    //             }));
    //           }
    //
    //           result.map(x => {
    //             this.disabledDates.push(x.format("YYYY-MM-DD"))
    //           })
    //
    //           result.map(x => {
    //             this.disabledDatesCopy.push(x.format("YYYY-MM-DD"))
    //           })
    //
    //           this.calendarData.push(e.reservation[0])
    //           this.calendarDataCopy.push(e.reservation[0])
    //         }
    //
    //         if (e.status == 'updated') {
    //           console.log("updated");
    //           this.calendarData.map((event, index) => {
    //             if (event.id == e.reservation[0].id) {
    //               console.log("1");
    //               this.calendarData.splice(index, 1, e.reservation[0]);
    //
    //               // remove old dates
    //               var oldDay1 = moment(event.end_date);
    //               var oldDay2 = moment(event.start_date);
    //               var oldResult = [moment({
    //                 ...oldDay2
    //               })];
    //
    //               while (oldDay1.date() != oldDay2.date()) {
    //                 oldDay2.add(1, 'day');
    //                 oldResult.push(moment({
    //                   ...oldDay2
    //                 }));
    //               }
    //
    //               var oldDisabledDates = [];
    //               oldResult.map(x => {
    //                 oldDisabledDates.push(x.format("YYYY-MM-DD"))
    //               })
    //
    //               this.disabledDates.map((dd, idd) => {
    //                 oldDisabledDates.map(odd => {
    //                   if (dd == odd) {
    //                     this.disabledDates.splice(idd, 1);
    //                   }
    //                 })
    //               })
    //
    //               // add new dates
    //               var newDay1 = moment(e.reservation[0].end_date);
    //               var newDay2 = moment(e.reservation[0].start_date);
    //               var newResult = [moment({
    //                 ...newDay2
    //               })];
    //
    //               while (newDay1.date() != newDay2.date()) {
    //                 newDay2.add(1, 'day');
    //                 newResult.push(moment({
    //                   ...newDay2
    //                 }));
    //               }
    //
    //               var newDisabledDates = [];
    //               newResult.map(x => {
    //                 newDisabledDates.push(x.format("YYYY-MM-DD"))
    //               })
    //
    //               newDisabledDates.map(ndd => {
    //                 this.disabledDates.push(ndd)
    //               })
    //             }
    //           })
    //
    //           this.disabledDatesCopy.map((event, index) => {
    //             if (event.id == e.reservation[0].id) {
    //               this.disabledDatesCopy.splice(index, 1, e.reservation[0]);
    //             }
    //           })
    //
    //         }
    //
    //         if (e.status == 'deleted') {
    //
    //           this.calendarData.map((event, index) => {
    //             if (event.id == e.reservation[0].id) {
    //               this.calendarData.splice(index, 1);
    //             }
    //           })
    //
    //           this.disabledDatesCopy.map((event, index) => {
    //             if (event.id == e.reservation[0].id) {
    //               this.disabledDatesCopy.splice(index, 1);
    //             }
    //           })
    //         }
    //       }
    //     }
    //   })
  },

  methods: {
    color(e) {
      if (e == 'rezervácia') {
        return 'orange'
      } else {
        return 'red'
      }
    },
    moveToToday() {
      this.$refs.DatePicker2.move(new Date());
    },
    resetDate() {
      this.range = {
        start: '',
        end: ''
      };
      this.newEvent.start_date = '';
      this.newEvent.end_date = '';
    },

    getEvents() {
      const api = `${process.env.VUE_APP_API_URL}/allReservation`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.get(api, config)
        .then(res => {
          //this code contains disabled dates in datepicker
          this.disabledDates = [];

          this.$emit('loaded-events', false);

          for (var i = 0; i < res.data.length; i++) {
            var day1 = moment(res.data[i].end_date);
            var day2 = moment(res.data[i].start_date);
            var result = [moment({
              ...day2
            })];

            while (day1.date() != day2.date()) {
              day2.add(1, 'day');
              result.push(moment({
                ...day2
              }));
            }

            result.map(x => {
              this.disabledDates.push(x.format("YYYY-MM-DD"))
            })

            result.map(x => {
              this.disabledDatesCopy.push(x.format("YYYY-MM-DD"))
            })
          }
          // get data
          this.calendarData = res.data;
          this.calendarDataCopy = res.data;
        })
        .catch(() => {});
    },
  },

  updated() {
    //do something after updating vue instance
    console.log("update");
    console.log(this.detail);

    if (this.range.start != '' && this.range.end != '') {
      const arrayDate = [];
      arrayDate.push(moment(this.range.start)
        .format('YYYY-MM-DDTHH:mm:ss'), moment(this.range.end)
        .format('YYYY-MM-DDTHH:mm:ss'))
      this.$emit('array-dates', arrayDate);
      this.newEvent = {
        // event_id: "",
        event_name: "rezervácia",
        start_date: moment(this.range.start)
          .format('YYYY-MM-DDTHH:mm:ss'),
        end_date: moment(this.range.end)
          .add(23, 'hours')
          .add(59, 'minutes')
          .format('YYYY-MM-DDTHH:mm:ss'),
        // color: "orange",
        username: this.user,
      };
    }
  },

  getPopoverHeaderLabel(day) {
    const options = {
      weekday: 'short',
      year: 'numeric',
      month: 'short',
      day: 'numeric'
    };
    return day.date.toLocaleDateString(window.navigator.userLanguage || window.navigator.language, options);
  },
}
</script>
<style lang='css'>

/* datepicker2 */
.vc-day.is-not-in-month *[data-v-005dafc8] {
    opacity: 0.6;
    /* opacity: 1; */
    color: #9fd0f9;
    /* color: rgba(255, 255, 255, 0.6); */
    /* pointer-events: inherit; */
}
.vc-container {
  border-radius: unset;
  border: 0px;
}

/* todos */
.popover-header {
  text-align: center;
  padding-bottom: 3px;
  border-bottom: 1px solid #dadada;
  margin: 0 0 3px 0;
  opacity: 0.7;
}

.todo-row {
  display: flex;
  flex-wrap: none;
  width: 100%;
}

.todo-content {
  flex-grow: 1;
  flex-basis: 0;
  margin-right: 10px;
  min-width: 80px;
}

.todo-input {
  width: 100%;
  min-width: 200px;
}

.todo-description {
  cursor: pointer;
  transition: all 0.1s ease-in-out;
  margin-left: 3px;
}

.todo-description:hover {
  opacity: 0.5;
}

.todo-description.complete {
  text-decoration: line-through;
}

.add-todo {
  font-size: 0.8rem;
  text-align: center;
  width: 100%;
}

.delete-todo {
  margin-left: 3px;
}

/*  */
.vc-container.vc-is-dark {
  background-color: #1E1E1E;
  color: #FFFFFF;
}

.vc-time-picker {
  text-align: center;
}
</style>
