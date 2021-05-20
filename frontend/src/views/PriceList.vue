<template>
<div class="price_list w-100 h-100 mt-3">
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

    <v-tabs-items v-model="tab" class="p-3 pt-1">
      <v-tab-item v-for="item in items" :key="item" disabled>
      </v-tab-item>
      <NavigationDrawer :drawer="drawer" />

      <v-row>
        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateLine">
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
        </v-col>

        <v-col cols="12" lg="6" md="12" sm="12">
          <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateColumn">
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
        </v-col>

        <v-col cols="12" lg="12" md="12" sm="12">
          <v-card elevation="0">
            <v-card-text>
              <v-row>
                <v-col>
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
    </v-tabs-items>
  </v-card>
  <SpeedDial />
  <BottomNavigation />
  <Footer />
</div>
</template>

<script>
import Footer from "../components/Footer.vue";
import SpeedDial from "@/components/SpeedDial.vue";
import NavigationDrawer from "@/components/NavigationDrawer.vue";
import BottomNavigation from "@/components/BottomNavigation.vue";
import VueApexCharts from 'vue-apexcharts'

var _seed = 42;
Math.random = function() {
  _seed = _seed * 16807 % 2147483647;
  return (_seed - 1) / 2147483646;
};
export default {
  name: "PriceList",
  components: {
    Footer,
    SpeedDial,
    NavigationDrawer,
    BottomNavigation,
    apexchart: VueApexCharts,
  },
  props: ['drawerNew'],
  data() {
    return {
      loaderStateColumn: true,
      loaderStateLine: true,
      username: localStorage.getItem("username"),
      drawer: false,
      tab: null,
      items: ['Cenník'],
      show: false,
      //line chart
      lastUpdate: localStorage.getItem('lastUpdate'),
      seriesLine: [{
        name: "Cena za noc/osobu v €",
        data: [18, 18, 18, 16, 16, 15, 15, 15, 15, 16, 18, 18]
      }],
      chartOptionsLine: {
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
        },
        toolbar: {
          show: false
        },
        dataLabels: {
          enabled: false
        },
        grid: {
          show: true,
          strokeDashArray: 0,
          yaxis: {
            lines: {
              show: true,
            },
          },
          xaxis: {
            lines: {
              show: false,
            },
          },
        },
        stroke: {
          curve: 'smooth',
          width: 5,
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Máj', 'Jún', 'Júl', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          tooltip: {
            enabled: false,
          },
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
        },
        legend: {
          show: false
        },
        colors: ['#0066ff'],
      },
      //column chart
      seriesColumn: [{
        name: 'cena osoba/noc (€)',
        data: [18, 18, 18, 16, 16, 15, 15, 15, 15, 16, 18, 18]
      }],
      chartOptionsColumn: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          type: 'bar',
          toolbar: {
            show: false,
            tools: {
              download: false,
              selection: false,
              zoom: false,
              zoomin: false,
              zoomout: false,
              pan: false,
              reset: false | '<img src="/static/icons/reset.png" width="20">',
              //customIcons: []
            }
          }
        },
        plotOptions: {
          bar: {
            borderRadius: 10,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: false,
          formatter: function(val) {
            return val + "";
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#0066ff"]
          }
        },

        xaxis: {
          categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          position: 'top',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          tooltip: {
            enabled: false,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: true,
            formatter: function(val) {
              return val + "";
            }
          }

        },
        title: {
          //text: 'Mesačná priemerná vlhkosť',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
        },
        colors: ['#0066ff'],
      },
    }
  },
  updated() {
    this.drawer = this.drawerNew;
  },
  methods: {
    updateRouter(tab) {
      this.$router.push(tab)
    },
  }
}
</script>

<style>

</style>
