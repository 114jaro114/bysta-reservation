<template>
<div class="create_reservation">
  <v-overlay :value="overlay">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>
  <v-row justify="center" class="m-0" v-if="successCreatedReservation == false">
    <div class="text-center">
      <v-dialog v-model="contactFormDialog" max-width="290">
        <v-card class="rounded" elevation="0">
          <v-card-title class="headline">
            Uloženie kontaktných informácií
          </v-card-title>

          <v-card-text>
            Prajete si zadané kontaktné informácie uložiť do Vášho účtu?
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="error darken-1" text @click="contactFormDialogOutput('no')">
              Nie
            </v-btn>

            <v-btn color="primary" outlined @click="contactFormDialogOutput('yes')">
              Áno
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div>
    <v-col class="p-0">
      <v-container>
        <v-stepper v-model="e1">
          <!-- stepper header -->
          <v-stepper-header elevation="0">
            <v-stepper-step color="primary" :complete="e1 > 1" :rules="[() => step1]" step="1" error-icon="mdi-alert-circle">
              Dátum a čas príchodu a odchodu
              <small v-if="step1 == false">Chyba</small>
            </v-stepper-step>

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
          <!-- end stepper header -->

          <v-stepper-items class="h-100">
            <v-stepper-content step="1">
              <div class="mb-1" v-if="this.$store.getters['pendingReservation'] != 0">
                <v-icon class="mb-1" color="orange">mdi-information</v-icon>
                <span>
                  Pred pridaním ďalšej rezervácie Vám musí byť potvrdená aktuálna rezervácia. Po jej potvrdení budete môcť vytvoriť ďalšiu.
                </span>
              </div>
              <!-- <v-card class="m-3" :loading="myloadingvariable"> -->
              <Calendar @loaded-events="loadedEvents" @array-dates="arrayDates" />
              <div class="pt-3" v-if="this.$store.getters['pendingReservation'] == 0">
                <v-btn color="accent" disabled class="mr-2" outlined>
                  <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
                </v-btn>

                <v-slide-y-transition>
                  <v-btn color="primary" class="anim" @click="checkStatus(); toTop()">
                    Pokračovať
                    <v-icon class="arrow">mdi-arrow-right</v-icon>
                  </v-btn>
                </v-slide-y-transition>
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
              <v-card class="rounded" elevation="0">
                <v-card-text>
                  <v-row class="m-0">
                    <v-col class="p-0 pr-lg-4" cols="12" sm="12" md="12" lg="4">
                      <v-row class="m-0">
                        <span>Dospelí</span>
                      </v-row>

                      <v-row class="ml-0 mr-0">
                        <v-btn class="mr-2 mt-1" fab dark x-small color="primary" @click="decrementValue1">
                          <v-icon dark>
                            mdi-minus
                          </v-icon>
                        </v-btn>
                        <v-text-field style="width: 70px" class="counter" v-model="reservation.counter1" placeholder="" filled rounded dense></v-text-field>
                        <v-btn class="mx-2 mt-1" fab dark x-small color="primary" @click="incrementValue1">
                          <v-icon dark>
                            mdi-plus
                          </v-icon>
                        </v-btn>
                        <v-btn style="margin-top: 6px" rounded small outlined color="error" @click="resetValue1">
                          <span class="font-weight-bold text-uppercase">reset</span>
                        </v-btn>
                      </v-row>
                    </v-col>

                    <v-col class="p-0 pl-lg-2 pr-lg-2" cols="12" sm="12" md="12" lg="4">
                      <v-row class="m-0">
                        <span>Deti od 2 do 12 rokov</span>
                      </v-row>

                      <v-row class="ml-0 mr-0">
                        <v-btn class="mr-2 mt-1" fab dark x-small color="primary" @click="decrementValue2">
                          <v-icon dark>
                            mdi-minus
                          </v-icon>
                        </v-btn>
                        <v-text-field style="width: 70px" v-model="reservation.counter2" placeholder="" filled rounded dense></v-text-field>
                        <v-btn class="mx-2 mt-1" fab dark x-small color="primary" @click="incrementValue2">
                          <v-icon dark>
                            mdi-plus
                          </v-icon>
                        </v-btn>
                        <v-btn style="margin-top: 6px" rounded small outlined color="error" @click="resetValue2">
                          <span class="font-weight-bold text-uppercase">reset</span>
                        </v-btn>
                      </v-row>
                    </v-col>

                    <v-col class="p-0 pl-lg-4" cols="12" sm="12" md="12" lg="4">
                      <v-row class="m-0">
                        <span>Deti do 2 rokov</span>
                      </v-row>

                      <v-row class="ml-0 mr-0">
                        <v-btn class="mr-2 mt-1" fab dark x-small color="primary" @click="decrementValue3">
                          <v-icon dark>
                            mdi-minus
                          </v-icon>
                        </v-btn>
                        <v-text-field style="width: 70px" class="counter" v-model="reservation.counter3" placeholder="" filled rounded dense></v-text-field>
                        <v-btn class="mx-2 mt-1" fab dark x-small color="primary" @click="incrementValue3">
                          <v-icon dark>
                            mdi-plus
                          </v-icon>
                        </v-btn>
                        <v-btn style="margin-top: 6px" rounded small outlined color="error" @click="resetValue3">
                          <span class="font-weight-bold text-uppercase">reset</span>
                        </v-btn>
                      </v-row>
                    </v-col>
                  </v-row>
                  <!-- <v-row class="m-0">
                    <span>Dospelí</span>
                  </v-row>

                  <v-row class="ml-3 mr-3">
                    <v-btn class="mx-2" fab dark x-small color="primary" @click="decrementValue1">
                      <v-icon dark>
                        mdi-minus
                      </v-icon>
                    </v-btn>
                    <v-text-field style="width: 70px" class="counter" v-model="reservation.counter1" placeholder="" filled rounded dense></v-text-field>
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
                    <v-text-field style="width: 70px" v-model="reservation.counter2" placeholder="" filled rounded dense></v-text-field>
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
                    <v-text-field style="width: 70px" class="counter" v-model="reservation.counter3" placeholder="" filled rounded dense></v-text-field>
                    <v-btn class="mx-2" fab dark x-small color="primary" @click="incrementValue3">
                      <v-icon dark>
                        mdi-plus
                      </v-icon>
                    </v-btn>
                    <v-btn depressed color="error" @click="resetValue3">
                      Resetovať
                    </v-btn>
                  </v-row> -->

                  <v-divider />

                  <v-row class="m-0 mt-3">
                    <v-col class="pl-0 pr-0" align="left">
                      <v-icon color="orange">mdi-information</v-icon>
                      <span class="ml-1">Deti do 2 rokov sa do počtu hostí nezapočítavajú.</span>
                    </v-col>
                  </v-row>

                  <v-row class="m-0 mt-1">
                    <v-col class="pl-0 pr-0" align="left">
                      <v-icon color="orange">mdi-information</v-icon>
                      <span class="ml-1">Ak je počet osôb rezervácie menší ako 6, platí sa poplatok za celú chatu v cene 150€/noc. <span class="font-weight-bold">(Deti do 2 rokov sa do počtu nezapočítavajú!)</span> </span>
                    </v-col>
                  </v-row>

                  <v-divider />

                  <v-row class="m-0">
                    <v-col class="pl-0 pr-0">
                      <v-data-table :headers="headers" :items="prices" class="elevation-0" disable-sort hide-default-header hide-default-footer :mobile-breakpoint="0" @click:row="handleClick">
                        <template v-slot:header="{ props: { headers } }">
                          <thead>
                            <tr>
                              <th v-for="(h, i) in headers" :key="i">
                                <v-tooltip bottom v-if="i != 3">
                                  <template v-slot:activator="{ on }">
                                    <span v-on="on">{{h.text}}</span>
                                  </template>
                                  <span>{{headerTooltips[i - 1]}}</span>
                                </v-tooltip>
                                <span v-if="i == 3">{{h.text}}</span>
                              </th>
                            </tr>
                          </thead>
                        </template>
                      </v-data-table>
                    </v-col>
                  </v-row>

                  <v-dialog v-model="dialogOrderDetail" fullscreen hide-overlay transition="dialog-bottom-transition">
                    <template v-slot:activator="{ on: menu, attrs }">
                      <v-btn align="left" color="orange" elevation="2" v-bind="attrs" v-on="{ ...menu }" medium>
                        <v-icon color="white" medium>mdi-information </v-icon>
                        <span style="color:white" class="font-weight-bold">Detail</span>
                      </v-btn>
                    </template>
                    <v-card>
                      <v-toolbar dark color="primary" class="rounded-0">
                        <!-- extended extension-height="4"  -->
                        <v-btn icon dark @click="dialogOrderDetail = false">
                          <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title class="justify-center">Detail</v-toolbar-title>
                        <!-- <v-progress-linear v-if="toolbarLoading" color="white" style="height:4px" slot="extension" :indeterminate="true"></v-progress-linear> -->
                      </v-toolbar>
                    </v-card>
                  </v-dialog>
                </v-card-text>
              </v-card>

              <!-- <v-btn color="accent" @click="e1 = 1; backStep2(); toTop()" class="mr-2" >
                <v-icon>mdi-arrow-left-thick</v-icon>Krok späť
              </v-btn> -->

              <v-slide-y-transition>
                <v-btn color="accent" class="anim mr-2" @click="e1 = 1; backStep2(); toTop()" outlined>
                  <v-icon class="arrow2">mdi-arrow-left</v-icon>
                  Krok späť
                </v-btn>
              </v-slide-y-transition>

              <v-slide-y-transition>
                <v-btn color="primary" class="anim" @click="checkStatus3(); toTop()">
                  Pokračovať
                  <v-icon class="arrow">mdi-arrow-right</v-icon>
                </v-btn>
              </v-slide-y-transition>
            </v-stepper-content>

            <v-stepper-content step="3">
              <v-card class="rounded" elevation="0">
                <!-- <v-row justify="center">
                <v-col cols="12" sm="12" md="12" lg="6"> -->
                <v-card-text>
                  <v-row justify="center" class="mt-3">
                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="reservation.contactInfos.surname" v-model="reservation.contactInfos.surname" :rules="surnameRules" :error-messages="errorMessages" label="Meno" clearable filled required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="reservation.contactInfos.lastname" v-model="reservation.contactInfos.lastname" :rules="lastnameRules" :error-messages="errorMessages" label="Priezvisko" clearable filled required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <v-text-field ref="reservation.contactInfos.address" v-model="reservation.contactInfos.address" :rules="addressRules" label="Adresa" counter="25" clearable filled required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="reservation.contactInfos.city" v-model="reservation.contactInfos.city" :rules="cityRules" label="Mesto" clearable filled required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="reservation.contactInfos.postcode" v-model="reservation.contactInfos.postcode" :rules="postcodeRules" label="PSČ" clearable filled required></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <v-autocomplete :menu-props="autocompleteMenuProps()" ref="reservation.contactInfos.country" v-model="reservation.contactInfos.country" :rules="countryRules" :items="countries" label="Krajina" clearable filled required>
                      </v-autocomplete>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <VueTelInputVuetify v-model="reservation.details.phone" :rules="myPhoneRules" :preferred-countries="['svk']" :valid-characters-only="true" @input="onInput" label="Mobilné číslo" placeholder="" filled clearable>
                      </VueTelInputVuetify>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <v-textarea v-model="reservation.details.note" :rules="noteRules" label=" Poznámka" rows="1" counter="50" filled clearable>
                      </v-textarea>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>


              <v-slide-y-transition>
                <v-btn color="accent" class="anim mr-2" @click="e1 = 2; backStep3(); toTop()" outlined>
                  <v-icon class="arrow2">mdi-arrow-left</v-icon>
                  Krok späť
                </v-btn>
              </v-slide-y-transition>

              <v-slide-y-transition>
                <v-btn color="primary" class="anim" @click="checkStatus4(); toTop()">
                  Pokračovať
                  <v-icon class="arrow">mdi-arrow-right</v-icon>
                </v-btn>
              </v-slide-y-transition>
            </v-stepper-content>

            <v-stepper-content step="4">
              <v-card class="rounded" elevation="0">
                <v-card-title class="justify-center">Rekapitulácia</v-card-title>
                <v-card-text>
                  <v-row align="center">
                    <v-divider />
                    <span class="font-weight-bold">Kontaktné údaje</span>
                    <v-divider />
                  </v-row>
                  <v-row justify="center">
                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="reservation.contactInfos.surname" v-model="reservation.contactInfos.surname" label="Meno" filled readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="reservation.contactInfos.lastname" v-model="reservation.contactInfos.lastname" label="Priezvisko" filled readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <v-text-field ref="reservation.contactInfos.address" v-model="reservation.contactInfos.address" label="Adresa" filled readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-text-field ref="reservation.contactInfos.city" v-model="reservation.contactInfos.city" label="Mesto" filled readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0">
                      <v-text-field ref="reservation.contactInfos.postcode" v-model="reservation.contactInfos.postcode" label="PSČ" filled readonly></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <v-autocomplete ref="reservation.contactInfos.country" v-model="reservation.contactInfos.country" :items="countries" label="Krajina" filled readonly>
                      </v-autocomplete>
                    </v-col>

                    <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                      <VueTelInputVuetify v-model="reservation.details.phone" label="Mobilné číslo" placeholder="" filled readonly></VueTelInputVuetify>
                    </v-col>

                    <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                      <div v-if="reservation.details.note == null">
                        <v-textarea value="-" label=" Poznámka" rows="1" filled readonly>
                        </v-textarea>
                      </div>
                      <div v-else>
                        <v-textarea v-model="reservation.details.note" label=" Poznámka" rows="1" filled readonly>
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
                            <span>Dátum: {{reservation.details.start_date}}</span>
                          </v-col>
                        </v-row>
                        <v-row class="justify-center">
                          <v-col>
                            <v-icon>mdi-clock-start</v-icon>
                            <span>Čas: {{reservation.details.start_time}}</span>
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
                            <span>Dátum: {{reservation.details.end_date}}</span>
                          </v-col>
                        </v-row>
                        <v-row class="justify-center">
                          <v-col>
                            <v-icon>mdi-clock-end</v-icon>
                            <span>Čas: {{reservation.details.end_time}}</span>
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
                    <v-col class="pl-0 pr-0">
                      <v-data-table :headers="headers" :items="prices" class="elevation-0" disable-sort hide-default-header hide-default-footer :mobile-breakpoint="0" @click:row="handleClick">
                        <template v-slot:header="{ props: { headers } }">
                          <thead>
                            <tr>
                              <th v-for="(h, i) in headers" :key="i">
                                <v-tooltip bottom v-if="i != 3">
                                  <template v-slot:activator="{ on }">
                                    <span v-on="on">{{h.text}}</span>
                                  </template>
                                  <span>{{headerTooltips[i - 1]}}</span>
                                </v-tooltip>
                                <span v-if="i == 3">{{h.text}}</span>
                              </th>
                            </tr>
                          </thead>
                        </template>
                      </v-data-table>
                    </v-col>
                  </v-row>
                  <v-dialog v-model="dialogOrderDetail" fullscreen hide-overlay transition="dialog-bottom-transition">
                    <template v-slot:activator="{ on: menu, attrs }">
                      <v-btn align="left" color="orange" elevation="2" v-bind="attrs" v-on="{ ...menu }" medium>
                        <v-icon color="white" medium>mdi-information </v-icon>
                        <span style="color:white" class="font-weight-bold">Detail</span>
                      </v-btn>
                    </template>
                    <v-card>
                      <v-toolbar dark color="primary" class="rounded-0">
                        <!-- extended extension-height="4"  -->
                        <v-btn icon dark @click="dialogOrderDetail = false">
                          <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title class="justify-center">Detail</v-toolbar-title>
                        <!-- <v-progress-linear v-if="toolbarLoading" color="white" style="height:4px" slot="extension" :indeterminate="true"></v-progress-linear> -->
                      </v-toolbar>
                    </v-card>
                  </v-dialog>
                </v-card-text>
              </v-card>

              <v-slide-y-transition>
                <v-btn color="accent" class="anim mr-2" @click="e1 = 3; backStep4(); toTop()" outlined>
                  <v-icon class="arrow2">mdi-arrow-left</v-icon>
                  Krok späť
                </v-btn>
              </v-slide-y-transition>

              <v-btn color="primary" @click="store()">
                Odoslať rezerváciu<v-icon>mdi-arrow-right-thick</v-icon>
              </v-btn>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
      </v-container>
      <!-- snackbar error in reservation -->
      <v-snackbar v-model="snackbar" :multi-line="multiLine" color="error" bottom left class="m-3">
        <v-icon>mdi-alert-circle</v-icon>
        {{ text }}
        <template v-slot:action="{ attrs }">
          <v-btn color="white" fab text small v-bind="attrs" @click="snackbar = false">
            <v-icon>mdi-close-circle</v-icon>
          </v-btn>
        </template>
      </v-snackbar>
    </v-col>
  </v-row>

  <v-row justify="center" class="m-0" v-else>
    <v-col class="p-0">
      <v-container class="p-0">
        <v-card class="rounded p-3 d-flex align-center w-100" elevation="0" min-height="88vh">
          <v-row class="w-100">
            <v-col cols="12">
              <h1 class="font-weight-bold">Ďakujeme Vám za rezerváciu.</h1>
            </v-col>
            <v-col cols="12">
              <span>Vašu rezerváciu sa budeme snažiť potvrdiť čo najrýchlejšie. Detail Vašej rezervácie je možné si pozrieť v časti Administrácia.</span>
            </v-col>
            <v-col cols="12">
              <v-slide-y-transition>
                <v-btn color="primary" class="anim" to="/administration">
                  <span>Do administrácie</span>
                  <v-icon class="arrow">mdi-arrow-right</v-icon>
                </v-btn>
              </v-slide-y-transition>
            </v-col>
          </v-row>
        </v-card>
      </v-container>
      <!-- snackbar after successfully created reservation -->
      <v-snackbar v-model="snackbarSuccess" :multi-line="multiLine" color="success" bottom left>
        <v-icon>mdi-check-circle</v-icon>
        {{ text }}
        <template v-slot:action="{ attrs }">
          <v-btn color="white" fab text small v-bind="attrs" @click="snackbarSuccess = false">
            <v-icon>mdi-close-circle</v-icon>
          </v-btn>
        </template>
      </v-snackbar>
    </v-col>
  </v-row>
