<template>
<div class="vytvorit_rezervaciu w-100 h-100">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <div class="text-center">
        <v-snackbar v-model="snackbar" :multi-line="multiLine" color="error" :left="true">
          <v-icon>mdi-alert-circle</v-icon>
          {{ text }}

          <template v-slot:action="{ attrs }">
            <v-btn color="white" text v-bind="attrs" @click="snackbar = false">
              Close
            </v-btn>
          </template>
        </v-snackbar>
      </div>
      <v-col class="pl-0 pr-0">
        <!-- <v-lazy v-model="isActive" :options="{
          threshold: .8
        }" min-height="200" transition="fade-transition"> -->
        <v-stepper v-model="e1">
          <v-stepper-header>
            <v-stepper-step color="primary" :complete="e1 > 1" :rules="[() => step1]" step="1" error-icon="mdi-alert-circle">
              Dátum
              <small v-if="step1 == false">Chyba</small>
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step color="primary" :complete="e1 > 2" :rules="[() => step2]" step="2" error-icon="mdi-alert-circle">
              Čas príchodu a odchodu
              <small v-if="step2 == false">Chyba</small>
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step color="primary" :complete="e1 > 3" :rules="[() => step3]" step="3" error-icon="mdi-alert-circle">
              Počet osôb
              <small v-if="step3 == false">Chyba</small>
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step color="primary" :complete="e1 > 4" :rules="[() => step4]" step="4" error-icon="mdi-alert-circle">
              Kontaktné informácie
              <small v-if="step4 == false">Chyba</small>
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step color="primary" :rules="[() => step5]" step="5" error-icon="mdi-alert-circle">
              Rekapitulácia
              <small v-if="step5 == false">Chyba</small>
            </v-stepper-step>
          </v-stepper-header>

          <v-stepper-items class="h-100">
            <v-stepper-content step="1">
              <Calendar />

              <v-btn color="accent" disabled class="mr-2" outlined>
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn>

              <v-btn color="primary" @click="checkStatus()">
                Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="2">
              <v-card class="m-3" tile>
                <v-card-text>
                  <v-row justify="center" align="center">
                    <v-col style="width: 500px; flex: 0 1 auto;">
                      <h4 class="font-weight-bold">Čas príchodu:</h4>
                      <v-time-picker v-model="start_time" :landscape="$vuetify.breakpoint.smAndUp"></v-time-picker>
                    </v-col>
                    <v-col style="width: 500px; flex: 0 1 auto;">
                      <h4 class="font-weight-bold">Čas odchodu:</h4>
                      <v-time-picker v-model="end_time" :landscape="$vuetify.breakpoint.smAndUp"></v-time-picker>
                    </v-col>
                  </v-row>
                </v-card-text>
                <!-- <v-col cols="11" sm="5">
                <v-dialog ref="dialog_start_time" v-model="modal1" :return-value.sync="start_time" persistent width="290px">
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field v-model="start_time" label="Dátum začiatku" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" clearable clear-icon="mdi-close-circle"></v-text-field>
                  </template>
                  <v-time-picker v-if="modal1" v-model="start_time" full-width>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="modal1 = false">
                      Cancel
                    </v-btn>
                    <v-btn text color="primary" @click="$refs.dialog_start_time.save(start_time)">
                      OK
                    </v-btn>
                  </v-time-picker>
                </v-dialog>

                <v-dialog ref="dialog_end_time" v-model="modal2" :return-value.sync="end_time" persistent width="290px">
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field v-model="end_time" label="Dátum konca" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on" clearable clear-icon="mdi-close-circle"></v-text-field>
                  </template>
                  <v-time-picker v-if="modal2" v-model="end_time" full-width>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="modal2 = false">
                      Cancel
                    </v-btn>
                    <v-btn text color="primary" @click="$refs.dialog_end_time.save(end_time)">
                      OK
                    </v-btn>
                  </v-time-picker>
                </v-dialog>
              </v-col> -->
                <!-- <v-row justify="space-around" align="center">
                <v-col style="width: 350px; flex: 0 1 auto;">
                  <h2>Start:</h2>
                  <v-time-picker v-model="start" :max="end"></v-time-picker>
                </v-col>
                <v-col style="width: 350px; flex: 0 1 auto;">
                  <h2>End:</h2>
                  <v-time-picker v-model="end" :min="start"></v-time-picker>
                </v-col>
              </v-row> -->
              </v-card>

              <v-btn color="accent" @click="e1 = 1; backStep1()" class="mr-2" outlined>
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn>

              <v-btn color="primary" @click="checkStatus2()">
                Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
              <v-card class="m-3" tile>
                <v-card-text>
                  <v-row class="m-0">
                    <span>Dospelí</span>
                  </v-row>

                  <v-row class="ml-3 mr-3">
                    <v-btn class="mx-2" fab dark x-small color="primary" @click="decrementValue1">
                      <v-icon dark>
                        mdi-minus
                      </v-icon>
                    </v-btn>
                    <v-text-field style="width: 70px" class="counter" v-model="counter1" placeholder="" filled rounded dense></v-text-field>
                    <v-btn class="mx-2" fab dark x-small color="primary" @click="incrementValue1">
                      <v-icon dark>
                        mdi-plus
                      </v-icon>
                    </v-btn>
                    <v-btn depressed color="error" @click="resetValue1">
                      Resetovať
                    </v-btn>
                  </v-row>

                  <v-divider></v-divider>

                  <v-row class="m-0">
                    <span>Deti od 2 do 12 rokov</span>
                  </v-row>

                  <v-row class="ml-3 mr-3">
                    <v-btn class="mx-2" fab dark x-small color="primary" @click="decrementValue2">
                      <v-icon dark>
                        mdi-minus
                      </v-icon>
                    </v-btn>
                    <v-text-field style="width: 70px" v-model="counter2" placeholder="" filled rounded dense></v-text-field>
                    <v-btn class="mx-2" fab dark x-small color="primary" @click="incrementValue2">
                      <v-icon dark>
                        mdi-plus
                      </v-icon>
                    </v-btn>
                    <v-btn depressed color="error" @click="resetValue2">
                      Resetovať
                    </v-btn>
                  </v-row>

                  <v-divider></v-divider>

                  <v-row class="m-0">
                    <span>Deti do 2 rokov</span>
                  </v-row>

                  <v-row class="ml-3 mr-3">
                    <v-btn class="mx-2" fab dark x-small color="primary" @click="decrementValue3">
                      <v-icon dark>
                        mdi-minus
                      </v-icon>
                    </v-btn>
                    <v-text-field style="width: 70px" class="counter" v-model="counter3" placeholder="" filled rounded dense></v-text-field>
                    <v-btn class="mx-2" fab dark x-small color="primary" @click="incrementValue3">
                      <v-icon dark>
                        mdi-plus
                      </v-icon>
                    </v-btn>
                    <v-btn depressed color="error" @click="resetValue3">
                      Resetovať
                    </v-btn>
                  </v-row>

                  <!-- <v-divider></v-divider> -->

                </v-card-text>
              </v-card>

              <v-btn color="accent" @click="e1 = 2; backStep2()" class="mr-2" outlined>
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn>

              <v-btn color="primary" @click="checkStatus3()">
                Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="4">
              <v-card class="m-3" tile>
                <!-- <v-row justify="center">
                <v-col cols="12" sm="12" md="12" lg="6"> -->
                <v-card-text>
                  <v-row justify="center">
                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="surname" v-model="surname" :rules="surnameRules" :error-messages="errorMessages" label="Meno" clearable required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="lastname" v-model="lastname" :rules="lastnameRules" :error-messages="errorMessages" label="Priezvisko" clearable required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <v-text-field ref="address" v-model="address" :rules="addressRules" label="Adresa" counter="25" clearable required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="city" v-model="city" :rules="cityRules" label="Mesto" clearable required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="postcode" v-model="postcode" :rules="postcodeRules" label="PSČ" clearable required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <v-autocomplete :menu-props="autocompleteMenuProps()" ref="country" v-model="country" :rules="countryRules" :items="countries" label="Krajina" clearable required>
                      </v-autocomplete>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <VueTelInputVuetify v-model="myPhone" :rules="myPhoneRules" :preferred-countries="['svk']" :valid-characters-only="true" @input="onInput" label="Mobilné číslo" placeholder="" clearable></VueTelInputVuetify>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <v-textarea v-model="note" :rules="noteRules" label=" Poznámka" rows="1" counter="50" clearable>
                      </v-textarea>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>

              <v-btn color="accent" @click="e1 = 3; backStep3()" class="mr-2" outlined>
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn>

              <v-btn color="primary" @click="checkStatus4()">
                Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="5">
              <v-card class="m-3" tile>
                <v-card-title>Rekapitulácia</v-card-title>
                <v-card-text>
                  <span>Kontaknté údaje</span>
                  <v-divider />
                  <v-row justify="center">
                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="surname" v-model="surname" label="Meno" readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="lastname" v-model="lastname" label="Priezvisko" readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <v-text-field ref="address" v-model="address" label="Adresa" readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="city" v-model="city" label="Mesto" readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0">
                      <v-text-field ref="postcode" v-model="postcode" label="PSČ" readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-autocomplete ref="country" v-model="country" :items="countries" label="Krajina" readonly>
                      </v-autocomplete>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <VueTelInputVuetify v-model="myPhone" label="Mobilné číslo" placeholder="" readonly></VueTelInputVuetify>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <div v-if="note == null">
                        <v-textarea value="-" label=" Poznámka" rows="1" readonly>
                        </v-textarea>
                      </div>
                      <div v-else>
                        <v-textarea v-model="note" label=" Poznámka" rows="1" readonly>
                        </v-textarea>
                      </div>
                    </v-col>
                  </v-row>

                  <span>pocet osob</span>
                  Dospeli: {{counter1}}
                  Deti od 2 do 10 rokov: {{counter2}}
                  Deti do 2 rokov: {{counter3}}

                  <span>datum a cas prichodu a odchodu</span>
                  Datum a cas prichodu: {{start_date}} {{start_time}}
                  Datum a cas odchodu: {{end_date}} {{end_time}}
                </v-card-text>
              </v-card>


              <v-btn color="accent" @click="e1 = 4; backStep4()" class="mr-2" outlined>
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn>

              <v-btn color="primary" @click="update()">
                Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
        <!-- </v-lazy> -->
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>

