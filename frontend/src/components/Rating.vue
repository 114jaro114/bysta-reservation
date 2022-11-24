<template>
<div>
  <div class="rates">
    <v-row no-gutters>
      <v-col cols="12" xl="4" lg="5" md="6" sm="12" xs="12">
        <v-container>
          <!--overall rating-->
          <v-row no-gutters>
            <v-col cols="12" md="12">
              <h5 class="font-weight-bold"><b :style="{color: $vuetify.theme.themes[isDark].primary}">{{this.totalValueOfRate}}</b> na základe {{this.totalRates}} recenzií</h5>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col cols="12" md="12" @click="cardHide = !cardHide">
              <v-rating v-model="this.totalValueOfRate" color="primary" readonly size="50"></v-rating>
            </v-col>
          </v-row>
          <v-spacer></v-spacer>
          <v-divider horizontal></v-divider>
          <!--your rating -->
          <v-row no-gutters>
            <v-col cols="12" md="12">
              <h6 class="font-weight-bold">Tvoje hodnotenie</h6>
            </v-col>
          </v-row>
          <v-row no-gutters @click="cardHide2 = !cardHide2">
            <v-col cols="12" md="12">
              <v-rating v-model="newEvent2.rate" color="primary" readonly size="30"></v-rating>
            </v-col>
          </v-row>
        </v-container>
      </v-col>
      <v-col xl="8" lg="7" md="6" sm="12" xs="12">
        <v-container>
          <v-row no-gutters>
            <v-col cols="1" md="1" class="m-auto">
              <span class="ratingNumber">5</span>
              <v-rating :value="1" :length="1" color="primary" readonly small></v-rating>
            </v-col>
            <v-col cols="10" md="10" class="m-auto">
              <div class="bar-container">
                <div class="bar-4" :style="{ width: this.widthFiveStar + '%', background: $vuetify.theme.themes[isDark].primary }"></div>
              </div>
            </v-col>
            <v-col cols="1" md="1" class="m-auto">
              <div class="font-weight-bold text-lowercase">{{this.countFiveStar}}x</div>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col cols="1" md="1" class="m-auto">
              <span class="ratingNumber">4</span>
              <v-rating :value="1" :length="1" color="primary" readonly small></v-rating>
            </v-col>
            <v-col cols="10" md="10" class="m-auto">
              <div class="bar-container">
                <div class="bar-4" :style="{ width: this.widthFourStar + '%', background: $vuetify.theme.themes[isDark].primary }"></div>
              </div>
            </v-col>
            <v-col cols="1" md="1" class="m-auto">
              <div class="font-weight-bold text-lowercase">{{this.countFourStar}}x</div>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col cols="1" md="1" class="m-auto">
              <span class="ratingNumber">3</span>
              <v-rating :value="1" :length="1" color="primary" readonly small></v-rating>
            </v-col>
            <v-col cols="10" md="10" class="m-auto">
              <div class="bar-container">
                <div class="bar-4" :style="{ width: this.widthThreeStar + '%', background: $vuetify.theme.themes[isDark].primary }"></div>
              </div>
            </v-col>
            <v-col cols="1" md="1" class="m-auto">
              <div class="font-weight-bold text-lowercase">{{this.countThreeStar}}x</div>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col cols="1" md="1" class="m-auto">
              <span class="ratingNumber">2</span>
              <v-rating :value="1" :length="1" color="primary" readonly small></v-rating>
            </v-col>
            <v-col cols="10" md="10" class="m-auto">
              <div class="bar-container">
                <div class="bar-4" :style="{ width: this.widthTwoStar + '%', background: $vuetify.theme.themes[isDark].primary }"></div>
              </div>
            </v-col>
            <v-col cols="1" md="1" class="m-auto">
              <div class="font-weight-bold text-lowercase">{{this.countTwoStar}}x</div>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col cols="1" md="1" class="m-auto">
              <span class="ratingNumber">1</span>
              <v-rating :value="1" :length="1" color="primary" readonly small></v-rating>
            </v-col>
            <v-col cols="10" md="10" class="m-auto">
              <div class="bar-container">
                <div class="bar-4" :style="{ width: this.widthOneStar + '%', background: $vuetify.theme.themes[isDark].primary }"></div>
              </div>
            </v-col>
            <v-col cols="1" md="1" class="m-auto">
              <div class="font-weight-bold text-lowercase">{{this.countOneStar}}x</div>
            </v-col>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
    <!--show all ratings-->
    <div class="col" v-if="!cardHide">
      <v-lazy :options="{
          threshold: .2
        }" min-height="200" transition="scale-transition">
        <v-card elevation="2" class="mt-3">
          <v-toolbar class="rounded-top" color="primary" flat dark>
            <span>Hodnotenia</span>
            <v-spacer></v-spacer>
            <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" hide-details clearable filled dense></v-text-field>
            <v-spacer></v-spacer>
            <v-icon v-on:click="cardHide = !cardHide">mdi-close</v-icon>
          </v-toolbar>

          <v-data-table no-data-text="Nenašli sa žiadne hodnotenia" no-results-text="Nenašli sa žiadne hodnotenia" :headers="headers" :items="items" :search="search" :footer-props="footerProps" item-key="name" class="elevation-0"
            :loading="myloadingvariable" loading-text="Načítavanie... Prosím počkajte"></v-data-table>
        </v-card>
      </v-lazy>
    </div>
    <!--change rating-->
    <div class="col" v-if="!cardHide2">
      <div v-if="this.$store.getters['ratingState']">
        <v-card elevation="0">
          <v-toolbar class="rounded-top" color="primary" flat dark justify="center">
            <v-spacer />
            <v-toolbar-title>
              Pridať hodnotenie
            </v-toolbar-title>
            <v-spacer />
          </v-toolbar>
          <form @submit.prevent class="mt-3">
            <v-rating v-model="newEvent.rate" background-color="grey lighten-2" color="primary" size="50"></v-rating>
            <div class="p-3">
              <v-textarea :rules="rules" v-model="newEvent.comment" label="Komentár" rows="1" auto-grow prepend-icon="mdi-comment" counter="50" clearable filled clear-icon="mdi-close"></v-textarea>
              <v-btn class="mt-2" color="primary" @click="addNewEvent" dark block> Pridať hodnotenie </v-btn>
            </div>
          </form>
        </v-card>
      </div>
      <div v-else>
        <v-lazy :options="{
            threshold: .2
          }" min-height="200" transition="scale-transition">
          <v-card elevation="2" class="mt-3">
            <v-toolbar class="rounded-top" color="primary" flat dark>
              <span>Zmeniť hodnotenie</span>
              <v-spacer></v-spacer>
              <v-icon v-on:click="cardHide2 = !cardHide2">mdi-close</v-icon>
            </v-toolbar>

            <form @submit.prevent class="p-3">
              <v-rating class="mb-4" v-model="newEvent2.rate" background-color="grey lighten-2" color="primary" large></v-rating>
              <v-textarea class="mx-2" :rules="rules" v-model="newEvent2.comment" label="Komentár" rows="1" prepend-icon="mdi-comment" auto-grow counter filled clearable clear-icon="mdi-close"></v-textarea>
              <v-btn class="mt-2" color="primary" @click="updateEvent" dark block> Odoslať zmenu </v-btn>
            </form>
          </v-card>
        </v-lazy>
      </div>
    </div>

    <v-snackbar v-model="snackbarUpdateReview" :multi-line="multiLine" color="success" bottom left class="m-3">
      <v-icon>mdi-check-circle</v-icon>
      {{ textUpdateReview }}
      <template v-slot:action="{ attrs }">
        <v-btn color="white" text v-bind="attrs" @click="snackbarUpdateReview = false">
          Zrušiť
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</div>
</template>
<script>
import axios from 'axios';
export default {
  // props: ['user'],
  data: function() {
    return {
      cardHide: true,
      cardHide2: true,
      myloadingvariable: true,
      rules: [
        v => (v && v.length <= 50) || 'Maximálna dĺžka je 50 znakov'
      ],
      footerProps: {
        itemsPerPageText: 'Počet riadkov',
        itemsPerPageOptions: [5, 10, 15, -1],
      },
      search: '',
      headers: [{
        text: 'ID',
        align: 'start',
        filterable: false,
        sortable: false,
        value: 'Id',
      }, {
        text: 'Meno',
        value: 'Meno'
      }, {
        text: 'Hodnotenie',
        value: 'Hodnotenie'
      }, {
        text: 'Koment',
        value: 'Koment',
        sortable: false,
      }],
      items: [],
      // tu konci
      newEvent: {
        name: "",
        rate: 0,
        comment: "",
      },
      user: localStorage.getItem("username"),
      newEvent2: {
        name: null,
        rate: null,
        comment: null
      },
      // seen: true,
      totalValueOfRate: null,
      totalRates: null,
      totalValue: null,
      percentage: null,
      countFiveStar: 0,
      countFourStar: 0,
      countThreeStar: 0,
      countTwoStar: 0,
      countOneStar: 0,
      widthFiveStar: 0,
      widthFourStar: 0,
      widthThreeStar: 0,
      widthTwoStar: 0,
      widthOneStar: 0,
      idToUpdate: null,
      rateForUpdate: null,
      commentForUpdate: null,
      snackbarUpdateReview: false,
      multiLine: true,
      textUpdateReview: '',
    }
  },
  computed: {
    rows() {
      return this.items.length
    },
    isDark() {
      return (this.$vuetify.theme.dark) ? 'dark' : 'light'
    }
  },
  mounted: function mounted() {
    this.getEvents();
  },
  methods: {
    addNewEvent() {
      this.newEvent.name = this.user;
      axios.post(`${process.env.VUE_APP_API_URL}/rating/store`, {
          ...this.newEvent
        })
        .then(() => {
          this.resetEvents();
          this.getEvents();
        })
        .catch(err => console.log("nepodarilo sa pridat event", err));
    },
    updateEvent() {
      for (var i = 0; i < this.items.length; i++) {
        if (this.user == this.items[i].Meno) {
          this.idToUpdate = this.items[i].Id;
          this.rateForUpdate = this.items[i].Hodnotenie;
          this.commentForUpdate = this.items[i].Koment;
        }
      }
      this.newEvent2.id = this.idToUpdate;
      this.newEvent2.name = this.user;
      if (this.newEvent2.Hodnotenie == "") {
        this.newEvent2.Hodnotenie = this.rateForUpdate;
      }
      if (this.newEvent2.Koment == "") {
        this.newEvent2.Koment = this.commentForUpdate;
      }
      axios.post(`${process.env.VUE_APP_API_URL}/rating/update`, {
          ...this.newEvent2
        })
        .then(() => {
          this.getEvents();
          this.snackbarUpdateReview = true;
          this.textUpdateReview = "Vaša recenzia bola aktualizovaná"
        })
        .catch(err => console.log("Unable to update event!", err));
    },
    resetEvents() {
      this.totalValue = 0;
      this.countFiveStar = 0;
      this.countFourStar = 0;
      this.countThreeStar = 0;
      this.countTwoStar = 0;
      this.countOneStar = 0;
      this.One = 0;
      this.Two = 0;
      this.Three = 0;
      this.Four = 0;
      this.Five = 0;
      this.One2 = 0;
      this.Two2 = 0;
      this.Three2 = 0;
      this.Four2 = 0;
      this.Five2 = 0;
    },
    getEvents() {
      axios.get(`${process.env.VUE_APP_API_URL}/rating`)
        .then(resp => {
          this.resetEvents();
          this.items = resp.data.data;
          this.totalRates = resp.data.data.length;
          for (var i = 0; i < this.totalRates; i++) {
            if (this.user == resp.data.data[i].Meno) {
              // this.seen = false;
              this.$store.dispatch('ratingState', {
                state: false
              });
              //vyplnenie poli rate a comment na zaklade udajov z db
              this.newEvent2 = {
                name: resp.data.data[i].Meno,
                rate: parseInt(resp.data.data[i].Hodnotenie),
                comment: resp.data.data[i].Koment
              }
            }
            this.totalValue += resp.data.data[i].Hodnotenie / this.totalRates;
            if (resp.data.data[i].Hodnotenie == "5") {
              this.countFiveStar++;
            } else if (resp.data.data[i].Hodnotenie == "4") {
              this.countFourStar++;
            } else if (resp.data.data[i].Hodnotenie == "3") {
              this.countThreeStar++;
            } else if (resp.data.data[i].Hodnotenie == "2") {
              this.countTwoStar++;
            } else if (resp.data.data[i].Hodnotenie == "1") {
              this.countOneStar++;
            }
          }
          this.totalValueOfRate = Number((this.totalValue)
            .toFixed(2));
          this.percentage = 100 / this.totalRates;
          this.widthFiveStar = Number((this.percentage * this.countFiveStar)
            .toFixed(1));
          this.widthFourStar = Number((this.percentage * this.countFourStar)
            .toFixed(1));
          this.widthThreeStar = Number((this.percentage * this.countThreeStar)
            .toFixed(1));
          this.widthTwoStar = Number((this.percentage * this.countTwoStar)
            .toFixed(1));
          this.widthOneStar = Number((this.percentage * this.countOneStar)
            .toFixed(1));
          // this.decimal = (this.totalValueOfRate % 1) * 100; //this is .number
          // this.integer = Math.floor(this.totalValueOfRate);
          this.myloadingvariable = false;
        })
        .catch(err => console.log(err));
    },
  },
  updated() {
    //do something after updating vue instance
    // console.log(this.$store.getters['ratingState']);
  }
}
</script>
<style>
.ratingNumber {
  position: absolute;
  left: 6%;
  font-weight: bold;
  height: 100%;
  display: inline-flex;
  align-items: center;
}
</style>
