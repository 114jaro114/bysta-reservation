<template>
<div class="details w-100 h-100">
  <v-container>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-row justify="center" class="ml-0 mr-0">
      <!-- circle chart -->
      <v-col cols="12" lg="6" md="12" sm="12">
        <!-- :loading="loaderStateCircle" -->
        <v-card class="rounded" elevation="0" loader-height="6">
          <div class="pt-3" id="chart">
            <apexchart type="radialBar" height="365" ref="circleMultipleChart" :options="chartOptionsCircle_multiple" :series="seriesCircle_multiple"></apexchart>
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

      <v-col cols="12" lg="6" md="12" sm="12">
        <!-- :loading="loaderStateCircle" -->
        <v-card class="rounded" elevation="0" loader-height="6">
          <div class="pt-3" id="chart">
            <apexchart type="radialBar" height="365" :options="chartOptionsCircle" :series="seriesCircle"></apexchart>
          </div>

          <v-card-text class="pt-0">
            <div class="title font-weight-light mb-2">
              Celkové prostriedky uhradené za rezerváciu
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

      <v-col cols="12" lg="6" md="12" sm="12">
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

      <!-- historical chart -->
      <v-col class="mb-5" cols="12" lg="12" md="12" sm="12">
        <!-- :loading="loaderStateSeries" -->
        <v-card class="rounded" elevation="0" loader-height="6">
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
  </v-container>
</div>
</template>

<script>
import axios from 'axios';
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
      lastUpdate: localStorage.getItem('lastUpdate'),

      seriesCircle: [],
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
      seriesCircle_multiple: [],
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
        colors: ['#ff0000', '#ff6600', '#0066ff', '#99cc00'],
        labels: ['Dospelí', 'Deti od 2 do 12 rokov', 'Deti do 2 rokov', 'Poplatok za upratovanie'],
      },

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
  mounted() {
    this.getDataDashed();
    this.getSeriesCircle()
  },

  methods: {
    getSeriesCircle() {
      const api = `${process.env.VUE_APP_API_URL}/prices/getValueSpentByUserForReservation`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.get(api, config)
        .then(res => {
          this.seriesCircle.splice(0, 1);
          this.seriesCircle.push(res.data)
        })
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

            this.seriesCircle_multiple.splice(0, 4);

            this.seriesDashed[0].data.splice(0, 12);
            this.seriesDashed[1].data.splice(0, 12);
            this.seriesDashed[2].data.splice(0, 12);
            this.seriesDashed[3].data.splice(0, 12);

            this.seriesColumn[0].data.splice(0, 12);
            this.seriesColumn[1].data.splice(0, 12);
            this.seriesColumn[2].data.splice(0, 12);
            this.seriesColumn[3].data.splice(0, 12);



            if (res.data[0].adults.length != 0) {
              this.seriesCircle_multiple.push(res.data[0].adults[new Date().getMonth()].price)
            } else {
              this.seriesCircle_multiple.push('0')
            }
            if (res.data[0].child_from_2_to_12.length != 0) {
              this.seriesCircle_multiple.push(res.data[0].child_from_2_to_12[new Date().getMonth()].price)
            } else {
              this.seriesCircle_multiple.push('0')
            }
            if (res.data[0].child_to_2.length != 0) {
              this.seriesCircle_multiple.push(res.data[0].child_to_2[new Date().getMonth()].price)
            } else {
              this.seriesCircle_multiple.push('0')
            }
            if (res.data[0].cleaningFee.length != 0) {
              this.seriesCircle_multiple.push(res.data[0].cleaningFee[new Date().getMonth()].price)
            } else {
              this.seriesCircle_multiple.push('0')
            }

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
  },
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