</div>
</template>

<script>
import axios from 'axios'
import moment from 'moment';
import Calendar from "@/components/Calendar.vue";
import VueTelInputVuetify from "vue-tel-input-vuetify/lib/vue-tel-input-vuetify.vue"

export default {
  name: "CreateReservation",
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

      modal1: false,
      modal2: false,

      priceAdults: 18,
      priceChildsto2: 0,
      priceChilds2to12: 18,
      overallPrice: 18,
      cleaningFee: 100,
      priceCabinUnderSixPpl: 150,
      countDaysBetweemTwoDates: null,

      dialogOrderDetail: false,
      //table prices
      headers: [{
          id: 1,
          text: '',
          sortable: false,
          value: 'text',
        },
        {
          id: 2,
          text: 'Počet osôb',
          value: 'p1',
          sortable: false,
        },
        {
          id: 3,
          text: 'Jednotková cena',
          value: 'p2',
          sortable: false,
        },
        {
          id: 4,
          text: 'Cena/noc',
          value: 'p3',
          sortable: false,
        },
        {
          id: 5,
          text: `${'Cena' + this.countDaysBetweemTwoDates + 'noc'}`,
          value: 'p4',
          sortable: false,
        },
      ],
      prices: [],
      headerTooltips: [],

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

      reservation: {
        counter1: 1,
        counter2: 0,
        counter3: 0,
        details: {
          event_name: "rezervácia",
          user_id: this.$root.me.id,
          username: this.$root.me.name,
          start_date: '',
          end_date: '',
          start_time: '',
          end_time: '',
          nights: this.countDaysBetweemTwoDates,
          adults: '',
          childs2to12: '',
          childsto2: '',
          cleaningFee: this.cleaningFee,
          priceForNight: this.priceAdults,
          totalPersons: '',
          overallPrice: this.overallPrice,
          note: '',
        },
        contactInfos: {
          reservation_id: '',
          user_id: '',
          surname: '',
          lastname: '',
          address: '',
          city: '',
          postcode: '',
          country: '',
          phone: '',
        },
      },

      phone: {
        number: '',
        valid: false,
        country: undefined,
      },
      formHasErrors: false,

      surnameRules: [
        v => !!v || 'Meno je povinné',
        v => (v && v.length <= 10) || 'Meno musí obsahovať max 10 znakov',
      ],

      lastnameRules: [
        v => !!v || 'Priezvisko je povinné',
      ],

      addressRules: [
        v => !!v || 'Adresa je povinná',
      ],

      cityRules: [
        v => !!v || 'Mesto je povinné',
      ],

      postcodeRules: [
        v => !!v || 'PSČ je povinné',
      ],

      countryRules: [
        v => !!v || 'Krajina je povinná',
      ],

      myPhoneRules: [
        v => !!v || 'Mobilné číslo je povinné',
      ],

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
      overlay: true,
      successCreatedReservation: false,
    }
  },

  mounted() {
    const api = `${process.env.VUE_APP_API_URL}/getContactForm`;
    const config = {
      headers: {
        Accept: "application/json",
        // 'Content-Type': 'multipart/form-data',
        Authorization: "Bearer " + localStorage.getItem("authToken"),
      },
    };
    axios.get(api, config)
      .then(res => {
        if (res.data.length != 0) {
          this.reservation.contactInfos.surname = res.data[0].surname;
          this.reservation.contactInfos.lastname = res.data[0].lastname;
          this.reservation.contactInfos.address = res.data[0].address;
          this.reservation.contactInfos.city = res.data[0].city;
          this.reservation.contactInfos.postcode = res.data[0].postcode;
          this.reservation.contactInfos.country = res.data[0].country;
          this.reservation.details.phone = res.data[0].phone;
        }
      });

    const api2 = `${process.env.VUE_APP_API_URL}/checkPendingReservation/${localStorage.getItem('username')}`;
    axios.get(api2, config)
      .then(res => {
        this.$store.dispatch('pendingReservation', {
          count: res.data
        });
      });

    const api3 = `${process.env.VUE_APP_API_URL}/checkContactForm`;
    axios.get(api3, config)
      .then(res => {
        this.rowContactForm = res.data;
      });
  },

  methods: {
    toTop() {
      this.$vuetify.goTo(0);
    },

    loadedEvents(events) {
      this.overlay = events;
    },

    arrayDates(dates) {
      this.reservation.details.start_date = moment(dates[0])
        .format("YYYY-MM-DD");
      this.reservation.details.end_date = moment(dates[1])
        .format("YYYY-MM-DD");
      this.reservation.details.start_time = moment(dates[0])
        .format('HH:mm:ss');
      this.reservation.details.end_time = moment(dates[1])
        .format('HH:mm:ss');
    },

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
        this.countingPrices();
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
      if (this.reservation.counter1 == 0 && this.reservation.counter2 == 0 && this.reservation.counter3 == 0) {
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
        const api = `${process.env.VUE_APP_API_URL}/contactForm`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };
        axios.post(api, {
              surname: this.reservation.contactInfos.surname,
              lastname: this.reservation.contactInfos.lastname,
              address: this.reservation.contactInfos.address,
              city: this.reservation.contactInfos.city,
              postcode: this.reservation.contactInfos.postcode,
              country: this.reservation.contactInfos.country,
              phone: this.phone.number,
            },
            config
          )
          .then(() => {})
      }
      this.step3 = true;
      this.e1 = 4;
    },

    checkStatus4() {
      if (
        this.reservation.contactInfos.surname == null ||
        this.reservation.contactInfos.lastname == null ||
        this.reservation.contactInfos.address == null ||
        this.reservation.contactInfos.city == null ||
        this.reservation.contactInfos.postcode == null ||
        this.reservation.contactInfos.country == null ||
        this.reservation.details.phone == null
      ) {
        this.step3 = false;
        this.snackbar = true;
        this.text = "Je potrebné vyplniť kontaktné údaje!";
      } else {
        if (this.rowContactForm == "0") {
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
      if (this.reservation.counter1 + this.reservation.counter2 < 20) {
        if (this.reservation.counter1 < 20) {
          this.reservation.counter1++;
          this.countingPrices();
        }
      } else {
        this.snackbar = true;
        this.text = `Je zvolený maximálny počet osôb (${this.reservation.counter1+this.reservation.counter2})`;
      }
    },
    decrementValue1() {
      if (this.reservation.counter1 > 1) {
        this.reservation.counter1--;
        this.countingPrices();
      }
    },
    resetValue1() {
      this.reservation.counter1 = 1;
      this.countingPrices();
    },

    incrementValue2() {
      if (this.reservation.counter1 + this.reservation.counter2 < 20) {
        if (this.reservation.counter2 < 20) {
          this.reservation.counter2++;
          this.countingPrices();
        }
      } else {
        this.snackbar = true;
        this.text = `Je zvolený maximálny počet osôb (${this.reservation.counter1+this.reservation.counter2})`;
      }
    },
    decrementValue2() {
      if (this.reservation.counter2 > 0) {
        this.reservation.counter2--;
        this.countingPrices();
      }
    },
    resetValue2() {
      this.reservation.counter2 = 0;
      this.countingPrices();
    },

    incrementValue3() {
      if (this.reservation.counter3 < 20) {
        this.reservation.counter3++;
        this.countingPrices();
      }
    },
    decrementValue3() {
      if (this.reservation.counter3 > 0) {
        this.reservation.counter3--;
        this.countingPrices();
      }
    },
    resetValue3() {
      this.reservation.counter3 = 0;
      this.countingPrices();
    },

    handleClick(row) {
      console.log(row);
    },


    headerTooltipsConfig() {
      this.headerTooltips = [];
      this.headerTooltips.push('Maximálny počet osôb je 20!');

      if (this.reservation.counter1 + this.reservation.counter2 > 5) {
        this.headerTooltips.push('Cena za osobu na noc');
        this.headerTooltips.push('');
      } else {
        this.headerTooltips.push('Cena za celú chatu na 1 noc pri počte osôb <6');
        this.headerTooltips.push('');
      }
      this.headerTooltips.push(`${'Od ' + this.reservation.details.start_date + ' do ' + this.reservation.details.end_date}`);
    },

    countingPrices() {
      // this.headerTooltipsConfig();
      this.headerTooltips = [];
      this.headerTooltips.push('Maximálny počet osôb je 20!');

      if (this.reservation.counter1 + this.reservation.counter2 > 5) {
        this.headerTooltips.push('Cena za osobu na noc');
        this.headerTooltips.push('');
      } else {
        this.headerTooltips.push('Cena za celú chatu na 1 noc pri počte osôb <6');
        this.headerTooltips.push('');
      }
      this.headerTooltips.push(`${'Od ' + this.reservation.details.start_date + ' do ' + this.reservation.details.end_date}`);

      this.prices = [];
      if (this.reservation.counter1 + this.reservation.counter2 > 5) {
        if (this.reservation.counter2 > 0) {
          this.prices.splice(1, 0, {
            text: 'Deti od 2 do 12 rokov',
            p1: this.reservation.counter2,
            p2: this.priceChilds2to12 + '€',
            p3: this.reservation.counter2 * this.priceChilds2to12 + '€',
            p4: this.reservation.counter2 * this.priceChilds2to12 * this.countDaysBetweemTwoDates + '€',
          });
        }
        if (this.reservation.counter3 > 0) {
          this.prices.splice(2, 0, {
            text: 'Deti do 2 rokov',
            p1: this.reservation.counter3,
            p2: this.priceChildsto2 + '€',
            p3: this.reservation.counter3 * this.priceChildsto2 + '€',
            p4: this.reservation.counter3 * this.priceChildsto2 * this.countDaysBetweemTwoDates + '€',
          });
        }
        this.prices.splice(0, 0, {
          text: 'Dospelí',
          p1: this.reservation.counter1,
          p2: this.priceAdults + '€',
          p3: this.reservation.counter1 * this.priceAdults + '€',
          p4: this.reservation.counter1 * this.priceAdults * this.countDaysBetweemTwoDates + '€',
        });

        this.prices.push({
          text: 'Upratovanie',
          p1: '',
          p2: '',
          p3: '',
          p4: this.cleaningFee + '€',
        }, {
          text: 'Spolu',
          p1: this.reservation.counter1 + this.reservation.counter2 + this.reservation.counter3,
          p2: ((this.reservation.counter1 * this.priceAdults) / this.reservation.counter1) + ((this.reservation.counter2 * this.priceChilds2to12) / this.reservation.counter2 || 0) + ((this.reservation.counter3 * this.priceChildsto2) / this
            .reservation.counter3 || 0) + '€',
          p3: this.reservation.counter1 * this.priceAdults + this.reservation.counter2 * this.priceChilds2to12 + this.reservation.counter3 * this.priceChildsto2 + '€',
          p4: this.reservation.counter1 * this.priceAdults * this.countDaysBetweemTwoDates + this.reservation.counter2 * this.priceChilds2to12 * this.countDaysBetweemTwoDates + this.reservation.counter3 * this.priceChildsto2 * this
            .countDaysBetweemTwoDates + this.cleaningFee + '€',
        });
      } else {
        this.prices.push({
          text: 'Cena za celú chatu (<6 osôb)',
          p1: this.reservation.counter1 + this.reservation.counter2,
          p2: this.priceCabinUnderSixPpl + '€',
          p3: this.priceCabinUnderSixPpl + '€',
          p4: this.priceCabinUnderSixPpl * this.countDaysBetweemTwoDates + '€',
        }, {
          text: 'Upratovanie',
          p1: '',
          p2: '',
          p3: '',
          p4: this.cleaningFee + '€',
        }, {
          text: 'Spolu',
          p1: this.reservation.counter1 + this.reservation.counter2 + this.reservation.counter3,
          p2: this.priceCabinUnderSixPpl + '€',
          p3: this.priceCabinUnderSixPpl + '€',
          p4: (this.priceCabinUnderSixPpl * this.countDaysBetweemTwoDates) + this.cleaningFee + '€',
        });
      }
    },

    getUncheckedReservations() {
      const api = `${process.env.VUE_APP_API_URL}/reservation/getUncheckedReservationsUser`;

      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      //reservations counter
      axios.get(api, config)
        .then(res => {
          this.$store.dispatch('reservationCounter', {
            reservCounter: res.data
          });
        });
    },

    store() {
      this.overlay = true;
      if (this.step1 && this.step2 && this.step3 && this.step4) {
        const api = `${process.env.VUE_APP_API_URL}/reservation/store`;
        const config = {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + localStorage.getItem("authToken"),
          },
        };

        axios.post(api, {
            event_name: "rezervácia",
            user_id: this.$root.me.id,
            username: this.$root.me.name,
            start_date: this.reservation.details.start_date,
            end_date: this.reservation.details.end_date,
            start_time: this.reservation.details.start_time,
            end_time: this.reservation.details.end_time,
            nights: this.countDaysBetweemTwoDates,
            adults: this.reservation.counter1,
            childs2to12: this.reservation.counter2,
            childsto2: this.reservation.counter3,
            cleaningFee: this.cleaningFee,
            priceForNight: this.priceAdults,
            totalPersons: this.reservation.counter1 + this.reservation.counter2 + this.reservation.counter3,
            overallPrice: this.overallPrice,
            note: this.reservation.details.note
          }, config)
          .then(res => {
            console.log(res.data);
            this.getUncheckedReservations();

            const api = `${process.env.VUE_APP_API_URL}/reservation/reservationUserContactInfo`;
            const api2 = `${process.env.VUE_APP_API_URL}/sendNotification`;
            const config = {
              headers: {
                Accept: "application/json",
                Authorization: "Bearer " + localStorage.getItem("authToken"),
              },
            };

            axios.post(api, {
                  reservation_id: res.data[0].id,
                  user_id: res.data[0].user_id,
                  surname: this.reservation.contactInfos.surname,
                  lastname: this.reservation.contactInfos.lastname,
                  address: this.reservation.contactInfos.address,
                  city: this.reservation.contactInfos.city,
                  postcode: this.reservation.contactInfos.postcode,
                  country: this.reservation.contactInfos.country,
                  phone: this.reservation.details.phone,
                },
                config
              )
              .then(() => {})

            //notif to user that he successfully created his reservation
            axios.post(api2, {
                from: 1,
                recipient: this.$root.me.id,
                title: "Chata Byšta",
                subtitle: "Úspešne vytvorenie rezervácie",
                text: `Vážený ${localStorage.getItem('username')}, rezervácia bola úspešne vytvorená a čaká sa na jej potvrdenie. Stav Vašej rezervácie môžete sledovať v časti 'Administrácia'. `,
                date: moment(new Date())
                  .format('YYYY-MM-DD HH:mm'),
                status: "new",
              }, config)
              .then(() => {})

            //notif to admin that any user made new reservation
            axios.post(api2, {
                from: this.$root.me.id,
                recipient: 1,
                title: "Nová rezervácia",
                subtitle: "Nová rezervácia",
                text: `Používateľ ${this.$root.me.name} vytvoril rezerváciu.`,
                date: moment(new Date())
                  .format('YYYY-MM-DD HH:mm'),
                status: "new",
              }, config)
              .then(() => {})
            this.snackbarSuccess = true;
            this.successCreatedReservation = true;
            this.overlay = false;
            this.text = "Rezervácia bola úspešne vytvorená!";

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
        address: this.reservation.contactInfos.address,
        city: this.reservation.contactInfos.city,
        state: this.state,
        zip: this.zip,
        country: this.reservation.contactInfos.country,
      }
    },
  },

  watch: {
    name() {
      this.errorMessages = ''
    },
    reservation: {
      handler: function() {
        console.log("change");
      },
      deep: true
    },
  },

  created() {
    //add text that user was sucessfully registered
    // console.log(this.$store.getters['successMakeReservation'].success)
    // this.step1 = this.$store.getters['successMakeReservation'].success
  },

  updated() {
    //do something after updating vue instance
    this.countDaysBetweemTwoDates = moment(this.reservation.details.end_date, 'YYYY-MM-DD')
      .diff(moment(this.reservation.details.start_date, 'YYYY-MM-DD'), 'days');
    if (this.countDaysBetweemTwoDates > 1) {
      this.headers[4].text = 'Cena/' + this.countDaysBetweemTwoDates + 'noci';
    } else {
      this.headers[4].text = 'Cena/' + this.countDaysBetweemTwoDates + 'noc';
    }

    if (this.reservation.counter1 + this.reservation.counter2 > 5) {
      this.overallPrice = this.cleaningFee + this.reservation.counter1 * this.priceAdults * this.countDaysBetweemTwoDates + this.reservation.counter2 * this.priceChilds2to12 * this.countDaysBetweemTwoDates + this.reservation.counter3 * this
        .priceChildsto2 * this
        .countDaysBetweemTwoDates;
    } else {
      this.overallPrice = (this.priceCabinUnderSixPpl * this.countDaysBetweemTwoDates) + this.cleaningFee;
    }
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

.theme--dark.v-stepper {
    background-color: #1E1E1E !important;
}
.v-stepper {
    box-shadow: none !important;
}

// .v-stepper__step {
//     padding: 0 !important;
// }

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