<script>
import axios from 'axios'
import moment from 'moment';
import Calendar from "@/components/Calendar.vue";
import VueTelInputVuetify from "vue-tel-input-vuetify/lib/vue-tel-input-vuetify.vue"
const config = {
  headers: {
    Accept: "application/json",
    // 'Content-Type': 'multipart/form-data',
    Authorization: "Bearer " + localStorage.getItem("authToken"),
  },
};

export default {
  name: "VytvoritRezervaciu",
  components: {
    Calendar,
    VueTelInputVuetify
  },
  data() {
    return {
      isActive: false,
      e1: 1,
      rules: [

      ],
      step1: true,
      step2: true,
      step3: true,
      step4: true,
      step5: true,
      counter1: 1,
      counter2: 0,
      counter3: 0,

      start_time: null,
      end_time: null,
      modal1: false,
      modal2: false,

      // contact form
      countries: ['Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola', 'Anguilla', 'Antigua &amp; Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus',
        'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia &amp; Herzegovina', 'Botswana', 'Brazil', 'British Virgin Islands', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Cape Verde',
        'Cayman Islands', 'Chad', 'Chile', 'China', 'Colombia', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote D Ivoire', 'Croatia', 'Cruise Ship', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic',
        'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Polynesia', 'French West Indies', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana',
        'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea Bissau', 'Guyana', 'Haiti', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq', 'Ireland', 'Isle of Man',
        'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya', 'Kuwait', 'Kyrgyz Republic', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia',
        'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Mauritania', 'Mauritius', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nepal', 'Netherlands',
        'Netherlands Antilles', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palestine', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal', 'Puerto Rico',
        'Qatar', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'Saint Pierre &amp; Miquelon', 'Samoa', 'San Marino', 'Satellite', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'South Africa',
        'South Korea', 'Spain', 'Sri Lanka', 'St Kitts &amp; Nevis', 'St Lucia', 'St Vincent', 'St. Lucia', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', `Timor L'Este`,
        'Togo',
        'Tonga', 'Trinidad &amp; Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks &amp; Caicos', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Venezuela', 'Vietnam',
        'Virgin Islands (US)', 'Yemen', 'Zambia', 'Zimbabwe'
      ],
      errorMessages: '',

      start_date: null,
      end_date: null,

      phone: {
        number: '',
        valid: false,
        country: undefined,
      },
      formHasErrors: false,

      surname: null,
      surnameRules: [
        v => !!v || 'Meno je povinné',
        v => (v && v.length <= 10) || 'Meno musí obsahovať max 10 znakov',
      ],
      lastname: null,
      lastnameRules: [
        v => !!v || 'Priezvisko je povinné',
      ],
      address: null,
      addressRules: [
        v => !!v || 'Adresa je povinná',
      ],
      city: null,
      cityRules: [
        v => !!v || 'Mesto je povinné',
      ],
      postcode: null,
      postcodeRules: [
        v => !!v || 'PSČ je povinné',
      ],
      country: null,
      countryRules: [
        v => !!v || 'Krajina je povinná',
      ],
      myPhone: null,
      myPhoneRules: [
        v => !!v || 'Mobilné číslo je povinné',
      ],
      note: null,
      noteRules: [
        v => (v && v.length <= 50) || 'Poznámka musí obsahovať max 50 znakov',
      ],

      // Snackbar
      multiLine: true,
      snackbar: false,
      text: '',
    }
  },

  mounted() {
    const api = 'http://127.0.0.1:8000/api/getContactForm';

    axios.get(api, config)
      .then(res => {
        // console.log(res);
        if (res.data.length != 0) {
          this.surname = res.data[0].surname;
          this.lastname = res.data[0].lastname;
          this.address = res.data[0].address;
          this.city = res.data[0].city;
          this.postcode = res.data[0].postcode;
          this.country = res.data[0].country;
          this.myPhone = res.data[0].phone;
        }
      });
  },

  methods: {
    onInput(formattedNumber, {
      number,
      valid,
      country
    }) {
      this.phone.number = number.international;
      this.phone.valid = valid;
      this.phone.country = country && country.name;
    },
    autocompleteMenuProps() {
      // default properties copied from the vuetify-autocomplete docs
      let defaultProps = {
        closeOnClick: false,
        closeOnContentClick: false,
        disableKeys: true,
        openOnClick: false,
        maxHeight: 304
      };

      if (this.$vuetify.breakpoint.smAndDown) {
        defaultProps.maxHeight = 112;
        defaultProps.top = true;
      }
      return defaultProps;
    },

    checkStatus() {
      this.step1 = this.$store.getters['successMakeReservation'].success
      if (this.step1) {
        this.e1 = 2;
      } else {
        this.step1 = false;
        this.snackbar = true;
        this.text = "Je potrebné vybrať dátum začiatku a konca!";
      }
    },

    checkStatus2() {
      if (this.start_time == null || this.end_time == null) {
        this.step2 = false;
        this.snackbar = true;
        this.text = "Je potrebné vybrať čas príchodu a odchodu!";
      } else {
        this.step2 = true;
        this.e1 = 3;
      }
    },

    checkStatus3() {
      if (this.counter1 == 0 && this.counter2 == 0 && this.counter3 == 0) {
        this.step3 = false;
        this.snackbar = true;
        this.text = "Je potrebné zadať počet osôb!";
      } else {
        this.step3 = true;
        this.e1 = 4;
      }
    },

    checkStatus4() {
      if (
        this.surname == null ||
        this.lastname == null ||
        this.address == null ||
        this.city == null ||
        this.postcode == null ||
        this.country == null ||
        this.myPhone == null
      ) {
        this.step4 = false;
        this.snackbar = true;
        this.text = "Je potrebné vyplniť kontaktné údaje!";
      } else {
        this.step4 = true;
        this.e1 = 5;
      }
    },

    backStep4() {
      this.step4 = true;
    },

    backStep3() {
      this.step3 = true;
    },

    backStep2() {
      this.step2 = true;
    },

    backStep1() {
      this.step1 = true;
    },

    incrementValue1() {
      if (this.counter1 < 20) {
        this.counter1++;
      }
    },
    decrementValue1() {
      if (this.counter1 > 1) {
        this.counter1--;
      }
    },
    resetValue1() {
      this.counter1 = 0;
    },

    incrementValue2() {
      if (this.counter2 < 20) {
        this.counter2++;
      }
    },
    decrementValue2() {
      if (this.counter2 > 0) {
        this.counter2--;
      }
    },
    resetValue2() {
      this.counter2 = 0;
    },

    incrementValue3() {
      if (this.counter3 < 20) {
        this.counter3++;
      }
    },
    decrementValue3() {
      if (this.counter3 > 0) {
        this.counter3--;
      }
    },
    resetValue3() {
      this.counter3 = 0;
    },

    update() {
      if (this.step1 && this.step2 && this.step3 && this.step4) {
        alert("yes vsetko ok");
      } else {
        alert("mas chyby");
      }
    },

    //contact format
    addressCheck() {
      // this.errorMessages = this.address && !this.name ?
      //   `Hey! I'm required` :
      //   ''

      return false
    },
    resetForm() {
      this.errorMessages = []
      this.formHasErrors = false

      Object.keys(this.form)
        .forEach(f => {
          this.$refs[f].reset()
        })
    },
    submit() {
      this.formHasErrors = false

      Object.keys(this.form)
        .forEach(f => {
          if (!this.form[f]) this.formHasErrors = true

          this.$refs[f].validate(true)
        })
    },
  },

  computed: {
    form() {
      return {
        name: this.name,
        address: this.address,
        city: this.city,
        state: this.state,
        zip: this.zip,
        country: this.country,
      }
    },
  },

  watch: {
    name() {
      this.errorMessages = ''
    },
  },


  created() {
    //add text that user was sucessfully registered
    // console.log(this.$store.getters['successMakeReservation'].success)
    // this.step1 = this.$store.getters['successMakeReservation'].success
  },

  updated() {
    //do something after updating vue instance
    this.start_date = moment(this.$store.getters['successReservationData'].start_date)
      .format("YYYY-MM-DD");
    this.end_date = moment(this.$store.getters['successReservationData'].end_date)
      .format("YYYY-MM-DD");
  }
}
</script>

<style lang="scss">
.v-stepper__header {
    box-shadow: none !important;
}

.v-stepper__content {
    padding: 0 !important;
}
.v-stepper {
    box-shadow: none !important;
    background-color: unset !important;
}

.v-stepper__wrapper {
    padding-bottom: 10px;
}

.v-window__container {
    padding-bottom: 70px;
    min-height: 510px;
}

// .v-sheet.v-card:not(.v-sheet--outlined) {
//     box-shadow: unset !important;
// }
//
// @media only screen and (max-width: 959px) {
//     .v-stepper:not(.v-stepper--vertical) .v-stepper__label {
//         display: flex !important;
//     }
// }
</style>
