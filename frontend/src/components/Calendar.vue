<template>
<div class='calendar'>
  <v-container class="p-0">
    <!-- :loading="events" -->
    <v-card class="rounded" elevation="0">
      <DatePicker2 ref="DatePicker2" v-model="range" :is-dark="this.$vuetify.theme.dark" color="blue" mode="dateTime" is24hr :model-config="modelConfig" is-range :attributes='attrs' :min-date='new Date()' :disabled-dates="disabledDates"
        :timezone="timezone" is-expanded>
        <!--=========DAY POPOVER HEADER SLOT=========-->
        <div slot='day-popover-header' slot-scope='{ day }' class='popover-header'>
          {{ getPopoverHeaderLabel(day) }}
        </div>
        <!--===============TODO ROW SLOT==============-->
        <div slot='todo-row' slot-scope='{ customData }' class='todo-row'>
          <!--Todo content-->
          <div class='todo-content'>
            <!--Show textbox when editing todo-->
            <input class='todo-input' v-if='customData.id === editId' v-model='customData.description' @keyup.enter='editId = 0' v-focus-select />
            <!--Show status/description when not editing-->
            <span v-else>
              <!--Completed checkbox-->
              <input type='checkbox' v-model='customData.isComplete' />
              <!--Description-->
              <span :class='[
                      "todo-description",
                      { "complete": customData.isComplete }]' @click='toggleTodoComplete(customData)'>
                {{ customData.description }}
              </span>
            </span>
          </div>
          <!--Edit/Done buttons-->
          <a @click.prevent='toggleTodoEdit(customData)'>
            <!--Edit button-->
            <v-icon v-if='editId !== customData.id'>mdi-pencil</v-icon>
            <!--Done button-->
            <b-icon v-else icon='check' type='is-success' size='is-small'>
            </b-icon>
          </a>
          <!--Delete button-->
          <a @click.prevent='deleteTodo(customData)' v-if='!editId || editId !== customData.id' class='delete-todo'>
            <b-icon icon='trash' type='is-danger' size='is-small'>
            </b-icon>
          </a>
        </div>
        <!--================ADD TODO ROW SLOT===============-->
        <div slot='add-todo' slot-scope='{ day }' class='add-todo'>
          <a @click='addTodo(day)'>
            + Add Todo
          </a>
        </div>
        <!-- <template v-slot:header>
          <v-divider></v-divider>
        </template> -->

        <template v-slot:footer>
          <div class="text-center p-2">
            <v-divider class="mt-0"></v-divider>
            <v-btn color="primary" @click="moveToToday" class="mr-3">
              Dnes
            </v-btn>
            <v-btn color="primary" @click="resetDate" outlined>
              Resetova?? v??ber
            </v-btn>
            <v-divider />
          </div>
        </template>
      </DatePicker2>
      <div class="pl-1 pr-1">
        <v-col class="p-0" cols="12" lg="12" md="12" sm="12">
          <v-icon class="mb-1" color="orange">mdi-rectangle</v-icon>
          <span>Rezerv??cia je na tieto dni u?? vytvoren??, av??ak e??te <span class="font-weight-bold"> nie je akceptovan??.</span></span>
        </v-col>

        <v-col class="p-0" cols="12" lg="12" md="12" sm="12">
          <v-icon class="mb-1" color="red">mdi-rectangle</v-icon>
          <span>Rezerv??cia bola na tieto dni vytvoren?? a aktu??lne <span class="font-weight-bold"> u?? je akceptovan??.</span></span>
        </v-col>
      </div>
    </v-card>
  </v-container>
