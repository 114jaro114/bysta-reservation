<template>
<div class="price_list w-100 h-100">
  <v-container class="mt-16 mb-4">
    <v-card class="pt-3 pt-lg-5 pt-md-5" elevation="0">
      <v-card-text class="p-0 text-center">
        <v-overlay :value="overlay">
          <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>

        <v-lazy :options="{
                          threshold: .4
                        }" transition="scale-transition">
          <v-row justify="center" class="ml-0 mr-0">
            <v-col cols="12" lg="6" md="6">
              <v-card class="rounded" elevation="0">
                <div class="pt-3" id="chart">
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

            <v-col cols="12" lg="6" md="6" sm="12">
              <!-- :loading="loaderStateColumn" -->
              <v-card class="rounded" elevation="0" loader-height="6">
                <div class="pt-3" id="chart">
                  <apexchart type="bar" height="350" :options="chartOptionsColumn" :series="seriesColumn"></apexchart>
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

            <v-col cols="12" lg="12" md="12" sm="12">
              <v-card elevation="0">
                <v-card-text>
                  <v-row>
                    <v-col cols="12" lg="6" md="12" sm="12">
                      <v-sheet class="p-4 mx-auto" rounded outlined>
                        <v-row class="justify-center">
                          <span>Upratovanie</span>
                        </v-row>
                        <v-row class="justify-center">
                          <v-icon large>mdi-broom</v-icon>
                        </v-row>
                        <v-row class="justify-center">
                          <span>Poplatok +100€ k cene rezervácie</span>
                        </v-row>

                      </v-sheet>
                    </v-col>
                    <v-col cols="12" lg="6" md="12" sm="12">
                      <v-sheet class="p-4 mx-auto" rounded outlined>
                        <v-row class="justify-center">
                          <span>Rezervácia do 5 dospelích osôb</span>
                        </v-row>
                        <v-row class="justify-center">
                          <v-icon large>mdi-account-group</v-icon>
                        </v-row>
                        <v-row class="justify-center">
                          <span>Ak je počet osôb rezervácie menší ako 6, cena chaty za noc je 150€.</span>
                        </v-row>
                      </v-sheet>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-lazy>
      </v-card-text>
    </v-card>
  </v-container>
</div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import axios from 'axios';
import moment from 'moment';

var _seed = 42;
Math.random = function() {
  _seed = _seed * 16807 % 2147483647;
  return (_seed - 1) / 2147483646;
};
export default {
  name: "PriceList",
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      overlay: true,
      // loaderStateColumn: true,
      // loaderStateLine: true,
      username: localStorage.getItem("username"),
      tab: null,
      items: ['Cenník'],
      show: false,
      //line chart
      lastUpdate: localStorage.getItem('lastUpdate'),
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


      //column chart
      seriesColumn: [{
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
      chartOptionsColumn: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          type: 'bar',
          height: 350,
          toolbar: {
            tools: {
              download: false,
            },
          },
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          // width: 3,
          curve: 'straight',
          colors: ["#ff0000", "#ff6600", "#0066ff", "#99cc00"],
        },
        colors: ["#ff0000", "#ff6600", "#0066ff", "#99cc00"],
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          y: {
            formatter: function(val) {
              return val + "€"
            }
          }
        }
      },
    }
  },

  mounted() {
    this.getDataDashed();
  },

  updated() {},
  methods: {
    updateRouter(tab) {
      this.$router.push(tab)
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
            this.seriesColumn[0].data.splice(0, 12);
            this.seriesColumn[1].data.splice(0, 12);
            this.seriesColumn[2].data.splice(0, 12);
            this.seriesColumn[3].data.splice(0, 12);
            for (var i = 0; i < 12; i++) {
              if (res.data[0].adults.length != 0) {
                this.seriesDashed[0].data.push(res.data[0].adults[i].price);
                this.seriesColumn[0].data.push(res.data[0].adults[i].price);
              }
              if (res.data[0].child_from_2_to_12.length != 0) {
                this.seriesDashed[1].data.push(res.data[0].child_from_2_to_12[i].price);
                this.seriesColumn[1].data.push(res.data[0].child_from_2_to_12[i].price);
              }
              if (res.data[0].child_to_2.length != 0) {
                this.seriesDashed[2].data.push(res.data[0].child_to_2[i].price);
                this.seriesColumn[2].data.push(res.data[0].child_to_2[i].price);
              }
              if (res.data[0].cleaningFee.length != 0) {
                this.seriesDashed[3].data.push(res.data[0].cleaningFee[i].price);
                this.seriesColumn[3].data.push(res.data[0].cleaningFee[i].price);
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

            this.seriesColumn = [{
                name: "Dospelí:",
                data: this.seriesColumn[0].data
              },
              {
                name: "Deti od 2 do 12 rokov:",
                data: this.seriesColumn[1].data
              },
              {
                name: 'Deti do 2 rokov:',
                data: this.seriesColumn[2].data
              },
              {
                name: 'Poplatok za upratovanie:',
                data: this.seriesColumn[3].data
              }
            ];
          }
          this.overlay = false;
        })
    },
  }
}
</script>

<style>

</style>
