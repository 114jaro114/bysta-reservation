<template>
<div class="moje_rezervacie">
  <v-overlay :value="overlay">
    <v-progress-circular indeterminate size="64"></v-progress-circular>
  </v-overlay>

  <v-container>
    <v-row justify="center" class="m-0">
      <v-col class="p-0">
        <v-card class="rounded" elevation="0">
          <v-toolbar class="reservationtoolbar rounded-top" color="primary" flat dark>
            <!-- extended extension-height="4"  -->
            <v-col cols="12" xs="12" sm="12" md="4" lg="6" xl="6" class="pl-0 pr-0">
              <v-text-field v-model="search" append-icon="mdi-magnify" label="Vyhľadať" single-line hide-details filled rounded dense clearable></v-text-field>
            </v-col>
            <v-col cols="12" xs="12" sm="12" md="4" lg="6" xl="6" class="pl-0 pr-0" v-if="user == 'admin'">
              <v-btn text color="white" dark @click="dialog = !dialog"> Nová rezervácia </v-btn>
            </v-col>
          </v-toolbar>

          <v-data-table :mobile-breakpoint="0" no-data-text="Nenašli sa žiadne rezervácie" no-results-text="Nenašli sa žiadne rezervácie" :header-props="headerProps" :footer-props="footerProps" :headers="headers" :items="currentEvents"
            :search="search" v-if="user == 'admin'" item-key="title" loading-text="Načítavanie... Prosím počkajte">
            <!-- admin edit reservation -->
            <template v-slot:top>
              <v-row justify="center">
                <v-col cols="12" xs="12" sm="12" md="4" lg="6" xl="6">
                  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition" persistent>
                    <v-card>
                      <v-toolbar class="rounded-top" color="primary" flat tile dark>
                        <v-btn icon dark @click="dialog = false">
                          <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title class="justify-center">Editácia rezervácie</v-toolbar-title>
                        <v-spacer />
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on: tooltip }">
                            <v-btn v-on="tooltip" icon dark @click="save" :loading="adminEditReservationLoader">
                              <v-icon>mdi-content-save-all</v-icon>
                            </v-btn>
                          </template>
                          <span>Uložiť zmeny</span>
                        </v-tooltip>
                      </v-toolbar>
                      <!-- start admin edit reservation -->
                      <v-container v-if="adminEditReservation != null">
                        <v-list class="p-0">
                          <v-subheader class="p-0">Status Rezervácie</v-subheader>
                          <v-list-item class="p-0">
                            <v-list-item-content class="pt-0 pb-0">
                              <v-row>
                                <v-col class="d-flex pb-0" cols="12" sm="12">
                                  <v-select :items="items" item-text="items" class="select-stat-reserv" label="Status" v-model="adminEditReservation.event_name" chips clearable filled rounded required small-chips>
                                    <!--  -->
                                    <template v-slot:selection="{ item }">
                                      <v-chip :color="getColor(item)" dark v-if="item == 'rezervácia'">
                                        <v-icon class="pr-1" small>mdi-clock</v-icon> <span>Čaká sa</span>
                                      </v-chip>
                                      <v-chip :color="getColor(item)" dark v-else>
                                        <v-icon class="pr-1" small>mdi-check-circle</v-icon> <span>Akceptované</span>
                                      </v-chip>
                                    </template>
                                    <template v-slot:item="{ item }">
                                      <v-chip :color="getColor(item)" dark v-if="item == 'rezervácia'">
                                        <v-icon class="pr-1" small>mdi-clock</v-icon> <span>Čaká sa</span>
                                      </v-chip>
                                      <v-chip :color="getColor(item)" dark v-else>
                                        <v-icon class="pr-1" small>mdi-check-circle</v-icon> <span>Akceptované</span>
                                      </v-chip>
                                    </template>
                                  </v-select>
                                </v-col>
                              </v-row>
                            </v-list-item-content>
                          </v-list-item>
                        </v-list>

                        <v-divider></v-divider>

                        <v-list class="pt-0 pb-0" three-line subheader>
                          <v-subheader class="p-0">Zmeniť dátum a čas rezervácie</v-subheader>
                          <v-list-item class="p-0">
                            <v-list-item-content class="pt-0 pb-0">
                              <v-row>
                                <v-col class="pb-0" cols="12" sm="6">
                                  <v-menu v-model="menuStartDate" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                      <v-text-field v-model="adminEditReservation.start_date" label="Dátum začiatku" prepend-icon="mdi-calendar-start" readonly clearable filled rounded required v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker id="start_date" name="start_date" v-model="adminEditReservation.start_date" @input="menuStartDate = false"></v-date-picker>
                                  </v-menu>
                                </v-col>
                                <v-col class="pb-0" cols="12" sm="6">
                                  <v-menu v-model="menuEndDate" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                      <v-text-field v-model="adminEditReservation.end_date" label="Dátum konca" prepend-icon="mdi-calendar-end" readonly clearable filled rounded required v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker id="end_date" name="end_date" v-model="adminEditReservation.end_date" @input="menuEndDate = false"></v-date-picker>
                                  </v-menu>
                                </v-col>

                                <v-col class="pb-0" cols="12" sm="6">
                                  <v-menu v-model="menuStartTime" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                      <v-text-field v-model="adminEditReservation.start_time" label="Dátum začiatku" prepend-icon="mdi-clock-start" readonly clearable filled rounded required v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-time-picker id="start_date" name="start_date" v-model="adminEditReservation.start_time" @input="menuStartTime = false"></v-time-picker>
                                  </v-menu>
                                </v-col>
                                <v-col class="pb-0" cols="12" sm="6">
                                  <v-menu v-model="menuEndTime" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                      <v-text-field v-model="adminEditReservation.end_time" label="Dátum konca" prepend-icon="mdi-clock-end" readonly clearable filled rounded required v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-time-picker id="end_date" name="end_date" v-model="adminEditReservation.end_time" @input="menuEndTime = false"></v-time-picker>
                                  </v-menu>
                                </v-col>
                              </v-row>
                            </v-list-item-content>
                          </v-list-item>
                        </v-list>

                        <v-divider></v-divider>

                        <v-list class="pb-0" three-line subheader>
                          <v-subheader class="p-0">Kontaktné údaje</v-subheader>
                          <v-list-item class="p-0">
                            <v-list-item-content class="pb-0">
                              <v-row justify="center">
                                <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                                  <v-text-field ref="surname" v-model="adminEditReservation.usercontactmodel.surname" :rules="surnameRules" label="Meno" clearable filled rounded required></v-text-field>
                                </v-col>

                                <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                                  <v-text-field ref="lastname" v-model="adminEditReservation.usercontactmodel.lastname" :rules="lastnameRules" label="Priezvisko" clearable filled rounded required></v-text-field>
                                </v-col>

                                <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                                  <v-text-field ref="address" v-model="adminEditReservation.usercontactmodel.address" :rules="addressRules" label="Adresa" clearable filled rounded required></v-text-field>
                                </v-col>

                                <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                                  <v-text-field ref="city" v-model="adminEditReservation.usercontactmodel.city" :rules="cityRules" label="Mesto" clearable filled rounded required></v-text-field>
                                </v-col>

                                <v-col cols="12" sm="12" md="6" lg="6" class="pt-0">
                                  <v-text-field ref="postcode" v-model="adminEditReservation.usercontactmodel.postcode" :rules="postcodeRules" label="PSČ" clearable filled rounded required></v-text-field>
                                </v-col>

                                <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                                  <!-- <v-select ref="country" v-model="adminEditReservation.usercontactmodel.country" :rules="countryRules" :items="countries"  label="Krajina" clearable filled rounded required> -->
                                  <!-- <template v-slot:selection="{ item }">
                                      <CountryFlag :country="item.alpha2" size='normal' />
                                      <span class="mr-2">{{item.en}}</span>
                                    </template>
                                    <template v-slot:item="{ item }">
                                      <CountryFlag :country="item.alpha2" size='normal' />
                                      <span class="mr-2">{{item.en}}</span>
                                    </template> -->
                                  <!-- </v-select> -->

                                  <v-autocomplete ref="country" v-model="adminEditReservation.usercontactmodel.country" :rules="countryRules" :items="countries" label="Krajina" clearable filled rounded required>
                                    <template v-slot:selection="{ item }">
                                      {{item}}
                                    </template>
                                    <template v-slot:item="{ item }">
                                      {{item}}
                                    </template>
                                  </v-autocomplete>
                                </v-col>

                                <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                                  <VueTelInputVuetify class="mobpho" v-model="adminEditReservation.usercontactmodel.phone" :rules="myPhoneRules" label="Mobilné číslo" placeholder="" clearable filled rounded required></VueTelInputVuetify>
                                </v-col>

                                <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                                  <div v-if="adminEditReservation.note  == null">
                                    <v-textarea value="-" label=" Poznámka" rows="1" readonly filled rounded required auto-grow>
                                    </v-textarea>
                                  </div>
                                  <div v-else>
                                    <v-textarea v-model="adminEditReservation.note" :rules="noteRules" label=" Poznámka" rows="1" readonly filled rounded required auto-grow>
                                    </v-textarea>
                                  </div>
                                </v-col>
                              </v-row>
                            </v-list-item-content>
                          </v-list-item>
                        </v-list>

                        <v-divider></v-divider>

                        <v-list three-line subheader>
                          <v-subheader class="p-0">Dátum a čas vytvorenia rezervácie</v-subheader>
                          <v-list-item class="p-0">
                            <v-list-item-content>
                              <v-row>
                                <v-col cols="12">
                                  <v-card class="p-4 card-color-administration rounded-pill" flat>
                                    <v-row class="justify-center">
                                      <v-col>
                                        <v-icon>mdi-calendar-clock</v-icon>
                                        <span class="pl-1">{{formatCreated(adminEditReservation.created_at)}}</span>
                                      </v-col>
                                    </v-row>
                                  </v-card>
                                </v-col>
                              </v-row>
                            </v-list-item-content>
                          </v-list-item>

                          <v-subheader class="p-0">Dátum a čas príchodu a odchodu</v-subheader>
                          <v-list-item class="p-0">
                            <v-list-item-content>
                              <v-row>
                                <v-col cols="12" lg="6" md="6">
                                  <v-card class="p-4 card-color-administration rounded-pill" flat>
                                    <v-row class="justify-center">
                                      <span>Príchod</span>
                                    </v-row>
                                    <v-row class="justify-center">
                                      <v-col>
                                        <v-icon>mdi-calendar-start</v-icon>
                                        <span class="pl-1">{{formatDate(adminEditReservation.start_date)}}</span>
                                      </v-col>
                                    </v-row>
                                    <v-row class="justify-center">
                                      <v-col>
                                        <v-icon>mdi-clock-start</v-icon>
                                        <span class="pl-1">{{adminEditReservation.start_time}}</span>
                                      </v-col>
                                    </v-row>
                                  </v-card>
                                </v-col>
                                <v-col cols="12" lg="6" md="6">
                                  <v-card class="p-4 card-color-administration rounded-pill" flat>
                                    <v-row class="justify-center">
                                      <span>Odchod</span>
                                    </v-row>
                                    <v-row class="justify-center">
                                      <v-col>
                                        <v-icon>mdi-calendar-end</v-icon>
                                        <span class="pl-1">{{formatDate(adminEditReservation.end_date)}}</span>
                                      </v-col>
                                    </v-row>
                                    <v-row class="justify-center">
                                      <v-col>
                                        <v-icon>mdi-clock-end</v-icon>
                                        <span class="pl-1">{{adminEditReservation.end_time}}</span>
                                      </v-col>
                                    </v-row>
                                  </v-card>
                                </v-col>
                              </v-row>
                            </v-list-item-content>
                          </v-list-item>
                        </v-list>

                        <v-divider></v-divider>

                        <v-list three-line subheader>
                          <v-subheader class="p-0">Zmena počtu osôb</v-subheader>
                          <v-row class="m-0">
                            <v-col class="p-0 pr-lg-4" cols="12" sm="12" md="12" lg="4">
                              <v-row class="m-0">
                                <span>Dospelí</span>
                              </v-row>

                              <v-row class="ml-0 mr-0">
                                <v-btn class="mr-2 mt-1" fab dark x-small color="primary" @click="decrement('adults')">
                                  <v-icon dark>
                                    mdi-minus
                                  </v-icon>
                                </v-btn>
                                <v-text-field style="width: 70px" class="counter" v-model="adminEditReservation.adults" placeholder="" filled rounded dense></v-text-field>
                                <v-btn class="mx-2 mt-1" fab dark x-small color="primary" @click="increment('adults')">
                                  <v-icon dark>
                                    mdi-plus
                                  </v-icon>
                                </v-btn>
                                <v-btn style="margin-top: 6px" rounded small outlined color="error" @click="reset('adults')">
                                  <span class="font-weight-bold text-uppercase">reset</span>
                                </v-btn>
                              </v-row>
                            </v-col>

                            <v-col class="p-0 pl-lg-2 pr-lg-2" cols="12" sm="12" md="12" lg="4">
                              <v-row class="m-0">
                                <span>Deti od 2 do 12 rokov</span>
                              </v-row>

                              <v-row class="ml-0 mr-0">
                                <v-btn class="mr-2 mt-1" fab dark x-small color="primary" @click="decrement('childs_2_to_12')">
                                  <v-icon dark>
                                    mdi-minus
                                  </v-icon>
                                </v-btn>
                                <v-text-field style="width: 70px" v-model="adminEditReservation.childs_2_to_12" placeholder="" filled rounded dense></v-text-field>
                                <v-btn class="mx-2 mt-1" fab dark x-small color="primary" @click="increment('childs_2_to_12')">
                                  <v-icon dark>
                                    mdi-plus
                                  </v-icon>
                                </v-btn>
                                <v-btn style="margin-top: 6px" rounded small outlined color="error" @click="reset('childs_2_to_12')">
                                  <span class="font-weight-bold text-uppercase">reset</span>
                                </v-btn>
                              </v-row>
                            </v-col>

                            <v-col class="p-0 pl-lg-4" cols="12" sm="12" md="12" lg="4">
                              <v-row class="m-0">
                                <span>Deti do 2 rokov</span>
                              </v-row>

                              <v-row class="ml-0 mr-0">
                                <v-btn class="mr-2 mt-1" fab dark x-small color="primary" @click="decrement('childs_to_2')">
                                  <v-icon dark>
                                    mdi-minus
                                  </v-icon>
                                </v-btn>
                                <v-text-field style="width: 70px" class="counter" v-model="adminEditReservation.childs_to_2" placeholder="" filled rounded dense></v-text-field>
                                <v-btn class="mx-2 mt-1" fab dark x-small color="primary" @click="increment('childs_to_2')">
                                  <v-icon dark>
                                    mdi-plus
                                  </v-icon>
                                </v-btn>
                                <v-btn style="margin-top: 6px" rounded small outlined color="error" @click="reset('childs_to_2')">
                                  <span class="font-weight-bold text-uppercase">reset</span>
                                </v-btn>
                              </v-row>
                            </v-col>
                          </v-row>
                        </v-list>

                        <v-divider></v-divider>

                        <v-list three-line subheader>
                          <v-subheader class="p-0">Suma rezervácie</v-subheader>
                          <v-row class="m-0 mt-3">
                            <v-col class="pl-0 pr-0" align="left">
                              <v-icon class="mb-1" color="orange">mdi-information</v-icon>
                              <span class="ml-1">Deti do 2 rokov sa do počtu hostí nezapočítavajú.</span>
                            </v-col>
                          </v-row>
                          <v-data-table :headers="headersDetail" :items="prices" class="elevation-0" disable-sort hide-default-header hide-default-footer :mobile-breakpoint="0">
                            <template v-slot:header="{ props: { headers } }">
                              <thead>
                                <tr>
                                  <th v-for="(h, i) in headers" :key="i">
                                    <v-tooltip bottom v-if="i != 3">
                                      <template v-slot:activator="{ on }">
                                        <span v-on="on">{{h.text}}</span>
                                      </template>
                                      <span>{{headerDetailTooltips[i - 1]}}</span>
                                    </v-tooltip>
                                    <span v-if="i == 3">{{h.text}}</span>
                                  </th>
                                </tr>
                              </thead>
                            </template>
                          </v-data-table>
                        </v-list>
                      </v-container>
                    </v-card>
                  </v-dialog>
                  <!-- end admin update reservation -->

                  <!-- start admin delete reservation -->
                  <v-dialog v-model="dialogDelete" max-width="500px" persistent>
                    <v-card>
                      <v-toolbar class="rounded-top" color="primary" flat dark tile justify="center">
                        <v-toolbar-title>Naozaj chcete zmazať rezerváciu?</v-toolbar-title>
                      </v-toolbar>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" text @click="dialogDelete = false">Zatvoriť</v-btn>
                        <v-btn color="error" outlined @click="deleteItemConfirm(adminEditReservation)">Áno</v-btn>
                        <v-spacer></v-spacer>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  <!-- end admin delete reservation -->
                </v-col>
              </v-row>
            </template>

            <template v-slot:item.start_date="{ item }">
              <span>{{ formatDate(item.start_date) }}</span>
            </template>

            <template v-slot:item.end_date="{ item }">
              <span>{{ formatDate(item.end_date) }}</span>
            </template>

            <template v-slot:item.event_name="{ item }">
              <v-chip :color="getColor(item.event_name)" dark v-if="item.event_name == 'rezervácia'" small>
                <v-icon class="pr-1" small>mdi-clock</v-icon> <span>Čaká sa</span>
              </v-chip>
              <v-chip :color="getColor(item.event_name)" dark v-else small>
                <v-icon class="pr-1" small>mdi-check-circle</v-icon> <span>Akceptované</span>
              </v-chip>
            </template>

            <template v-slot:item.username="{ item }">
              <v-chip dark small>
                <v-icon left class="mr-1" small>mdi-account-circle-outline</v-icon>{{item.username}}
              </v-chip>
            </template>

            <template v-slot:item.overall_price="{ item }">
              <span>{{item.overall_price}} €</span>
            </template>

            <template v-slot:item.actions="{ item }">
              <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
              <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
            </template>
          </v-data-table>
          <!-- end table for admin -->

          <!-- start table for users -->
          <v-data-table :mobile-breakpoint="0" no-data-text="Nenašli sa žiadne rezervácie" no-results-text="Nenašli sa žiadne rezervácie" :header-props="headerProps" :footer-props="footerProps" :headers="headers2" :items="currentEvents"
            :search="search" item-key="name" loading-text="Načítavanie... Prosím počkajte" v-else>
            <!-- reservation detail for users only-->
            <template v-slot:top>
              <v-dialog v-model="dialogShowDetail" fullscreen hide-overlay transition="dialog-bottom-transition" persistent>
                <v-card>
                  <v-toolbar extended extension-height="4" color="primary" class="rounded-0" flat dark>
                    <v-btn icon dark @click="dialogShowDetail = false">
                      <v-icon>mdi-close</v-icon>
                    </v-btn>
                    <v-toolbar-title class="justify-center">Detail rezervácie</v-toolbar-title>
                  </v-toolbar>
                  <v-container v-if="userDetailReservation != null">

                    <v-list class="pb-0" three-line subheader>
                      <v-subheader class="p-0">Status rezervácie</v-subheader>
                      <v-list-item class="p-0">
                        <v-list-item-content class="pb-0 pt-0">
                          <v-btn class="card-color-administration p-3" :color="getColor(userDetailReservation.event_name)" block rounded large>
                            <span :color="getColor(userDetailReservation.event_name)" dark v-if="userDetailReservation.event_name == 'rezervácia'" large>
                              <v-icon class="pr-1" small>mdi-clock</v-icon> <span>Čaká sa</span>
                            </span>
                            <span :color="getColor(userDetailReservation.event_name)" dark v-else large>
                              <v-icon class="pr-1" small>mdi-check-circle</v-icon> <span>Akceptované</span>
                            </span>
                          </v-btn>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list class="pb-0" three-line subheader>
                      <v-subheader class="p-0">Kontaktné údaje</v-subheader>
                      <v-list-item class="p-0">
                        <v-list-item-content class="pb-0">
                          <v-row justify="center">
                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <v-text-field ref="surname" v-model="userDetailReservation.usercontactmodel.surname" label="Meno" readonly filled rounded></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <v-text-field ref="lastname" v-model="userDetailReservation.usercontactmodel.lastname" label="Priezvisko" readonly filled rounded></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                              <v-text-field ref="address" v-model="userDetailReservation.usercontactmodel.address" label="Adresa" readonly filled rounded></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <v-text-field ref="city" v-model="userDetailReservation.usercontactmodel.city" label="Mesto" readonly filled rounded></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0">
                              <v-text-field ref="postcode" v-model="userDetailReservation.usercontactmodel.postcode" label="PSČ" readonly filled rounded></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <v-text-field ref="country" v-model="userDetailReservation.usercontactmodel.country" label="Krajina" readonly filled rounded>
                              </v-text-field>
                            </v-col>

                            <v-col cols="12" sm="12" md="6" lg="6" class="pt-0 pb-0">
                              <VueTelInputVuetify class="mobpho" v-model="userDetailReservation.usercontactmodel.phone" label="Mobilné číslo" placeholder="" disabled readonly filled rounded></VueTelInputVuetify>
                            </v-col>

                            <v-col cols="12" sm="12" md="12" lg="12" class="pt-0 pb-0">
                              <div v-if="userDetailReservation.note  == null">
                                <v-textarea value="-" label=" Poznámka" rows="1" readonly filled rounded auto-grow>
                                </v-textarea>
                              </div>
                              <div v-else>
                                <v-textarea v-model="userDetailReservation.note " label=" Poznámka" rows="1" readonly filled rounded auto-grow>
                                </v-textarea>
                              </div>
                            </v-col>
                          </v-row>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list three-line subheader>
                      <v-subheader class="p-0">Dátum a čas vytvorenia rezervácie</v-subheader>
                      <v-list-item class="p-0">
                        <v-list-item-content>
                          <v-row>
                            <v-col cols="12">
                              <v-card class="p-4 card-color-administration rounded-pill" flat>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-calendar-clock</v-icon>
                                    <span class="pl-1">{{formatCreated(userDetailReservation.created_at)}}</span>
                                  </v-col>
                                </v-row>
                              </v-card>
                            </v-col>
                          </v-row>
                        </v-list-item-content>
                      </v-list-item>

                      <v-subheader class="p-0">Dátum a čas príchodu a odchodu</v-subheader>
                      <v-list-item class="p-0">
                        <v-list-item-content>
                          <v-row>
                            <v-col cols="12" lg="6" md="6">
                              <v-card class="p-4 card-color-administration rounded-pill" flat>
                                <v-row class="justify-center">
                                  <span>Príchod</span>
                                </v-row>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-calendar-start</v-icon>
                                    <span class="pl-1">{{formatDate(userDetailReservation.start_date)}}</span>
                                  </v-col>
                                </v-row>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-clock-start</v-icon>
                                    <span class="pl-1">{{userDetailReservation.start_time}}</span>
                                  </v-col>
                                </v-row>
                              </v-card>
                            </v-col>
                            <v-col cols="12" lg="6" md="6">
                              <v-card class="p-4 card-color-administration rounded-pill" flat>
                                <v-row class="justify-center">
                                  <span>Odchod</span>
                                </v-row>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-calendar-end</v-icon>
                                    <span class="pl-1">{{formatDate(userDetailReservation.end_date)}}</span>
                                  </v-col>
                                </v-row>
                                <v-row class="justify-center">
                                  <v-col>
                                    <v-icon>mdi-clock-end</v-icon>
                                    <span class="pl-1">{{userDetailReservation.end_time}}</span>
                                  </v-col>
                                </v-row>
                              </v-card>
                            </v-col>
                          </v-row>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list three-line subheader>
                      <v-subheader class="p-0">Suma rezervácie</v-subheader>
                      <v-row class="m-0 mt-3">
                        <v-col class="pl-0 pr-0" align="left">
                          <v-icon class="mb-1" color="orange">mdi-information</v-icon>
                          <span class="ml-1">Deti do 2 rokov sa do počtu hostí nezapočítavajú.</span>
                        </v-col>
                      </v-row>
                      <v-data-table :headers="headersDetail" :items="prices" class="elevation-0" disable-sort hide-default-header hide-default-footer :mobile-breakpoint="0">
                        <template v-slot:header="{ props: { headers } }">
                          <thead>
                            <tr>
                              <th v-for="(h, i) in headers" :key="i">
                                <v-tooltip bottom v-if="i != 3">
                                  <template v-slot:activator="{ on }">
                                    <span v-on="on">{{h.text}}</span>
                                  </template>
                                  <span>{{headerDetailTooltips[i - 1]}}</span>
                                </v-tooltip>
                                <span v-if="i == 3">{{h.text}}</span>
                              </th>
                            </tr>
                          </thead>
                        </template>
                      </v-data-table>
                    </v-list>
                  </v-container>
                </v-card>
              </v-dialog>
            </template>

            <template v-slot:item.id="{ item }">
              <span>{{ currentEvents.map(function(x) {return x.id; }).indexOf(item.id) + 1 }}</span>
            </template>

            <template v-slot:item.created_at="{ item }">
              <span>{{ formatCreated(item.created_at) }}</span>
            </template>

            <template v-slot:item.event_name="{ item }">
              <v-chip :color="getColor(item.event_name)" dark v-if="item.event_name == 'rezervácia'" small>
                <v-icon class="pr-1" small>mdi-clock</v-icon> <span>Čaká sa</span>
              </v-chip>
              <v-chip :color="getColor(item.event_name)" dark v-else small>
                <v-icon class="pr-1" small>mdi-check-circle</v-icon> <span>Akceptované</span>
              </v-chip>
            </template>

            <template v-slot:item.start_date="{ item }">
              <span>{{ formatDate(item.start_date) }}</span>
            </template>

            <template v-slot:item.end_date="{ item }">
              <span>{{ formatDate(item.end_date) }}</span>
            </template>

            <template v-slot:item.overall_price="{ item }">
              <span>{{item.overall_price}} €</span>
            </template>

            <template v-slot:item.actions="{ item }">
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-icon v-bind="attrs" v-on="on" small @click="showDetail(item)">mdi-information</v-icon>
                </template>
                <span>Detail rezervácie</span>
              </v-tooltip>
            </template>
          </v-data-table>


          <!-- snackbar after successfully created reservation -->
          <v-snackbar v-model="snackbarEdit" :multi-line="multiLine" :color="snackbarEditColor" bottom left>
            <v-icon>mdi-check-circle</v-icon>
            <span class="pl-1">{{snackbarEditText}}</span>
            <template v-slot:action="{ attrs }">
              <v-btn color="white" fab text small v-bind="attrs" @click="snackbarEdit = false">
                <v-icon>mdi-close-circle</v-icon>
              </v-btn>
            </template>
          </v-snackbar>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import VueTelInputVuetify from "vue-tel-input-vuetify/lib/vue-tel-input-vuetify.vue"
