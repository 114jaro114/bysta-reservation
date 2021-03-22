<template>
<div class="vybavenie w-100 h-100 text-uppercase mt-1">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card>
          <v-card-title>
            <!-- <span class="primary--text">Vybavenie</span> -->
          </v-card-title>

          <v-card-text>
            <v-row align="center">
              <v-divider />
              <span>5 spální · 16 lôžok · 1 kúpeľňa + wc</span>
              <v-divider />
            </v-row>

            <h5 class="m-5 font-weight-bold">Usporiadanie lôžok</h5>

            <v-row align="center">
              <v-divider />
              1. poschodie
              <v-divider />
            </v-row>
            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <span class="secondary--text">1. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon class="secondary--text" large>mdi-bed-single</v-icon>
                    <v-icon class="secondary--text" large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span class="secondary--text">2 jednolôžkové postele</span>
                  </v-row>

                  <v-row class="justify-center">
                    <span class="secondary--text">2 prístelky</span>
                  </v-row>
                </v-sheet>
                <!-- </v-col> -->
                <!-- <v-col> -->
                <v-sheet color="primary" class="mt-5 p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <span class="secondary--text">2. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon class="secondary--text" large>mdi-bed-single</v-icon>
                    <v-icon class="secondary--text" large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span class="secondary--text">2 jednolôžkové postele</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span class="secondary--text">1 prístelka</span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <v-row align="center">
              <v-divider />
              2. poschodie
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <span class="secondary--text">1. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon class="secondary--text" large>mdi-bed-double</v-icon>
                    <v-icon class="secondary--text" large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span class="secondary--text">1 manželská posteľ</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span class="secondary--text">1 jednolôžková posteľ</span>
                  </v-row>
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <span class="secondary--text">2. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon class="secondary--text" large>mdi-bed-double</v-icon>
                    <v-icon class="secondary--text" large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span class="secondary--text">1 manželská posteľ</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span class="secondary--text">1 jednolôžková posteľ</span>
                  </v-row>
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <span class="secondary--text">3. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon class="secondary--text" large>mdi-bed-single</v-icon>
                    <v-icon class="secondary--text" large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span class="secondary--text">2 jednolôžkové postele</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span class="secondary--text">2 prístelky</span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <h5 class="m-5 font-weight-bold">Vybavenie</h5>

            <v-row align="center">
              <v-divider />
              Spoločenská miestnosť
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <span>Televízor</span>
                    <span>Domáce kino</span>
                    <span>Jedáleň - stoly a stoličky</span>
                    <span>Krb</span>
                    <span>Pec</span>
                    <span>2x sedačka</span>
                    <span>Kuchynska linka s dresom</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span>Základné vybavenie - uteráky, mydlo, toaletný papier, šampón</span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <v-row align="center">
              <v-divider />
              Kuchyňa a jedáleň
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-fridge</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Chladnička</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-dishwasher</v-icon>
                      </v-row>
                      <v-row class="justify-center">
                        <span class="ml-1">Umývačka riadu</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-stove</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Elektrická rúra</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-microwave</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Mikrovlna rúra</span>
                      </v-row>

                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Elektrická varná doska</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-coffee-maker</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Pákový kávovár</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Elektrický gril</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-kettle</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Konvica</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Trojnožka, kotlík (25l)</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-grill</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Prenosný gril</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-cup</v-icon>
                        <v-icon>mdi-bowl</v-icon>
                        <v-icon>mdi-silverware-fork-knife</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Príbory, taniere, misky, hrnce, poháre</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Trojnožka, kotlík (25l)</span>
                      </v-row>
                    </v-col>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <v-row align="center">
              <v-divider />
              Kúpeľňa
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <span class="mr-1">Sprchový kút - </span>
                    <span class="mr-1">WC - </span>
                    <span>Umývadlo</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span>Základné vybavenie - uteráky, mydlo, toaletný papier, šampón</span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <v-row align="center">
              <v-divider />
              Spálne
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <span>Základné vybavenie - posteľné obliečky, paplóny, vankúše</span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <v-row align="center">
              <v-divider />
              Kúrenie a ohrev vody
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <v-icon>mdi-fireplace</v-icon>
                    <span class="ml-1">Vykurovanie chaty na tuhé palivo s teplovzdušnými rozvodmi po celej chate</span>
                  </v-row>
                  <v-divider />
                  <v-row class="justify-center">
                    <v-icon>mdi-water-boiler</v-icon>
                    <span class="ml-1">Ohrev vody pomoocu boileru</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon>mdi-solar-panel-large</v-icon>
                    <span class="ml-1">Ohrev vody pomoocu solárneho zariadenia</span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <v-row align="center">
              <v-divider />
              Parkovanie
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <v-icon>mdi-alpha-p-circle-outline</v-icon>
                    <span class="ml-1">parkovanie na pozemku vedľa chaty (max 10 osobných aút)</span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <v-row align="center">
              <v-divider />
              Služby
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <v-icon>mdi-calendar-end</v-icon>
                    <span class="ml-1">
                      Dlhodobé pobyty povolené - možný pobyt na 28 alebo viac dní
                    </span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon>mdi-alert-circle</v-icon>
                    <span class="ml-1">
                      Snažíme sa vyriešiť akúkoľvek poruchu 24/7
                    </span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <!-- <v-row align="center">
              <v-divider />
              Ďalšie
              <v-divider />
            </v-row> -->

            <v-row align="center">
              <v-divider />
              Nezaradené
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet color="primary" class="p-4 mx-auto" rounded>
                  <v-row class="justify-center">
                    <v-icon>mdi-wifi-off</v-icon>
                    <span class="ml-1">
                      Internet
                    </span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon>mdi-</v-icon>
                    <span class="ml-1">
                      Klimatizácia
                    </span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon>mdi-</v-icon>
                    <span class="ml-1">
                      Pračka
                    </span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>

<script>
export default {
  name: "Vybavenie",
  components: {},
  data() {
    return {

    }
  },
}
</script>

<style lang="scss">
</style>
