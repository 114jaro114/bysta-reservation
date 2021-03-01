<template>
<div class="vytvorit_rezervaciu w-100 h-100 text-uppercase secondary-color">
  <div class="row justify-content-center mr-0 ml-0">
    <div class="col pl-0 pr-0 mt-3">
      <!-- <v-lazy v-model="isActive" :options="{
          threshold: .8
        }" min-height="200" transition="fade-transition"> -->
      <v-stepper v-model="e1">
        <v-stepper-header>
          <v-stepper-step color="info" :complete="e1 > 1" :rules="[() => step1]" step="1" error-icon="mdi-alert-circle">
            Dátum
            <small v-if="step1 == false">Chyba</small>
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step color="info" :complete="e1 > 2" :rules="[() => step2]" step="2" error-icon="mdi-alert-circle">
            Čas príchodu a odchodu
            <small v-if="step2 == false">Chyba</small>
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step color="info" :complete="e1 > 3" :rules="[() => step3]" step="3" error-icon="mdi-alert-circle">
            Počet osôb
            <small v-if="step3 == false">Chyba</small>
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step color="info" :complete="e1 > 4" :rules="[() => step4]" step="4" error-icon="mdi-alert-circle">
            Kontaktné informácie
            <small v-if="step4 == false">Chyba</small>
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step color="info" :rules="[() => step5]" step="5" error-icon="mdi-alert-circle">
            Rekapitulácia
            <small v-if="step5 == false">Chyba</small>
          </v-stepper-step>
        </v-stepper-header>

        <v-stepper-items class="h-100">
          <v-stepper-content step="1">
            <Calendar />

            <v-btn disabled class="mr-2">
              <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
            </v-btn>

            <v-btn color="info" @click="e1 = 2; checkStatus()">
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

            <v-btn @click="e1 = 1; backStep1()" class="mr-2">
              <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
            </v-btn>

            <v-btn color="info" @click="e1 = 3; checkStatus2()">
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
                  <v-btn class="mx-2" fab dark x-small color="info" @click="decrementValue1">
                    <v-icon dark>
                      mdi-minus
                    </v-icon>
                  </v-btn>
                  <v-text-field style="width: 70px" class="counter" v-model="counter1" placeholder="" filled rounded dense></v-text-field>
                  <v-btn class="mx-2" fab dark x-small color="info" @click="incrementValue1">
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
                  <v-btn class="mx-2" fab dark x-small color="info" @click="decrementValue2">
                    <v-icon dark>
                      mdi-minus
                    </v-icon>
                  </v-btn>
                  <v-text-field style="width: 70px" v-model="counter2" placeholder="" filled rounded dense></v-text-field>
                  <v-btn class="mx-2" fab dark x-small color="info" @click="incrementValue2">
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
                  <v-btn class="mx-2" fab dark x-small color="info" @click="decrementValue3">
                    <v-icon dark>
                      mdi-minus
                    </v-icon>
                  </v-btn>
                  <v-text-field style="width: 70px" class="counter" v-model="counter3" placeholder="" filled rounded dense></v-text-field>
                  <v-btn class="mx-2" fab dark x-small color="info" @click="incrementValue3">
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

            <v-btn @click="e1 = 2; backStep2()" class="mr-2">
              <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
            </v-btn>

            <v-btn color="info" @click="e1 = 4; checkStatus3()">
              Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
            </v-btn>
          </v-stepper-content>

          <v-stepper-content step="4">
            <v-card class="m-3" tile>
              <!-- <v-row justify="center">
                <v-col cols="12" sm="12" md="12" lg="6"> -->
              <v-card-text>
                <v-row justify="center">
                  <v-col cols="12" sm="12" md="6" lg="6">
                    <v-text-field ref="name" v-model="name" :rules="[() => !!name || 'This field is required']" :error-messages="errorMessages" label="Meno" clearable clear-icon="mdi-close-circle" required></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="12" md="6" lg="6">
                    <v-text-field ref="lastname" v-model="lastname" :rules="[() => !!lastname || 'This field is required']" :error-messages="errorMessages" label="Priezvisko" clearable clear-icon="mdi-close-circle" required></v-text-field>
                  </v-col>
                </v-row>


                <v-text-field ref="address" v-model="address" :rules="[() => !!address || 'This field is required',
                      () => !!address && address.length <= 25 || 'Address must be less than 25 characters',
                      addressCheck]" label="Adresa" counter="25" clearable clear-icon="mdi-close-circle" required></v-text-field>
                <v-row justify="center">
                  <v-col cols="12" sm="12" md="6" lg="6">
                    <v-text-field ref="city" v-model="city" :rules="[() => !!city || 'This field is required', addressCheck]" label="Mesto" clearable clear-icon="mdi-close-circle" required></v-text-field>
                  </v-col>

                  <v-col cols="12" sm="12" md="6" lg="6">
                    <v-text-field ref="zip" v-model="zip" :rules="[() => !!zip || 'This field is required']" label="PSČ" clearable clear-icon="mdi-close-circle" required></v-text-field>
                  </v-col>
                </v-row>
                <v-autocomplete :menu-props="autocompleteMenuProps()" ref="country" v-model="country" :rules="[() => !!country || 'This field is required']" :items="countries" label="Krajina" clearable clear-icon="mdi-close-circle" required>
                </v-autocomplete>
                <v-textarea v-model="comment" :rules="[() => !!comment && comment.length <= 25 || 'Address must be less than 50 characters']" label=" Poznámka" rows="1" counter="50" clearable clear-icon="mdi-close-circle">
                </v-textarea>
              </v-card-text>
              <!-- <v-divider class="mt-12"></v-divider>
                  <v-card-actions>
                    <v-btn text>
                      Cancel
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-slide-x-reverse-transition>
                      <v-tooltip v-if="formHasErrors" left>
                        <template v-slot:activator="{ on, attrs }">
                          <v-btn icon class="my-0" v-bind="attrs" @click="resetForm" v-on="on">
                            <v-icon>mdi-refresh</v-icon>
                          </v-btn>
                        </template>
                        <span>Refresh form</span>
                      </v-tooltip>
                    </v-slide-x-reverse-transition>
                    <v-btn color="primary" text @click="submit">
                      Submit
                    </v-btn>
                  </v-card-actions> -->
              <!-- </v-col>
              </v-row> -->
            </v-card>

            <v-btn @click="e1 = 3; backStep3()" class="mr-2">
              <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
            </v-btn>

            <v-btn color="info" @click="e1 = 5; checkStatus4()">
              Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
            </v-btn>
          </v-stepper-content>

          <v-stepper-content step="5">
            <v-card class="m-3" tile>
              Rekapitulácia
            </v-card>

            <v-btn @click="e1 = 3; backStep3()" class="mr-2">
              <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
            </v-btn>

            <v-btn color="info" @click="update()">
              Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
            </v-btn>
          </v-stepper-content>
        </v-stepper-items>
      </v-stepper>
      <!-- </v-lazy> -->
    </div>
  </div>
