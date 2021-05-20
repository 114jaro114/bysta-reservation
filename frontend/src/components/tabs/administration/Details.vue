<template>
<div class="details w-100 h-100 mt-3">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col cols="12" lg="6" md="6" sm="12">
        <v-card class="rounded" elevation="0">
          <div class="pt-3" id="chart">
            <apexchart type="radialBar" height="350" :options="chartOptionsStroked_gauge" :series="seriesStroked_gauge"></apexchart>
          </div>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              Vlhkosť - Tlak - Teplota
            </div>
            <v-divider class="my-2"></v-divider>
            <v-icon class="mr-2" small>
              mdi-clock
            </v-icon>
            <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
            <!-- <span class="font-weight-bold">{{lastUpdate}}</span> -->
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" lg="6" md="6" sm="12">
        <v-card class="rounded" elevation="0">
          <div class="pt-3" id="chart">
            <apexchart type="line" height="298" :options="chartOptionsLine" :series="seriesLine"></apexchart>
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
            <!-- <span class="font-weight-bold">{{lastUpdate}}</span> -->
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" lg="6" md="6" sm="12">
        <v-card class="rounded" elevation="0">
          <div class="pt-3" id="chart">
            <apexchart type="radialBar" height="333" :options="chartOptionsCircle_multiple" :series="seriesCircle_multiple"></apexchart>
          </div>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              Vlhkosť - Tlak - Teplota
            </div>
            <v-divider class="my-2"></v-divider>
            <v-icon class="mr-2" small>
              mdi-clock
            </v-icon>
            <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
            <!-- <span class="font-weight-bold">{{lastUpdate}}</span> -->
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" lg="6" md="6" sm="12">
        <v-card class="rounded" elevation="0">
          <div class="pt-3" id="chart">
            <apexchart type="bar" height="298" :options="chartOptionsColumn" :series="seriesColumn"></apexchart>
          </div>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              Vlhkosť - Tlak - Teplota
            </div>
            <v-divider class="my-2"></v-divider>
            <v-icon class="mr-2" small>
              mdi-clock
            </v-icon>
            <span class="caption grey--text font-weight-light">Posledná aktualizácia: </span>
            <!-- <span class="font-weight-bold">{{lastUpdate}}</span> -->
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

var _seed = 42;
Math.random = function() {
  _seed = _seed * 16807 % 2147483647;
  return (_seed - 1) / 2147483646;
};
export default {
  name: "Details",
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      //apexchart stroked gauge
      seriesStroked_gauge: [67],
      chartOptionsStroked_gauge: {
        chart: {
          height: 350,
          type: 'radialBar',
          offsetY: -10
        },
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 135,
            dataLabels: {
              name: {
                fontSize: '16px',
                color: undefined,
                offsetY: 120
              },
              value: {
                offsetY: 76,
                fontSize: '22px',
                color: undefined,
                formatter: function(val) {
                  return val + "%";
                }
              }
            }
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            shadeIntensity: 0.15,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 65, 91]
          },
        },
        stroke: {
          dashArray: 4
        },
        labels: ['Median Ratio'],
      },
      //
      // circle multiple chart
      seriesCircle_multiple: [44, 5, 67],
      chartOptionsCircle_multiple: {
        chart: {
          height: 350,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              },
              total: {
                show: true,
                label: 'Total',
                formatter: function() {
                  // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                  return 249
                }
              }
            }
          }
        },
        labels: ['Apples', 'Oranges', 'Bananas'],
      },
      //
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
      //column chart
      seriesColumn: [{
        name: 'Net Profit',
        data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 15, 65, 24]
      }, {
        name: 'Revenue',
        data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 3, 7, 25]
      }, {
        name: 'Free Cash Flow',
        data: [35, 41, 36, 26, 45, 48, 52, 53, 41, 1, 8, 47]
      }],
      chartOptionsColumn: {
        chart: {
          type: 'bar',
          height: 350
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
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        },
        yaxis: {
          title: {
            text: '$ (thousands)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return "$ " + val + " thousands"
            }
          }
        }
      },
    }
  },

  methods: {},
  watch: {
    // model(nxt, old) {
    //   let oldIdx = old.indexOf(true)
    //   if (oldIdx >= 0) {
    //     nxt[oldIdx] = false
    //   }
    //   let activeIdx = nxt.indexOf(true)
    //   console.log("activeIdx", activeIdx)
    // },
  },
}
</script>

<style type="scss">
</style>
