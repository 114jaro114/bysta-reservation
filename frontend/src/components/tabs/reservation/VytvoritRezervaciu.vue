<template>
<div class="vytvorit_rezervaciu w-100 h-100 mt-3">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <div class="text-center">
        <v-dialog v-model="contactFormDialog" max-width="290">
          <v-card>
            <v-card-title class="headline">
              Uloženie kontaktných informácií
            </v-card-title>

            <v-card-text>
              Prajete si zadané kontaktné informácie uložiť do Vášho účtu?
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn color="green darken-1" text @click="contactFormDialogOutput('no')">
                Nie
              </v-btn>

              <v-btn color="green darken-1" text @click="contactFormDialogOutput('yes')">
                Áno
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-snackbar v-model="snackbar" :multi-line="multiLine" color="error" :left="true">
          <v-icon>mdi-alert-circle</v-icon>
          {{ text }}

          <template v-slot:action="{ attrs }">

            <v-btn color="white" fab text small v-bind="attrs" @click="snackbar = false">
              <v-icon>mdi-close-circle</v-icon>
            </v-btn>
          </template>
        </v-snackbar>

        <v-snackbar v-model="snackbarSuccess" :multi-line="multiLine" color="success" :left="true">
          <v-icon>mdi-check-circle</v-icon>
          {{ text }}

          <template v-slot:action="{ attrs }">
            <v-btn color="white" to="/administration" text small v-bind="attrs" @click="snackbarSuccess = false">
              <v-icon>mdi-clipboard-arrow-up</v-icon>
              <span>prejsť do administrácia</span>
            </v-btn>
            <v-btn color="white" fab text small v-bind="attrs" @click="snackbarSuccess = false">
              <v-icon>mdi-close-circle</v-icon>
            </v-btn>
          </template>
        </v-snackbar>
      </div>
      <v-col class="pl-0 pr-0">
        <!-- <v-lazy v-model="isActive" :options="{
          threshold: .8
        }" min-height="200" transition="fade-transition"> -->
        <v-stepper v-model="e1">
          <v-stepper-header elevation="5">
            <v-stepper-step color="primary" :complete="e1 > 1" :rules="[() => step1]" step="1" error-icon="mdi-alert-circle">
              Dátum a čas príchodu a odchodu
              <small v-if="step1 == false">Chyba</small>
            </v-stepper-step>

            <!-- <v-divider></v-divider>

            <v-stepper-step color="primary" :complete="e1 > 2" :rules="[() => step2]" step="2" error-icon="mdi-alert-circle">
              Čas príchodu a odchodu
              <small v-if="step2 == false">Chyba</small>
            </v-stepper-step> -->

            <v-divider></v-divider>

            <v-stepper-step color="primary" :complete="e1 > 2" :rules="[() => step2]" step="2" error-icon="mdi-alert-circle">
              Počet osôb
              <small v-if="step2 == false">Chyba</small>
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step color="primary" :complete="e1 > 3" :rules="[() => step3]" step="3" error-icon="mdi-alert-circle">
              Kontaktné informácie
              <small v-if="step3 == false">Chyba</small>
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step color="primary" :rules="[() => step4]" step="4" error-icon="mdi-alert-circle">
              Rekapitulácia
              <small v-if="step4 == false">Chyba</small>
            </v-stepper-step>
          </v-stepper-header>
          <v-stepper-items class="h-100">
            <v-stepper-content step="1">
              <div v-if="this.$store.getters['pendingReservation'] != 0">
                <span>
                  <v-icon color="orange">mdi-information</v-icon>Pred pridaním ďalšej rezervácie Vám musí byť potvrdená aktuálna rezervácia. Po jej potvrdení budete môcť vytvoriť ďalšiu.
                </span>
              </div>
              <!-- <v-card class="m-3" :loading="myloadingvariable"> -->
              <Calendar />
              <!-- <v-row class="justify-center">
                  <v-col cols="12" lg="6" md="12" sm="12">
                    <v-icon color="orange">mdi-rectangle</v-icon>
                    <span>Rezervácia je na tieto dni už vytvorená, avšak ešte <span class="font-weight-bold"> nie je akceptovaná.</span></span>
                  </v-col>
                  <v-col cols="12" lg="6" md="12" sm="12">
                    <v-icon color="red">mdi-rectangle</v-icon>
                    <span>Rezervácia bola na tieto dni vytvorená a aktuálne <span class="font-weight-bold"> už je akceptovaná.</span></span>
                  </v-col>
                </v-row> -->
              <!-- </v-card> -->
              <div class="pt-3" v-if="this.$store.getters['pendingReservation'] == 0">
                <v-btn color="accent" disabled class="mr-2" outlined>
                  <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
                </v-btn>

                <v-btn color="primary" @click="checkStatus()">
                  Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
                </v-btn>
              </div>
              <div class="pt-3" v-else>
                <v-btn color="accent" disabled class="mr-2" outlined>
                  <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
                </v-btn>

                <v-btn color="primary" @click="checkStatus()" disabled>
                  Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
                </v-btn>
              </div>
            </v-stepper-content>

            <!-- <v-stepper-content step="2">
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
                </v-card-text> -->
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
            <!-- </v-card>

              <v-btn color="accent" @click="e1 = 1; backStep1()" class="mr-2" outlined>
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn>

              <v-btn color="primary" @click="checkStatus2()">
                Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-stepper-content> -->

            <v-stepper-content step="2">
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

                  <v-row class="m-0 mt-1">
                    <v-col class="pl-0 pr-0" align="left">
                      <v-icon color="orange">mdi-information</v-icon>
                      <span class="ml-1">Deti do 2 rokov sa do počtu hostí nezapočitávajú.</span>
                    </v-col>
                  </v-row>

                  <v-divider />

                  <v-row class="m-0">
                    <v-col></v-col>
                    <v-col class="font-weight-bold">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">Počet osôb</span>
                        </template>
                        <span>Maximálny počet osôb je 20!</span>
                      </v-tooltip>

                    </v-col>
                    <v-col class="font-weight-bold">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon v-bind="attrs" v-on="on">mdi-information</v-icon>
                          <span>Cena/noc</span>
                        </template>
                        <span v-if="counter1 > 1">Cena na jednu noc za {{counter1}} osoby</span>
                        <span v-else>Cena za 1 noc pre {{counter1}} osobu</span>
                      </v-tooltip>

                    </v-col>
                    <v-col class="font-weight-bold">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon v-bind="attrs" v-on="on">mdi-information</v-icon>
                        </template>
                        <span>Od {{start_date}} do {{end_date}}</span>
                      </v-tooltip>
                      <span v-if="countDaysBetweemTwoDates > 1">Cena/{{countDaysBetweemTwoDates}} noci</span>
                      <span v-else>Cena/{{countDaysBetweemTwoDates}} noc</span>
                    </v-col>
                  </v-row>
                  <v-row class="m-0">
                    <v-col>
                      <span>Dospelí</span>
                    </v-col>
                    <v-col>
                      <span>{{counter1}}</span>
                    </v-col>
                    <v-col>
                      <span>{{counter1*priceAdults}} €</span>
                    </v-col>
                    <v-col>
                      <span>{{counter1*priceAdults*countDaysBetweemTwoDates}} €</span>
                    </v-col>
                  </v-row>

                  <v-divider v-if="counter2 > 0" />
                  <v-row class="m-0" v-if="counter2 > 0">

                    <v-col>
                      <span>Deti od 2 do 12 rokov</span>
                    </v-col>
                    <v-col>
                      <span>{{counter2}}</span>
                    </v-col>
                    <v-col>
                      <span>{{counter2*priceChilds2to12}} €</span>
                    </v-col>
                    <v-col>
                      <span>{{counter2*priceChilds2to12*countDaysBetweemTwoDates}} €</span>
                    </v-col>
                  </v-row>

                  <v-divider v-if="counter3 > 0" />
                  <v-row class="m-0" v-if="counter3 > 0">
                    <v-col>
                      <span>Deti do 2 rokov</span>
                    </v-col>
                    <v-col>
                      <span>{{counter3}}</span>
                    </v-col>
                    <v-col>
                      <span>{{counter3*priceChildsto2}} €</span>
                    </v-col>
                    <v-col>
                      <span>{{counter3*priceChildsto2*countDaysBetweemTwoDates}} €</span>
                    </v-col>
                  </v-row>

                  <v-divider />
                  <v-row class="m-0">
                    <v-col>
                      <span class="font-weight-bold">Spolu</span>
                    </v-col>
                    <v-col>
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <span class="font-weight-bold" v-bind="attrs" v-on="on">{{counter1+counter2+counter3}}</span>
                        </template>
                        <span>Celkový počet osôb: {{counter1+counter2+counter3}}</span>
                      </v-tooltip>
                    </v-col>
                    <v-col>
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <span class="font-weight-bold" v-bind="attrs" v-on="on">{{counter1*priceAdults + counter2*priceChilds2to12 + counter3*priceChildsto2}} €</span>
                        </template>
                        <span v-if="counter1+counter2+counter3 > 1">Cena je za {{counter1+counter2+counter3}} osoby na 1 noc</span>
                        <span v-else>Celková cena za {{counter1+counter2+counter3}} osobu na 1 noc</span>
                      </v-tooltip>
                    </v-col>
                    <v-col>
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <span class="text-decoration-underline font-weight-bold" v-bind="attrs" v-on="on">
                            {{counter1*priceAdults*countDaysBetweemTwoDates + counter2*priceChilds2to12*countDaysBetweemTwoDates + counter3*priceChildsto2*countDaysBetweemTwoDates}} €</span>
                        </template>
                        <span v-if="counter1+counter2+counter3 > 1">Celková cena za {{counter1+counter2+counter3}} osoby na {{countDaysBetweemTwoDates}} noci</span>
                        <span v-else>Celková cena za {{counter1+counter2+counter3}} osobu na {{countDaysBetweemTwoDates}} noci</span>
                      </v-tooltip>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>

              <v-btn color="accent" @click="e1 = 1; backStep2()" class="mr-2" outlined>
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn>

              <v-btn color="primary" @click="checkStatus3()">
                Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
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

              <v-btn color="accent" @click="e1 = 2; backStep3()" class="mr-2" outlined>
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn>

              <v-btn color="primary" @click="checkStatus4()">
                Pokračovať<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-stepper-content>

            <v-stepper-content step="4">
              <v-card class="m-3" tile>
                <v-card-title class="justify-center">Rekapitulácia</v-card-title>
                <v-card-text>
                  <v-row align="center">
                    <v-divider />
                    <span class="font-weight-bold">Kontaktné údaje</span>
                    <v-divider />
                  </v-row>
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

                  <v-row align="center">
                    <v-divider />
                    <span class="font-weight-bold">Dátum a čas príchodu a odchodu</span>
                    <v-divider />
                  </v-row>
                  <v-row>
                    <v-col>
                      <v-sheet class="p-4 mx-auto" rounded outlined>
                        <v-row class="justify-center">
                          <span>Príchod</span>
                        </v-row>
                        <v-row class="justify-center">
                          <v-col>
                            <v-icon>mdi-calendar-start</v-icon>
                            <span>Dátum: {{start_date}}</span>
                          </v-col>
                        </v-row>
                        <v-row class="justify-center">
                          <v-col>
                            <v-icon>mdi-clock-start</v-icon>
                            <span>Čas: {{start_time}}</span>
                          </v-col>
                        </v-row>
                      </v-sheet>
                    </v-col>
                    <v-col>
                      <v-sheet class="p-4 mx-auto" rounded outlined>
                        <v-row class="justify-center">
                          <span>Odchod</span>
                        </v-row>
                        <v-row class="justify-center">
                          <v-col>
                            <v-icon>mdi-calendar-end</v-icon>
                            <span>Dátum: {{end_date}}</span>
                          </v-col>
                        </v-row>
                        <v-row class="justify-center">
                          <v-col>
                            <v-icon>mdi-clock-end</v-icon>
                            <span>Čas: {{end_time}}</span>
                          </v-col>
                        </v-row>
                      </v-sheet>
                    </v-col>
                  </v-row>

                  <v-row align="center">
                    <v-divider />
                    <span class="font-weight-bold">Počet osôb</span>
                    <v-divider />
                  </v-row>

                  <v-row class="m-0">
                    <v-col></v-col>
                    <v-col class="font-weight-bold">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">Počet osôb</span>
                        </template>
                        <span>Maximálny počet osôb je 20!</span>
                      </v-tooltip>

                    </v-col>
                    <v-col class="font-weight-bold">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon v-bind="attrs" v-on="on">mdi-information</v-icon>
                          <span>Cena/noc</span>
                        </template>
                        <span v-if="counter1 > 1">Cena na jednu noc za {{counter1}} osoby</span>
                        <span v-else>Cena za 1 noc pre {{counter1}} osobu</span>
                      </v-tooltip>

                    </v-col>
                    <v-col class="font-weight-bold">
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon v-bind="attrs" v-on="on">mdi-information</v-icon>
                        </template>
                        <span>Od {{start_date}} do {{end_date}}</span>
                      </v-tooltip>
                      <span v-if="countDaysBetweemTwoDates > 1">Cena/{{countDaysBetweemTwoDates}} noci</span>
                      <span v-else>Cena/{{countDaysBetweemTwoDates}} noc</span>
                    </v-col>
                  </v-row>
                  <v-row class="m-0">
                    <v-col>
                      <span>Dospelí</span>
                    </v-col>
                    <v-col>
                      <span>{{counter1}}</span>
                    </v-col>
                    <v-col>
                      <span>{{counter1*priceAdults}} €</span>
                    </v-col>
                    <v-col>
                      <span>{{counter1*priceAdults*countDaysBetweemTwoDates}} €</span>
                    </v-col>
                  </v-row>

                  <v-divider v-if="counter2 > 0" />
                  <v-row class="m-0" v-if="counter2 > 0">

                    <v-col>
                      <span>Deti od 2 do 12 rokov</span>
                    </v-col>
                    <v-col>
                      <span>{{counter2}}</span>
                    </v-col>
                    <v-col>
                      <span>{{counter2*priceChilds2to12}} €</span>
                    </v-col>
                    <v-col>
                      <span>{{counter2*priceChilds2to12*countDaysBetweemTwoDates}} €</span>
                    </v-col>
                  </v-row>

                  <v-divider v-if="counter3 > 0" />
                  <v-row class="m-0" v-if="counter3 > 0">
                    <v-col>
                      <span>Deti do 2 rokov</span>
                    </v-col>
                    <v-col>
                      <span>{{counter3}}</span>
                    </v-col>
                    <v-col>
                      <span>{{counter3*priceChildsto2}} €</span>
                    </v-col>
                    <v-col>
                      <span>{{counter3*priceChildsto2*countDaysBetweemTwoDates}} €</span>
                    </v-col>
                  </v-row>

                  <v-divider />
                  <v-row class="m-0">
                    <v-col>
                      <span class="font-weight-bold">Spolu</span>
                    </v-col>
                    <v-col>
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <span class="font-weight-bold" v-bind="attrs" v-on="on">{{counter1+counter2+counter3}}</span>
                        </template>
                        <span>Celkový počet osôb: {{counter1+counter2+counter3}}</span>
                      </v-tooltip>
                    </v-col>
                    <v-col>
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <span class="font-weight-bold" v-bind="attrs" v-on="on">{{counter1*priceAdults + counter2*priceChilds2to12 + counter3*priceChildsto2}} €</span>
                        </template>
                        <span v-if="counter1+counter2+counter3 > 1">Cena je za {{counter1+counter2+counter3}} osoby na 1 noc</span>
                        <span v-else>Celková cena za {{counter1+counter2+counter3}} osobu na 1 noc</span>
                      </v-tooltip>
                    </v-col>
                    <v-col>
                      <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                          <span class="text-decoration-underline font-weight-bold" v-bind="attrs" v-on="on">
                            {{overallPriceForNight}} €</span>
                        </template>
                        <span v-if="counter1+counter2+counter3 > 1">Celková cena za {{counter1}} {{counter1+counter2+counter3}} osoby na {{countDaysBetweemTwoDates}} noci</span>
                        <span v-else>Celková cena za {{counter1+counter2+counter3}} osobu na {{countDaysBetweemTwoDates}} noci</span>
                      </v-tooltip>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>


              <v-btn color="accent" @click="e1 = 3; backStep4()" class="mr-2" outlined>
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn>

              <v-btn color="primary" @click="store()">
                Odoslať rezerváciu<v-icon>mdi-arrow-right-thick</v-icon>
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
      priceAdults: 18,
      priceChildsto2: 0,
      priceChilds2to12: 18,
      countDaysBetweemTwoDates: null,
      overallPriceForNight: 18,

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
      snackbarSuccess: false,
      text: '',
      contactFormDialog: false,
      contactFormDialogOut: '',
      rowContactForm: '',
    }
  },

  mounted() {
    const api = 'http://127.0.0.1:8000/api/getContactForm';
    const config = {
      headers: {
        Accept: "application/json",
        // 'Content-Type': 'multipart/form-data',
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
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

    const api2 = `http://127.0.0.1:8000/api/checkPendingReservation/${localStorage.getItem('username')}`;
    axios.get(api2, config)
      .then(res => {
        this.$store.dispatch('pendingReservation', {
          count: res.data
        });
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

    // checkStatus2() {
    //   if (this.start_time == null || this.end_time == null) {
    //     this.step2 = false;
    //     this.snackbar = true;
    //     this.text = "Je potrebné vybrať čas príchodu a odchodu!";
    //   } else {
    //     this.step2 = true;
    //     this.e1 = 3;
    //   }
    // },

    checkStatus3() {
      if (this.counter1 == 0 && this.counter2 == 0 && this.counter3 == 0) {
        this.step2 = false;
        this.snackbar = true;
        this.text = "Je potrebné zadať počet osôb!";
      } else {
        this.step2 = true;
        this.e1 = 3;
      }
    },

    contactFormDialogOutput(param) {
      this.contactFormDialogOut = param;
      this.contactFormDialog = false;
      if (param == 'yes') {
        const api = 'http://127.0.0.1:8000/api/contactForm';
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.post(api, {
              surname: this.surname,
              lastname: this.lastname,
              address: this.address,
              city: this.city,
              postcode: this.postcode,
              country: this.country,
              phone: this.phone.number,
            },
            config
          )
          .then(res => {
            console.log(res);
          })
      } else {
        console.log('no');
      }
      this.step3 = true;
      this.e1 = 4;
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
        this.step3 = false;
        this.snackbar = true;
        this.text = "Je potrebné vyplniť kontaktné údaje!";
      } else {
        const api = 'http://127.0.0.1:8000/api/checkContactForm';
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.get(api, config)
          .then(res => {
            console.log(res);
            this.rowContactForm = res.data;
          });
        if (this.rowContactForm == 0) {
          console.log(this.rowContactForm);
          this.contactFormDialog = true;
        } else {
          this.step3 = true;
          this.e1 = 4;
        }
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
      if (this.counter1 + this.counter2 < 20) {
        if (this.counter1 < 20) {
          this.counter1++;
        }
      } else {
        this.snackbar = true;
        this.text = `Je zvolený maximálny počet osôb (${this.counter1+this.counter2})`;
      }
    },
    decrementValue1() {
      if (this.counter1 > 1) {
        this.counter1--;
      }
    },
    resetValue1() {
      this.counter1 = 1;
    },

    incrementValue2() {
      if (this.counter1 + this.counter2 < 20) {
        if (this.counter2 < 20) {
          this.counter2++;
        }
      } else {
        this.snackbar = true;
        this.text = `Je zvolený maximálny počet osôb (${this.counter1+this.counter2})`;
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

    store() {
      if (this.step1 && this.step2 && this.step3 && this.step4) {
        const api = 'http://127.0.0.1:8000/api/reservation/store';
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.post(api, {
            event_name: "rezervácia",
            username: localStorage.getItem('username'),
            start_date: this.start_date,
            end_date: this.end_date,
            start_time: this.start_time,
            end_time: this.end_time,
            nights: this.countDaysBetweemTwoDates,
            adults: this.counter1,
            childs2to12: this.counter2,
            childsto2: this.counter3,
            priceForNight: this.priceAdults,
            overallPriceForNight: this.overallPriceForNight,
            note: this.note
          }, config)
          .then(() => {
            const api = 'http://127.0.0.1:8000/api/sendNotification';
            const config = {
              headers: {
                Accept: "application/json",
                Authorization: "Bearer " + localStorage.getItem("authToken"),
              },
            };
            axios.post(api, {
                recipient: localStorage.getItem('user_id'),
                title: "Chata Byšta",
                subtitle: "Úspešne vytvorenie rezervácie",
                text: `Vážený ${localStorage.getItem('username')}, rezervácia bola úspešne vytvorená a čaká sa na jej potvrdenie. Stav Vašej rezervácie môžete sledovať v časti 'Administrácia'. `,
                date: moment(new Date())
                  .format('YYYY-MM-DD HH:mm'),
                status: "new",
              }, config)
              .then(() => {})
            this.snackbarSuccess = true;
            this.text = "Rezervácia bola úspešne vytvorená!";
            setTimeout(function() {
              this.$router.push("/Administration");
            }, 3000);

          })
          .catch(err => console.log("nepodarilo sa pridat event", err));
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

    console.log(this.start_date);
    this.start_time = this.$store.getters['successReservationData'].start_time;
    this.end_time = this.$store.getters['successReservationData'].end_time;

    //Difference in number of days
    // moment.duration(moment(this.start_date, 'YYYY-MM-DD')
    //     .diff(moment(this.end_date, 'YYYY-MM-DD')))
    //   .asDays();
    //
    // //Difference in number of weeks
    // moment.duration(start.diff(end))
    //   .asWeeks();
    this.countDaysBetweemTwoDates = moment(this.end_date, 'YYYY-MM-DD')
      .diff(moment(this.start_date, 'YYYY-MM-DD'), 'days');
    this.overallPriceForNight = this.counter1 * this.priceAdults * this.countDaysBetweemTwoDates + this.counter2 * this.priceChilds2to12 * this.countDaysBetweemTwoDates + this.counter3 * this.priceChildsto2 * this.countDaysBetweemTwoDates
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