// import CountryFlag from 'vue-country-flag';
// import world_countries from '../../../assets/world_countries/world.json'

export default {
  name: "MojeRezervacie",
  components: {
    VueTelInputVuetify,
    // CountryFlag
  },
  data() {
    return {
      // Snackbar
      multiLine: true,
      snackbarEdit: false,
      snackbarEditText: '',
      snackbarEditColor: '',

      currentEvents: [],
      user: localStorage.getItem("username"),
      perPage: 3,
      currentPage: 1,
      showDialog: false,
      search: null,
      searched: [],
      menuStartDate: false,
      menuEndDate: false,
      menuStartTime: false,
      menuEndTime: false,
      dialog: false,
      dialogShowDetail: false,
      dialogDelete: false,
      footerProps: {
        itemsPerPageText: 'Počet riadkov',
        itemsPerPageOptions: [5, 10, 15, -1],
      },
      headerProps: {
        sortByText: "Zoradiť podľa"
      },
      headers: [{
          text: 'ID',
          align: 'id',
          sortable: true,
          value: 'id',
        }, {
          text: 'Status',
          value: 'event_name',
          sortable: false,
        }, {
          text: 'Dátum začiatku',
          value: 'start_date',
          sortable: true,
        }, {
          text: 'Dátum konca',
          value: 'end_date',
          sortable: true,
        }, {
          text: 'Používateľ',
          value: 'username',
          sortable: true,
        }, {
          text: 'Čas príchodu',
          value: 'start_time',
          sortable: true,
        }, {
          text: 'Čas odchodu',
          value: 'end_time',
          sortable: false,
        }, {
          text: 'Počet nocí',
          value: 'nights',
          sortable: false,
        }, {
          text: 'Dospelí',
          value: 'adults',
          sortable: false,
        },
        {
          text: 'Deti od 2 do 12 rokov',
          value: 'childs_2_to_12',
          sortable: false,
        },
        {
          text: 'Deti do 2 rokov',
          value: 'childs_to_2',
          sortable: false,
        }, {
          text: 'Počet osôb',
          value: 'total_persons',
          sortable: true,
        }, {
          text: 'Cena',
          value: 'overall_price',
          sortable: true,
        }, {
          text: 'Úkony',
          value: 'actions',
          sortable: false
        },
      ],

      headers2: [{
        text: 'ID',
        align: 'center',
        sortable: true,
        value: 'id',
      }, {
        text: 'Vytvorená',
        align: 'center',
        value: 'created_at',
        sortable: true,
      }, {
        text: 'Status',
        align: 'center',
        value: 'event_name',
        sortable: false,
      }, {
        text: 'Dátum začiatku',
        align: 'center',
        value: 'start_date',
        sortable: true,
      }, {
        text: 'Dátum konca',
        align: 'center',
        value: 'end_date',
        sortable: true,
      }, {
        text: 'Počet nocí',
        value: 'nights',
        sortable: false,
      }, {
        text: 'Počet osôb',
        value: 'total_persons',
        sortable: true,
      }, {
        text: 'Cena',
        value: 'overall_price',
        sortable: true,
      }, {
        text: 'Detail',
        align: 'center',
        value: 'actions',
        sortable: false
      }],

      adminEditReservation: null,
      adminEditReservationOriginal: null,
      adminEditReservationLoader: false,
      userDetailReservation: null,

      items: ['rezervácia', 'rezervované'],

      // for user
      headersDetail: [{
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
          text: '',
          value: 'p4',
          sortable: false,
        },
      ],
      prices: [],
      headerDetailTooltips: [],

      overlay: true,


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

      // countries: world_countries,

      test: []
    }
  },

  created() {
    window.Echo.join('reservation.' + localStorage.getItem("user_id"))
      .listen('Reservations', (e) => {
        console.log("echo here");
        if (this.$route.fullPath == '/administration') {
          if (e.user_id == 1) {
            this.markAsRead();
            if (e.status == 'created') {
              this.currentEvents.push(e.reservation[0])
            }
          } else {
            this.markAsRead();
            if (e.status == 'updated') {
              this.currentEvents.map((event, index) => {
                if (event.id == e.reservation[0].id) {
                  this.currentEvents.splice(index, 1, e.reservation[0]);
                }
              })
            }

            if (e.status == 'deleted') {
              this.currentEvents.map((event, index) => {
                if (event.id == e.reservation[0].id) {
                  this.currentEvents.splice(index, 1);
                }
              })
            }
          }
        }
      })
  },

  computed: {},

  watch: {
    adminEditReservation: {
      handler: function() {
        console.log(this.adminEditReservation.usercontactmodel.country);
        this.updateTable(this.adminEditReservation, 'edit');
        //console.log("HERE");
        this.adminEditReservationLoader = true;
        setTimeout(() => {
          this.adminEditReservationLoader = false;
        }, 300)
      },
      deep: true
    },
  },

  mounted() {
    this.getEvents();
    this.markAsRead();
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
        defaultProps.maxHeight = 112;
        defaultProps.top = true;
      }
      return defaultProps;
    },

    formatDate(value) {
      return new Date(Date.parse(value)).toLocaleDateString('sk-SK')
    },

    formatCreated(value) {
      return new Date(Date.parse(value)).toLocaleString('sk-SK', {
        timeZone: 'UTC'
      })
    },

    showDetail(item) {
      this.dialogShowDetail = true;
      this.userDetailReservation = item;
      this.updateTable(item, 'detail');
    },

    getEvents() {
      const api = `${process.env.VUE_APP_API_URL}/reservation`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.get(api, config)
        .then(res => {
          this.currentEvents = res.data;
          this.searched = this.currentEvents;
          this.overlay = false;
        })
    },

    //vueify table
    getColor(title) {
      if (title == 'rezervácia') return 'orange'
      else if (title == 'rezervované') return 'green'
    },

    increment(param) {
      var counter1 = parseInt(this.adminEditReservation.adults);
      var counter2 = parseInt(this.adminEditReservation.childs_2_to_12);
      var counter3 = parseInt(this.adminEditReservation.childs_to_2);
      if (param == 'adults') {
        if (counter1 + counter2 < 20) {
          if (counter1 < 20) {
            this.adminEditReservation.adults++;
          }
        }
      } else if (param == 'childs_2_to_12') {
        if (counter1 + counter2 < 20) {
          if (counter2 < 20) {
            this.adminEditReservation.childs_2_to_12++
          }
        }
      } else {
        if (counter3 < 20) {
          this.adminEditReservation.childs_to_2++
        }
      }

      this.updateTable(this.adminEditReservation, 'edit');
    },

    decrement(param) {
      var counter1 = parseInt(this.adminEditReservation.adults);
      var counter2 = parseInt(this.adminEditReservation.childs_2_to_12);
      var counter3 = parseInt(this.adminEditReservation.childs_to_2);
      if (param == 'adults') {
        if (counter1 > 0) {
          this.adminEditReservation.adults--
        }
      } else if (param == 'childs_2_to_12') {
        if (counter2 > 0) {
          this.adminEditReservation.childs_2_to_12--
        }
      } else {
        if (counter3 > 0) {
          this.adminEditReservation.childs_to_2--
        }
      }
      this.updateTable(this.adminEditReservation, 'edit');
    },

    reset(param) {
      if (param == 'adults') {
        this.adminEditReservation.adults = this.adminEditReservationOriginal.adults;
      } else if (param == 'childs_2_to_12') {
        this.adminEditReservation.childs_2_to_12 = this.adminEditReservationOriginal.childs_2_to_12;
      } else {
        this.adminEditReservation.childs_to_2 = this.adminEditReservationOriginal.childs_to_2;
      }
      this.updateTable(this.adminEditReservation, 'edit');
    },

    updateTable(item, type) {
      var nights = null;
      var counter1 = parseInt(item.adults);
      var counter2 = parseInt(item.childs_2_to_12)
      var counter3 = parseInt(item.childs_to_2);
      var cleaning_fee = parseInt(item.cleaning_fee);

      if (type == 'edit') {
        this.adminEditReservation.nights = String(moment(this.adminEditReservation.end_date, 'YYYY-MM-DD').diff(moment(this.adminEditReservation.start_date, 'YYYY-MM-DD'), 'days'));
        nights = this.adminEditReservation.nights;

        this.adminEditReservation.total_persons = String(counter1 + counter2 + counter3);

        if (counter1 + counter2 > 5) {
          this.adminEditReservation.overall_price = String(cleaning_fee +
            (counter1 * this.$root.prices.priceAdults * nights) +
            (counter2 * this.$root.prices.priceChilds2to12 * nights) +
            (counter3 * this.$root.prices.priceChildsto2 * nights));
        } else {
          this.adminEditReservation.overall_price = String(this.$root.prices.priceCabinUnderSixPpl * nights + cleaning_fee);
        }
      } else {
        nights = String(moment(item.end_date, 'YYYY-MM-DD').diff(moment(item.start_date, 'YYYY-MM-DD'), 'days'));
      }

      if (nights > 1) {
        this.headersDetail[4].text = 'Cena/' + nights + 'noci';
      } else {
        this.headersDetail[4].text = 'Cena/' + nights + 'noc';
      }

      this.headerDetailTooltips = [];
      this.headerDetailTooltips.push('Maximálny počet osôb je 20!');

      if (counter1 + counter2 > 5) {
        this.headerDetailTooltips.push('Cena za osobu na noc');
        this.headerDetailTooltips.push('');
      } else {
        this.headerDetailTooltips.push('Cena za celú chatu na 1 noc pri počte osôb <6');
        this.headerDetailTooltips.push('');
      }
      this.headerDetailTooltips.push(`${'Od ' + this.formatDate(item.start_date) + ' do ' + this.formatDate(item.end_date)}`);

      this.prices = [];

      if (counter1 + counter2 > 5) {
        if (counter2 > 0) {
          this.prices.splice(1, 0, {
            text: 'Deti od 2 do 12 rokov',
            p1: counter2,
            p2: this.$root.prices.priceChilds2to12 + '€',
            p3: counter2 * this.$root.prices.priceChilds2to12 + '€',
            p4: counter2 * this.$root.prices.priceChilds2to12 * nights + '€',
          });
        }
        if (counter3 > 0) {
          this.prices.splice(2, 0, {
            text: 'Deti do 2 rokov',
            p1: counter3,
            p2: this.$root.prices.priceChildsto2 + '€',
            p3: counter3 * this.$root.prices.priceChildsto2 + '€',
            p4: counter3 * this.$root.prices.priceChildsto2 * nights + '€',
          });
        }
        this.prices.splice(0, 0, {
          text: 'Dospelí',
          p1: counter1,
          p2: this.$root.prices.priceAdults + '€',
          p3: counter1 * this.$root.prices.priceAdults + '€',
          p4: counter1 * this.$root.prices.priceAdults * nights + '€',
        });

        this.prices.push({
          text: 'Upratovanie',
          p1: '',
          p2: '',
          p3: '',
          p4: cleaning_fee + '€',
        }, {
          text: 'Spolu',
          p1: counter1 + counter2 + counter3,
          p2: ((counter1 * this.$root.prices.priceAdults) / counter1) + ((counter2 * this.$root.prices.priceChilds2to12) / counter2 || 0) + ((counter3 * this.$root.prices.priceChildsto2) / counter3 || 0) + '€',
          p3: counter1 * this.$root.prices.priceAdults + counter2 * this.$root.prices.priceChilds2to12 + counter3 * this.$root.prices.priceChildsto2 + '€',
          p4: ((counter1 * this.$root.prices.priceAdults) * nights) + ((counter2 * this.$root.prices.priceChilds2to12) * nights || 0) + ((counter3 * this.$root.prices.priceChildsto2) * nights || 0) + cleaning_fee +
            '€',
        });
      } else {
        this.prices.push({
          text: 'Dospelí',
          p1: counter1,
          p2: '-',
          p3: '-',
          p4: '-',
        }, {
          text: 'Deti od 2 do 12 rokov',
          p1: counter2,
          p2: '-',
          p3: '-',
          p4: '-',
        }, {
          text: 'Deti do 2 rokov',
          p1: counter3,
          p2: '-',
          p3: '-',
          p4: '-',
        }, {
          text: 'Cena za celú chatu (<6 osôb)',
          p1: counter1 + counter2,
          p2: (item.overall_price - cleaning_fee) / nights + '€',
          p3: (item.overall_price - cleaning_fee) / nights + '€',
          p4: ((item.overall_price - cleaning_fee) / nights) * nights + '€',
        }, {
          text: 'Upratovanie',
          p1: '',
          p2: '',
          p3: '',
          p4: cleaning_fee + '€',
        }, {
          text: 'Spolu',
          p1: counter1 + counter2 + counter3,
          p2: (item.overall_price - cleaning_fee) / nights + '€',
          p3: (item.overall_price - cleaning_fee) / nights + '€',
          p4: (this.$root.prices.priceCabinUnderSixPpl * nights) + cleaning_fee + '€',
        });
      }
    },

    editItem(item) {
      this.adminEditReservationOriginal = {
        ...item
      };

      this.adminEditReservation = item;
      this.updateTable(item, 'edit');
      this.dialog = true;
    },

    deleteItem(item) {
      this.adminEditReservation = item;
      this.dialogDelete = true
    },

    deleteItemConfirm(item) {
      axios.post(`${process.env.VUE_APP_API_URL}/reservation/delete`, {
          id: item.id
        })
        .then(res => {
          this.snackbarEdit = true;
          this.snackbarEditText = "Rezervácia bola úspešne vymazaná.";
          this.snackbarEditColor = 'success';
          this.dialogDelete = false;
          this.currentEvents.map((event, index) => {
            if (event.id == res.data[0].id) {
              this.currentEvents.splice(index, 1)
              this.searched.splice(index, 1)
            }
          })

          const api = `${process.env.VUE_APP_API_URL}/sendNotification`;
          const config = {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + localStorage.getItem("authToken"),
            },
          };

          axios.post(api, {
              from: 1,
              recipient: item.user_id,
              title: "Chata Byšta",
              subtitle: "Vymazanie rezervácie",
              text: "Dobrý deň, Vaša rezervácia bola vymazaná. Pre bližšie informácie nás prosím kontaktujte",
              date: moment(new Date())
                .format('YYYY-MM-DD HH:mm'),
              status: "new",
            }, config)
            .then(() => {})
        })
    },

    save() {
      //update
      if (JSON.stringify(this.adminEditReservation) != JSON.stringify(this.adminEditReservationOriginal)) {
        axios.post(`${process.env.VUE_APP_API_URL}/reservation/update`, {
            data: this.adminEditReservation
          })
          .then(res => {
            //save newest data to adminEditReservationOriginal
            this.adminEditReservationOriginal = res.data[0];

            this.currentEvents.map((data, index) => {
              if (data.id == res.data[0].id) {
                this.currentEvents.splice(index, 1, res.data[0]);
              }
            })
            this.snackbarEdit = true;
            this.snackbarEditText = 'Dáta boli úspešne aktualizované';
            this.snackbarEditColor = 'success';

            const api = `${process.env.VUE_APP_API_URL}/sendNotification`;
            const config = {
              headers: {
                Accept: "application/json",
                Authorization: "Bearer " + localStorage.getItem("authToken"),
              },
            };

            if (res.data[0].event_name == "rezervácia") {
              axios.post(api, {
                  from: 1,
                  recipient: res.data[0].user_id,
                  title: "Chata Byšta",
                  subtitle: "Zrušenie potvrdenia rezervácie",
                  text: "Dobrý deň, Vaša rezervácia bola znova aktualizovaná do stavu pred potvrdením. Čoskoro poskytneme ďalšie informácie",
                  date: moment(new Date())
                    .format('YYYY-MM-DD HH:mm'),
                  status: "new",
                }, config)
                .then(() => {})
            } else {
              axios.post(api, {
                  from: 1,
                  recipient: res.data[0].user_id,
                  title: "Chata Byšta",
                  subtitle: "Potvrdenie rezervácie",
                  text: "Dobrý deň, Vaša rezervácia bola potvrdená. Tešíme sa na Vašu návštevu.",
                  date: moment(new Date())
                    .format('YYYY-MM-DD HH:mm'),
                  status: "new",
                }, config)
                .then(() => {})
            }
          })
      } else {
        this.snackbarEdit = true;
        this.snackbarEditText = 'Nie je zaevidovaná žiadna zmena.';
        this.snackbarEditColor = 'orange';
      }
    },

    markAsRead() {
      this.$store.dispatch('reservationCounter', {
        reservCounter: 0
      });
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      const api2 = `${process.env.VUE_APP_API_URL}/reservation/markAsRead`;

      axios.post(api2, {}, config)
        .then(() => {})
    }
  },
}
</script>
<style lang="scss" scoped>
.theme--light .v-card .card-color-administration {
    background: rgba(0, 0, 0, 0.06);
}

.theme--dark .v-card .card-color-administration {
    background: rgba(255, 255, 255, 0.08);
}

.v-application--is-ltr .v-text-field .v-input__append-inner {
    margin-left: auto;
    padding-left: 22px !important;
}

::v-deep .mobpho .v-input__icon--append {
    padding-left: 30px !important;
}

::v-deep .mobpho .country-code .v-input {
    border-bottom-right-radius: inherit;
    border-top-right-radius: inherit;
    border-bottom-left-radius: 50px;
    border-top-left-radius: 50px;
}

::v-deep .mobpho .v-input {
    border-bottom-left-radius: inherit;
    border-top-left-radius: inherit;
}

::v-deep .select-stat-reserv .v-label {
    top: 13px !important;
}
</style>