</div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import DatePicker2 from 'v-calendar/lib/components/date-picker.umd'
// const todos = [{
//     id: 1,
//     description: 'Rezerv??cia',
//     isComplete: false,
//     dates: {
//       start: '2021-02-26',
//       end: '2021-02-28'
//     },
//     color: '#dd6b20', // orange
//   },
//   {
//     id: 2,
//     description: 'Rezerv??cia',
//     isComplete: false,
//     dates: {
//       start: '2021-03-01',
//       end: '2021-03-02'
//     },
//     color: '#dd6b20', // orange
//   }
// ];
export default {
  components: {
    DatePicker2
  },
  data: function() {
    return {
      avatarImageUrl: null,
      disabledDates: [],
      last_index: "",
      test: [],
      newEvent: {
        // event_id: "",
        event_name: "",
        start_date: "",
        end_date: "",
        // color: "",
        username: "",
      },
      user: localStorage.getItem("username"),
      //
      myloadingvariable: true,
      // DatePicker2
      range: {
        start: '',
        end: '',
      },
      // todos,
      incId: '',
      editId: 0,
      // disabledDates: ['2021-02-26', '2021-02-27', '2021-02-28', '2021-03-01', '2021-03-02'],
      timezone: '',
      testtt: true,

      modelConfig: {
        type: 'string',
        mask: 'iso',
        timeAdjust: 'now',
      },
    }
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
        ...this.test.map(todo => ({
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
          // highlight: {
          //   fillMode: 'solid',
          //   // backgroundColor: color,
          //   // opacity: todo.isComplete ? 0.3 : 1,
          // },
          contentHoverStyle: {
            backgroundColor: 'rgba(0, 0, 0, 0.1)',
            cursor: 'pointer',
          },
          popover: {
            slot: 'add-todo',
            label: todo.event_name + ' - pou????vate?? ' + todo.username,
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
    window.Echo.join('reservation.' + localStorage.getItem("user_id"))
      .listen('Reservations', (e) => {
        console.log("calendar echo");
        if (this.$route.fullPath == '/reservation') {
          if (e.status == 'deleted') {
            this.test.map((d, i) => {
              if (d.id == e.reservation[0].id) {
                this.test.splice(i, 1)
              }
            })

            var day1 = moment(e.reservation[0].end_date);
            var day2 = moment(e.reservation[0].start_date);
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
              for (var i = 0; i < this.disabledDates.length; i++) {
                if (this.disabledDates[i] == allDates[a]) {
                  this.disabledDates.splice(i, 1)
                }
              }
            }

            this.$store.dispatch('pendingReservation', {
              count: 0
            });

          } else {
            if (e.reservation[0].event_name == 'rezervovan??') {
              this.$store.dispatch('pendingReservation', {
                count: 0
              });
            } else {
              this.$store.dispatch('pendingReservation', {
                count: 1
              });
            }

            this.test.map((d, i) => {
              if (d.id == e.reservation[0].id) {
                this.test[i].event_name = e.reservation[0].event_name;
              }
            })
          }
        }
      })
  },

  methods: {
    color(e) {
      if (e == 'rezerv??cia') {
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
    toggleTodoComplete(todo) {
      todo.isComplete = !todo.isComplete;
    },
    toggleTodoEdit(todo) {
      this.editId = (this.editId === todo.id) ? 0 : todo.id;
    },
    deleteTodo(todo) {
      this.test = this.test.filter(t => t !== todo);
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
          this.myloadingvariable = false;
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
            });
          }
          // get data
          this.test = res.data;
          // this.incId = this.test.length;
          if (res.data != undefined) {
            this.incId = res.data[res.data.length - 1].id;
          }
        })
        .catch(() => {});
    },
  },

  updated() {
    //do something after updating vue instance
    if (this.range.start != '' && this.range.end != '') {
      const arrayDate = [];
      arrayDate.push(moment(this.range.start)
        .format('YYYY-MM-DDTHH:mm:ss'), moment(this.range.end)
        .format('YYYY-MM-DDTHH:mm:ss'))
      this.$emit('array-dates', arrayDate);
      this.newEvent = {
        // event_id: "",
        event_name: "rezerv??cia",
        start_date: moment(this.range.start)
          .format('YYYY-MM-DDTHH:mm:ss'),
        end_date: moment(this.range.end)
          .add(23, 'hours')
          .add(59, 'minutes')
          .format('YYYY-MM-DDTHH:mm:ss'),
        // color: "orange",
        username: this.user,
      };
      this.$store.dispatch('reservationData', {
        event_name: "rezerv??cia",
        start_date: moment(this.range.start)
          .format('YYYY-MM-DD'),
        end_date: moment(this.range.end)
          .add(23, 'hours')
          .add(59, 'minutes')
          .format('YYYY-MM-DD'),
        start_time: moment(this.range.start)
          .format('HH:mm:ss'),
        end_time: moment(this.range.end)
          .format('HH:mm:ss'),
        // color: "orange",
        username: this.user,
      });
      this.$store.dispatch('successReservation', {
        success: true
      });
    } else {
      this.$store.dispatch('successReservation', {
        success: false
      });
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

  addTodo(day) {
    this.editId = ++this.incId;
    this.test.push({
      id: this.editId,
      description: 'New todo',
      isComplete: false,
      dates: day.date,
    });
  },

  directives: {
    focusSelect: {
      inserted(el) {
        el.focus();
        el.select();
      }
    }
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

.testtt {
  background-color: rgba(0,0,0,0,5);
}

.vc-time-picker {
  text-align: center;
}

.theme--dark .vc-time-picker.vc-bordered {
    border-color: rgba(255, 255, 255, 0.12) !important;
    margin-left: 8px;
    margin-right: 8px;
}

.theme--light .vc-time-picker.vc-bordered {
    border-color: rgba(0, 0, 0, 0.12) !important;
    margin-left: 8px;
    margin-right: 8px;
  }
</style>
