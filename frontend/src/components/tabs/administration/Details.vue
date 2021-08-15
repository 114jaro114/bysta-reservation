<template>
<div class="details w-100 h-100">
  <!-- <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition"> -->
  <v-overlay :value="overlay">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>
  <v-row justify="center" class="ml-0 mr-0">
    <!-- circle chart -->
    <v-col cols="12" lg="6" md="6" sm="12">
      <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateCircle">
        <div class="pt-3" id="chart">
          <apexchart type="radialBar" height="365" :options="chartOptionsCircle" :series="seriesCircle"></apexchart>
        </div>

        <v-card-text class="pt-0">
          <div class="title font-weight-light mb-2">
            Aktuálna cena osoba/noc
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
      <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateLine">
        <div class="pt-3" id="chart">
          <apexchart type="line" height="350" :options="chartOptionsLine" :series="seriesLine"></apexchart>
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

    <v-col cols="12" lg="6" md="12" sm="12">
      <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateCircle_multiple">
        <div class="pt-3" id="chart">
          <apexchart type="radialBar" height="365" ref="circleMultipleChart" :options="chartOptionsCircle_multiple" :series="seriesCircle_multiple"></apexchart>
        </div>

        <v-card-text class="pt-0">
          <div class="title font-weight-light mb-2">
            Celkova suma za rezervácie
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
      <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateColumn">
        <div class="pt-3" id="chart">
          <apexchart type="bar" height="332" :options="chartOptionsColumn" :series="seriesColumn"></apexchart>
        </div>

        <v-card-text class="pt-0">
          <div class="title font-weight-light mb-2">
            Cena osoba/noc S DPH/BEZ DPH/DPH
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

    <!-- historical chart -->
    <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
      <v-card class="rounded" elevation="0" loader-height="6" :loading="loaderStateSeries">
        <div class="pt-3" id="chart">
          <div class="toolbar pt-3">
            <v-btn icon color="#0066ff" id="one_hour" @click="updateData('one_hour')" class="mr-2" :class="{active: selection==='one_hour'}">
              1H
            </v-btn>
            <v-btn icon color="#0066ff" id="one_day" @click="updateData('one_day')" class="mr-2" :class="{active: selection==='one_day'}">
              1D
            </v-btn>
            <v-btn icon color="#0066ff" id="one_month" @click="updateData('one_month')" class="mr-2" :class="{active: selection==='one_month'}">
              1M
            </v-btn>

            <v-btn icon color="#0066ff" id="six_months" @click="updateData('six_months')" class="mr-2" :class="{active: selection==='six_months'}">
              6M
            </v-btn>

            <v-btn icon color="#0066ff" id="one_year" @click="updateData('one_year')" class="mr-2" :class="{active: selection==='one_year'}">
              1Y
            </v-btn>

            <v-btn icon color="#0066ff" id="ytd" @click="updateData('ytd')" class="mr-2" :class="{active: selection==='ytd'}">
              YTD
            </v-btn>

            <v-btn icon color="#0066ff" id="all" @click="updateData('all')" :class="{active: selection==='all'}">
              ALL
            </v-btn>
          </div>

          <div id="chart-timeline">
            <apexchart type="area" height="350" ref="historicalChart" :options="chartOptions" :series="series"></apexchart>
          </div>
        </div>

        <v-card-text class="pt-0">
          <div class="title font-weight-light mb-2">
            Historický graf vývoja ceny
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
  <!-- </v-lazy> -->
</div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import moment from 'moment'
export default {
  name: "Details",
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      overlay: true,
      loaderStateCircle: true,
      loaderStateLine: true,
      loaderStateCircle_multiple: true,
      loaderStateColumn: true,
      loaderStateSeries: true,
      seriesCircle: [15],
      chartOptionsCircle: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          // height: 350,
          type: 'radialBar',
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 225,
            offsetY: 31,
            hollow: {
              margin: 0,
              size: '70%',
              background: 'rgba(255,255,255, 0)',
              image: undefined,
              imageOffsetX: 0,
              imageOffsetY: 0,
              position: 'front'
            },
            dataLabels: {
              show: true,
              name: {
                offsetY: -10,
                show: true,
                color: '#888',
                fontSize: '17px'
              },
              value: {
                formatter: function(val) {
                  return parseInt(val * 100) / 100;
                },
                color: '#0066ff',
                fontSize: '36px',
                show: true,
              }
            }
          }
        },
        grid: {
          padding: {
            top: -31,
            bottom: 21
          },
        },
        stroke: {
          lineCap: 'round'
        },
        labels: ['€'],
        colors: ['#0066ff'],
      },
      // circle multiple chart
      seriesCircle_multiple: [2650, 2200, 450],
      chartOptionsCircle_multiple: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          // height: 365,
          type: 'radialBar',
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
        grid: {
          padding: {
            top: -32,
            bottom: -20
          },
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
                formatter: function(val) {
                  return val
                },
              },
              hollow: {
                size: '70%',
              }
              // total: {
              //   show: true,
              //   label: 'Priemerná cena',
              //   formatter: function() {
              //     // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
              //     return this.seriesCircle_multiple
              //   }
              // }
            },
            // track: {
            //   show: false,
            // },
            startAngle: 0,
            endAngle: 360,
            offsetY: 32,
          }
        },
        stroke: {
          lineCap: 'round'
        },
        legend: {
          show: true,
          floating: false,
          position: 'bottom',
          horizontalAlign: 'center',
          formatter: function(seriesName, opts) {
            return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
          },
        },
        colors: ['#00b300', '#ff6600', '#ff0000'],
        labels: ['Celková suma', 'Celková suma bez dph', 'DPH zo sumy'],
      },

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
          type: 'line',
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
        name: 'Suma s DPH',
        data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 3, 7, 25]
      }, {
        name: 'Suma bez DPH',
        data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 15, 65, 24]
      }, {
        name: 'DPH',
        data: [35, 41, 36, 26, 45, 48, 52, 53, 41, 1, 8, 47]
      }],
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
          width: 2,
          colors: ['transparent']
        },
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
      //area historical
      series: [{
        name: 'cena (€)',
        data: []
      }],
      chartOptions: {
        chart: {
          foreColor: localStorage.getItem('graph_text_color'),
          id: 'area-datetime',
          type: 'area',
          height: 350,
          zoom: {
            autoScaleYaxis: true
          },
          dynamicAnimation: {
            speed: 1000
          },
          toolbar: {
            tools: {
              download: false,
            }
          }
        },

        dataLabels: {
          enabled: false
        },

        markers: {
          size: 0,
          style: 'hollow',
        },

        xaxis: {
          type: 'datetime',
          labels: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('HH:mm');
            },
          },
          // type: 'category',
          // labels: {
          //   formatter: function(value) {
          //     return moment(value)
          //       .format('YYYY-MM-DD HH:mm:ss');
          //   },
          //   show: true,
          // },
          tickAmount: 6,
          tooltip: {
            enabled: false,
          }
        },
        tooltip: {
          theme: localStorage.getItem('graph_theme'),
          x: {
            datetimeUTC: false,
            formatter: function(value) {
              return moment(value)
                .format('DD MMM yy HH:mm');
            },
          },
        },
        colors: ['#0066ff'],
      },
      selection: '',

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