</div>
</template>

<script>
import Calendar from "@/components/Calendar.vue";
export default {
  name: "VytvoritRezervaciu",
  components: {
    Calendar
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
      counter1: 0,
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
        'South Korea', 'Spain', 'Sri Lanka', 'St Kitts &amp; Nevis', 'St Lucia', 'St Vincent', 'St. Lucia', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', `Timor L'Este`, 'Togo',
        'Tonga', 'Trinidad &amp; Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks &amp; Caicos', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan', 'Venezuela', 'Vietnam',
        'Virgin Islands (US)', 'Yemen', 'Zambia', 'Zimbabwe'
      ],
      errorMessages: '',
      name: null,
      lastname: null,
      address: null,
      city: null,
      zip: null,
      country: null,
      formHasErrors: false,
      comment: null,


      // rules: [
      //   v => !!v || 'Meno je povinné',
      //   v => (v && v.length <= 10) || 'Meno musí obsahovať max 10 znakov',
      // ],
    }
  },

  methods: {
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
        defaultProps.maxHeight = 130;
        defaultProps.top = true;
      }
      return defaultProps;
    },

    checkStatus() {
      this.step1 = this.$store.getters['successMakeReservation'].success
    },

    checkStatus2() {
      if (this.start_time == null || this.end_time == null) {
        this.step2 = false;
      } else {
        this.step2 = true;
      }
    },

    checkStatus3() {
      if (this.counter1 == 0 && this.counter2 == 0 && this.counter3 == 0) {
        this.step3 = false;
      } else {
        this.step3 = true;
      }
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
      if (this.counter1 > 0) {
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
      this.errorMessages = this.address && !this.name ?
        `Hey! I'm required` :
        ''

      return true
    },
    resetForm() {
      this.errorMessages = []
      this.formHasErrors = false

      Object.keys(this.form).forEach(f => {
        this.$refs[f].reset()
      })
    },
    submit() {
      this.formHasErrors = false

      Object.keys(this.form).forEach(f => {
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
    console.log(this.$store.getters['successMakeReservation'].success)
    // this.step1 = this.$store.getters['successMakeReservation'].success
    console.log(this.step1)
    console.log('Component login created')
  },

  updated() {
    //do something after updating vue instance
    console.log(this.$store.getters['successMakeReservation'].success);
    console.log(this.step1);
    console.log(this.step2);
    console.log(this.step3);
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
