<template>
<div class="ceny">
  <v-overlay :value="overlay">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>
  <v-container>
    <v-row class="m-0">
      <v-col class="p-0 pr-lg-2 pr-md-2" cols="12" lg="6" md="6">
        <v-card flat>
          <!-- <v-alert class="" v-model="alert" dismissible color="success" border="left" elevation="1" prominent colored-border icon="mdi-check-circle" transition="fade-transition">
          Ceny boli <strong>úspešne</strong> zmenené.
        </v-alert> -->
          <v-snackbar v-model="snackbarSuccess" :multi-line="multiLine" color="success" bottom left class="m-3">
            <v-icon>mdi-check-circle</v-icon>
            {{ text }}
            <template v-slot:action="{ attrs }">
              <v-btn color="white" fab text small v-bind="attrs" @click="snackbarSuccess = false">
                <v-icon>mdi-close-circle</v-icon>
              </v-btn>
            </template>
          </v-snackbar>

          <v-row justify="space-around" class="m-0">
            <v-col cols="12">
              <v-sheet elevation="0">
                <v-chip-group v-model="pricesFor" multiple active-class="primary--text">
                  <v-chip v-for="tag in tags" :key="tag" filter class="m-auto">
                    {{ tag }}
                  </v-chip>
                </v-chip-group>
              </v-sheet>
            </v-col>
          </v-row>

          <v-divider class="mt-0"></v-divider>

          <v-container class="py-0">
            <v-row>
              <v-col v-for="(selection, i) in selections" :key="selection.text" class="shrink">
                <v-chip :disabled="loading" close @click:close="selected.splice(i, 1)">
                  <v-avatar class="primary white--text" left v-text="selection.text.slice(0, 1).toUpperCase()"></v-avatar>
                  {{ selection.text }}
                </v-chip>
              </v-col>

              <v-col v-if="!allSelected" cols="12">
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" hide-details filled clearable dense @click:clear="callItBack()" :disabled="!pricesFor.length"></v-text-field>
              </v-col>
            </v-row>
          </v-container>

          <v-divider v-if="!allSelected"></v-divider>

          <v-list>
            <v-row class="m-0">
              <v-col>
                <template v-for="item in categories">
                  <v-list-item v-if="!selected.includes(item) && item.id <= 6" :key="item.text" :disabled="loading || !pricesFor.length" @click="selected.push(item)">
                    <v-list-item-title v-text="item.text"></v-list-item-title>
                  </v-list-item>
                </template>
              </v-col>
              <v-col>
                <template v-for="item in categories">
                  <v-list-item v-if="!selected.includes(item) && item.id > 6" :key="item.text" :disabled="loading || !pricesFor.length" @click="selected.push(item)">
                    <!-- <v-list-item-avatar>
                    <v-icon :disabled="loading" v-text="item.icon"></v-icon>
                  </v-list-item-avatar> -->
                    <v-list-item-title v-text="item.text"></v-list-item-title>
                  </v-list-item>
                </template>
              </v-col>
            </v-row>

          </v-list>

          <v-divider></v-divider>

          <v-slider class="ml-3 mr-3" v-model="price" :color="color" track-color="grey" thumb-label="always" min="0" max="200" :disabled="!selected.length">
            <template v-slot:prepend>
              <v-icon :color="color" @click="decrement" :disabled="!selected.length">
                mdi-minus
              </v-icon>
            </template>

            <template v-slot:append>
              <v-icon :color="color" @click="increment" :disabled="!selected.length">
                mdi-plus
              </v-icon>
            </template>
          </v-slider>

          <v-divider class="mt-0 mb-0"></v-divider>

          <v-card-actions class="pl-3 pr-3">
            <v-btn :disabled="!selected.length" :loading="loading" :color="color" @click="next" outlined block>
              Aktualizovať
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col class="p-0 pl-lg-2 pl-md-2 pt-3 pt-lg-0 pl-md-0" cols="12" lg="6" md="6">
        <v-card flat>
          <div id="chart">
            <apexchart type="line" height="350" ref="dashedChart" :options="chartOptionsDashed" :series="seriesDashed"></apexchart>
          </div>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              <span>Ceny </span><span class="font-weight-bold">pre jednotlivé kategórie </span><span>za každý mesiac</span>
            </div>
            <v-divider class="my-2"></v-divider>
            <v-icon class="mr-2" small>
              mdi-clock
            </v-icon>
            <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
            <span class="font-weight-bold">{{lastUpdate}}</span>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import VueApexCharts from 'vue-apexcharts';

