<template>
<div class="price_list w-100 h-100 text-uppercase secondary-color">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-lazy :options="{
          threshold: .4
        }" min-height="100vh" transition-group="scale-transition">
    <v-card class="v-content">
      <v-toolbar elevation="2" class="mb-3">
        <v-app-bar-nav-icon :drawerNew="drawerNew" @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title class="position-absolute" style="right:14px">
          <span class="md-title font-weight-bold" v-if="this.$vuetify.theme.dark">
            <img class="logo2 align-middle" src="/img/logos/logo_home_theme_dark.png">
          </span>
          <span class="md-title font-weight-bold" v-else>
            <img class="logo2 align-middle" src="/img/logos/logo_home_theme_light.png">
          </span>
        </v-toolbar-title>
        <template v-slot:extension>
          <v-tabs grow>
            <v-tab v-for="item in items" :key="item">
              {{ item }}
            </v-tab>
          </v-tabs>
        </template>
      </v-toolbar>
      <v-tabs-items v-model="tab" class="p-3 pt-1">
        <v-tab-item v-for="item in items" :key="item" disabled>
        </v-tab-item>
        <NavigationDrawer :drawer="drawer" />
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" lg="12" md="12" sm="12" class="mb-5">
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-sheet class="v-sheet--offset mx-auto mt-3" color="grey lighten-5" elevation="0" max-width="calc(100% - 32px)" rounded>
                    <div id="chart">
                      <apexchart type="line" height="298" :options="chartOptionsLine" :series="seriesLine"></apexchart>
                    </div>
                  </v-sheet>

                  <v-card-text class="pt-0">
                    <div class="title font-weight-light mb-2">
                      Cena za noc/osoba/obdobie
                    </div>
                    <v-divider class="my-2"></v-divider>
                    <v-icon class="mr-2" small>
                      mdi-clock
                    </v-icon>
                    <span class="caption grey--text font-weight-light">Posledná aktualizácia pred 26 minutami</span>
                  </v-card-text>
                </v-sheet>
              </v-col>
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
      </v-tabs-items>
    </v-card>
  </v-lazy>
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
      username: localStorage.getItem("username"),
      drawer: false,
      tab: null,
      items: ['Cenník'],
      show: false,
      //line chart
      seriesLine: [{
        name: "Cena za noc/osobu v €",
        data: [18, 18, 18, 16, 16, 15, 15, 15, 15, 16, 18, 18]
      }],
      chartOptionsLine: {
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        // title: {
        //   text: 'Product Trends by Month',
        //   align: 'left'
        // },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        }
      },
      //
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
