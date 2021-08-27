<template>
<div class="price_list w-100 h-100">
  <v-card elevation="0">
    <v-app-bar fixed flat>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title class="position-absolute" style="right:14px">
        <span class="md-title font-weight-bold" v-if="this.$vuetify.theme.dark">
          <v-img class="ma-lg-0 ma-md-0 ma-auto" :lazy-src="require('../../public/img/logos/logo_home_theme_dark.png')" max-height="100" max-width="200" :src="require('../../public/img/logos/logo_home_theme_dark.png')"></v-img>
        </span>
        <span class="md-title font-weight-bold" v-else>
          <v-img class="ma-lg-0 ma-md-0 ma-auto" :lazy-src="require('../../public/img/logos/logo_home_theme_light.png')" max-height="100" max-width="200" :src="require('../../public/img/logos/logo_home_theme_light.png')"></v-img>
        </span>
      </v-toolbar-title>

      <template v-slot:extension>
        <v-tabs grow>
          <v-tab v-for="item in items" :key="item">
            {{ item }}
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-tabs-items class="pt-3 pt-lg-5 pt-md-5" v-model="tab" grow>
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-tab-item v-for="item in items" :key="item" disabled>
      </v-tab-item>
      <NavigationDrawer :drawer="drawer" />

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

          <v-col cols="12" lg="6" md="6" sm="12" class="pl-3 pr-3">
            <!-- :loading="loaderStateColumn" -->
            <v-card class="rounded" elevation="0" loader-height="6">
              <div class="pt-3" id="chart">
                <apexchart type="bar" height="332" :options="chartOptionsColumn" :series="seriesColumn"></apexchart>
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

          <!-- <v-col cols="12" lg="6" md="12" sm="12" class="pl-3 pr-3">
            <v-card class="rounded" elevation="0" loader-height="6">
              <div class="pt-3" id="chart">
                <apexchart type="area" height="350" :options="chartOptionsLine" :series="seriesLine"></apexchart>
              </div>

              <v-card-text class="pt-0">
                <div class="title font-weight-light mb-2">
                  Cena za noc/osoba/obdobie
                </div>
                <v-divider class="my-2"></v-divider>
                <v-icon class="mr-2" small>
                  mdi-clock
                </v-icon>
                <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
                <span class="font-weight-bold">{{lastUpdate}}</span>
              </v-card-text>
            </v-card>
          </v-col> -->

          <!-- <v-col cols="12" lg="6" md="12" sm="12" class="pl-3 pr-3">
            <v-card class="rounded" elevation="0" loader-height="6">
              <div class="pt-3" id="chart">
                <apexchart type="bar" ref="column_chart" height="350" :options="chartOptionsColumn" :series="seriesColumn"></apexchart>
              </div>

              <v-card-text class="pt-0">
                <div class="title font-weight-light mb-2">
                  Vlhkosť za jednotlivé mesiace v roku
                </div>
                <v-divider class="my-2"></v-divider>
                <v-icon class="mr-2" small>
                  mdi-clock
                </v-icon>
                <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
                <span class="font-weight-bold">{{lastUpdate}}</span>
              </v-card-text>
            </v-card>
          </v-col> -->

          <v-col cols="12" lg="12" md="12" sm="12" class="pl-3 pr-3">
            <v-card elevation="0">
              <v-card-text>
                <v-row>
                  <!-- <v-col>
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
                  </v-col> -->
                  <v-col>
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
    </v-tabs-items>
  </v-card>
</div>
</template>