export default {
  name: "Ceny",
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      overlay: false,
      lastUpdate: '',
      items: [{
          id: 1,
          text: 'Január',
          ref: 'jan',
        },
        {
          id: 2,
          text: 'Február',
          ref: 'feb',
        },
        {
          id: 3,
          text: 'Marec',
          ref: 'mar',
        },
        {
          id: 4,
          text: 'Apríl',
          ref: 'apr',
        },
        {
          id: 5,
          text: 'Máj',
          ref: 'may',
        },
        {
          id: 6,
          text: 'Jún',
          ref: 'jun',
        },
        {
          id: 7,
          text: 'Júl',
          ref: 'jul',
        },
        {
          id: 8,
          text: 'August',
          ref: 'aug',
        },
        {
          id: 9,
          text: 'September',
          ref: 'sep',
        },
        {
          id: 10,
          text: 'Október',
          ref: 'oct',
        },
        {
          id: 11,
          text: 'November',
          ref: 'nov',
        },
        {
          id: 12,
          text: 'December',
          ref: 'dec',
        },
      ],
      loading: false,
      search: '',
      selected: [],

      price: 0,
      disabledSLider: true,

      snackbarSuccess: false,
      alert: false,
      text: '',
      multiLine: true,
      pricesFor: [0],
      tags: [
        'Dospelí',
        'Deti od 2 do 12 rokov',
        'Deti do 2 rokov',
        'Upratovanie',
      ],
      tagsEn: [
        'adults',
        'child_from_2_to_12',
        'child_from_2_to_12',
        'cleaningFee',
      ],

      //dashed chart for Prices
      seriesDashed: [{
          name: "Dospelí:",
          data: []
        },
        {
          name: "Deti od 2 do 12 rokov:",
          data: []
        },
        {
          name: 'Deti do 2 rokov:',
          data: []
        },
        {
          name: 'Poplatok za upratovanie:',
          data: []
        }
      ],
      chartOptionsDashed: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          height: 350,
          type: 'area',
          zoom: {
            enabled: false
          },
          toolbar: {
            tools: {
              download: false,
            },
          },
          animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
              speed: 1000
            }
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: [5, 7, 5, 7],
          curve: 'straight',
          dashArray: [0, 8, 5, 3],
          colors: ["#ff0000", "#ff6600", "#0066ff", "#99cc00"],
        },
        colors: ["#ff0000", "#ff6600", "#0066ff", "#99cc00"],
        legend: {
          tooltipHoverFormatter: function(val, opts) {
            return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
          }
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Máj', 'Jún', 'Júl', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
          tooltip: {
            enabled: false,
          },
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),

          y: [{
              title: {
                formatter: function(val) {
                  return val + ""
                }
              }
            },
            {
              title: {
                formatter: function(val) {
                  return val + ""
                }
              }
            },
            {
              title: {
                formatter: function(val) {
                  return val;
                }
              }
            },
            {
              title: {
                formatter: function(val) {
                  return val;
                }
              }
            }
          ]
        },
        grid: {
          borderColor: '#f1f1f1',
        }
      },
    }
  },

  mounted() {
    this.getDataDashed();
  },

  computed: {
    whenDisabled() {
      return (
        this.loading || !this.pricesFor.length
      )
    },

    allSelected() {
      return this.selected.length === this.items.length
    },
    categories() {
      const search = this.search.toLowerCase()

      if (!search && this.search != null) return this.items

      return this.items.filter(item => {
        const text = item.text.toLowerCase()

        return text.indexOf(search) > -1
      })
    },
    selections() {
      const selections = []

      for (const selection of this.selected) {
        selections.push(selection)
      }

      return selections
    },

    color() {
      if (this.price < 100) return 'indigo'
      if (this.price < 125) return 'teal'
      if (this.price < 140) return 'green'
      if (this.price < 175) return 'orange'
      return 'red'
    },
  },

  watch: {
    selected() {
      this.search = '';
    },
  },

  methods: {
    callItBack() {
      this.search = '';
    },

    next() {
      this.overlay = true;
      const array = [];
      for (var i = 0; i < this.selected.length; i++) {
        array.push(this.selected[i].ref);
      }
      const array2 = [];
      for (var x = 0; x < this.pricesFor.length; x++) {
        array2.push(this.tagsEn[this.pricesFor[x]]);
      }
      axios.post(`${process.env.VUE_APP_API_URL}/prices/updatePricesForEachMonth`, {
          selected: array,
          price: this.price,
          pricesFor: array2
        })
        .then(() => {
          this.overlay = false;
          // this.loading = false
          this.text = 'Ceny boli úspešne zmenené.';
          this.snackbarSuccess = true;
          this.search = '';
          this.selected = [];
          this.getDataDashed();
        })
    },

    decrement() {
      this.price--
    },

    increment() {
      this.price++
    },

    getDataDashed() {
      this.overlay = true;
      axios.get(`${process.env.VUE_APP_API_URL}/prices/getPricesForGraph`)
        .then(res => {
          if (res.data[0].created_at != null) {
            this.lastUpdate = moment(res.data[0].created_at.created_at)
              .format('YYYY-MM-DD HH:mm:ss');
            localStorage.setItem("lastUpdate", moment(res.data[0].created_at.created_at)
              .format('YYYY-MM-DD HH:mm:ss'));
            this.seriesDashed[0].data.splice(0, 12);
            this.seriesDashed[1].data.splice(0, 12);
            this.seriesDashed[2].data.splice(0, 12);
            this.seriesDashed[3].data.splice(0, 12);
            for (var i = 0; i < 12; i++) {
              if (res.data[0].adults.length != 0) {
                this.seriesDashed[0].data.push(res.data[0].adults[i].price);
              }
              if (res.data[0].child_from_2_to_12.length != 0) {
                this.seriesDashed[1].data.push(res.data[0].child_from_2_to_12[i].price);
              }
              if (res.data[0].child_to_2.length != 0) {
                this.seriesDashed[2].data.push(res.data[0].child_to_2[i].price);
              }
              if (res.data[0].cleaningFee.length != 0) {
                this.seriesDashed[3].data.push(res.data[0].cleaningFee[i].price);
              }
            }

            this.seriesDashed = [{
                name: "Dospelí:",
                data: this.seriesDashed[0].data
              },
              {
                name: "Deti od 2 do 12 rokov:",
                data: this.seriesDashed[1].data
              },
              {
                name: 'Deti do 2 rokov:',
                data: this.seriesDashed[2].data
              },
              {
                name: 'Poplatok za upratovanie:',
                data: this.seriesDashed[3].data
              }
            ];
          }
          this.overlay = false;
        })
    },
  },

  updated() {}
}
</script>
<style lang="scss">
</style>