<script>
import NavigationDrawer from "@/components/NavigationDrawer.vue";
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
    NavigationDrawer,
    apexchart: VueApexCharts,
  },
  props: ['drawerNew'],
  data() {
    return {
      overlay: true,
      // loaderStateColumn: true,
      // loaderStateLine: true,
      username: localStorage.getItem("username"),
      drawer: false,
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

      // seriesLine: [{
      //   name: "Cena za noc/osobu v €",
      //   data: []
      // }],
      // chartOptionsLine: {
      //   chart: {
      //     foreColor: localStorage.getItem('graph_text_color'),
      //     height: 350,
      //     type: 'area',
      //     zoom: {
      //       enabled: false
      //     },
      //     toolbar: {
      //       tools: {
      //         download: false,
      //       },
      //     },
      //     animations: {
      //       enabled: false,
      //     }
      //   },
      //   toolbar: {
      //     show: false
      //   },
      //   dataLabels: {
      //     enabled: false
      //   },
      //   grid: {
      //     show: true,
      //     strokeDashArray: 0,
      //     yaxis: {
      //       lines: {
      //         show: true,
      //       },
      //     },
      //     xaxis: {
      //       lines: {
      //         show: false,
      //       },
      //     },
      //   },
      //   stroke: {
      //     width: [5, 7, 5, 7],
      //     curve: 'straight',
      //     dashArray: [0, 8, 5, 3],
      //     colors: ["#ff0000", "#ff6600", "#0066ff", "#99cc00"],
      //   },
      //   colors: ["#ff0000", "#ff6600", "#0066ff", "#99cc00"],
      //   xaxis: {
      //     categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Máj', 'Jún', 'Júl', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      //     tooltip: {
      //       enabled: false,
      //     },
      //   },
      //   tooltip: {
      //     theme: localStorage.getItem('graph_theme'),
      //   },
      //   legend: {
      //     show: false
      //   },
      // },
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
      //column chart
      // seriesColumn: [{
      //   name: 'cena osoba/noc (€)',
      //   data: []
      // }],
      // chartOptionsColumn: {
      //   chart: {
      //     foreColor: localStorage.getItem('graph_text_color'),
      //     type: 'bar',
      //     toolbar: {
      //       show: false,
      //       tools: {
      //         download: false,
      //         selection: false,
      //         zoom: false,
      //         zoomin: false,
      //         zoomout: false,
      //         pan: false,
      //         reset: false | '<img src="/static/icons/reset.png" width="20">',
      //         //customIcons: []
      //       }
      //     },
      //     animations: {
      //       enabled: false,
      //     }
      //   },
      //   plotOptions: {
      //     bar: {
      //       borderRadius: 10,
      //       dataLabels: {
      //         position: 'top', // top, center, bottom
      //       },
      //     }
      //   },
      //   dataLabels: {
      //     enabled: false,
      //     formatter: function(val) {
      //       return val + "";
      //     },
      //     offsetY: -20,
      //     style: {
      //       fontSize: '12px',
      //       colors: ["#0066ff"]
      //     }
      //   },
      //
      //   xaxis: {
      //     categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Máj', 'Jún', 'Júl', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
      //     position: 'top',
      //     axisBorder: {
      //       show: false
      //     },
      //     axisTicks: {
      //       show: false
      //     },
      //     tooltip: {
      //       enabled: false,
      //     }
      //   },
      //   yaxis: {
      //     axisBorder: {
      //       show: false
      //     },
      //     axisTicks: {
      //       show: false,
      //     },
      //     labels: {
      //       show: true,
      //       formatter: function(val) {
      //         return val + "";
      //       }
      //     }
      //   },
      //   title: {
      //     //text: 'Mesačná priemerná vlhkosť',
      //     floating: true,
      //     offsetY: 330,
      //     align: 'center',
      //     style: {
      //       color: '#444'
      //     }
      //   },
      //   tooltip: {
      //     theme: localStorage.getItem('graph_theme'),
      //   },
      //   colors: ['#0066ff'],
      // },
    }
  },

  mounted() {
    this.getDataDashed();
    // axios.get(`${process.env.VUE_APP_API_URL}/prices/getPricesForEachMonth`)
    //   .then(res => {
    //     this.lastUpdate = moment(res.data[0].created_at.created_at)
    //       .format('YYYY-MM-DD HH:mm:ss');
    //     localStorage.setItem("lastUpdate", moment(res.data[0].created_at.created_at)
    //       .format('YYYY-MM-DD HH:mm:ss'));
    //     this.seriesLine[0].data.splice(0, 12);
    //     this.seriesLine[0].data.push(
    //       res.data[0].price[0].price, res.data[0].price[1].price,
    //       res.data[0].price[2].price, res.data[0].price[3].price,
    //       res.data[0].price[4].price, res.data[0].price[5].price,
    //       res.data[0].price[6].price, res.data[0].price[7].price,
    //       res.data[0].price[8].price, res.data[0].price[9].price,
    //       res.data[0].price[10].price, res.data[0].price[11].price,
    //     );
    //
    //     this.seriesLine = [{
    //       data: this.seriesLine[0].data
    //     }];
    //
    //     this.seriesColumn[0].data.splice(0, 12);
    //     this.seriesColumn[0].data.push(
    //       res.data[0].price[0].price, res.data[0].price[1].price,
    //       res.data[0].price[2].price, res.data[0].price[3].price,
    //       res.data[0].price[4].price, res.data[0].price[5].price,
    //       res.data[0].price[6].price, res.data[0].price[7].price,
    //       res.data[0].price[8].price, res.data[0].price[9].price,
    //       res.data[0].price[10].price, res.data[0].price[11].price,
    //     );
    //
    //     this.seriesColumn = [{
    //       data: this.seriesColumn[0].data
    //     }];
    //
    //     // this.loaderStateColumn = false;
    //     // this.loaderStateLine = false;
    //     this.overlay = false;
    //   });
  },

  updated() {
    this.drawer = this.drawerNew;
  },
  methods: {
    updateRouter(tab) {
      this.$router.push(tab)
    },

    getDataDashed() {
      this.overlay = true;
      axios.get(`${process.env.VUE_APP_API_URL}/prices/getPricesForGraph`)
        .then(res => {
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
            this.seriesDashed[0].data.push(res.data[0].adults[i].price);
            this.seriesDashed[1].data.push(res.data[0].child_from_2_to_12[i].price);
            this.seriesDashed[2].data.push(res.data[0].child_to_2[i].price);
            this.seriesDashed[3].data.push(res.data[0].cleaningFee[i].price);
            this.seriesColumn[0].data.push(res.data[0].adults[i].price);
            this.seriesColumn[1].data.push(res.data[0].child_from_2_to_12[i].price);
            this.seriesColumn[2].data.push(res.data[0].child_to_2[i].price);
            this.seriesColumn[3].data.push(res.data[0].cleaningFee[i].price);
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

          this.overlay = false;
        })
    },
  }
}
</script>

<style>

</style>
