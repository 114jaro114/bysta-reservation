<template>
<div class="vybavenie w-100 h-100 mt-3">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card class="rounded" elevation="0">
          <v-card-title class="justify-center">
            <!-- <span class="font-weight-bold primary--text">Vybavenie</span> -->
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
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <span>1. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon large>mdi-bed-single</v-icon>
                    <v-icon large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span>2 jednolôžkové postele</span>
                  </v-row>

                  <v-row class="justify-center">
                    <span>2 prístelky</span>
                  </v-row>
                </v-sheet>
                <!-- </v-col> -->
                <!-- <v-col> -->
                <v-sheet class="mt-5 p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <span>2. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon large>mdi-bed-single</v-icon>
                    <v-icon large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span>2 jednolôžkové postele</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span>1 prístelka</span>
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
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <span>1. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon large>mdi-bed-double</v-icon>
                    <v-icon large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span>1 manželská posteľ</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span>1 jednolôžková posteľ</span>
                  </v-row>
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <span>2. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon large>mdi-bed-double</v-icon>
                    <v-icon large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span>1 manželská posteľ</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span>1 jednolôžková posteľ</span>
                  </v-row>
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <span>3. izba</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon large>mdi-bed-single</v-icon>
                    <v-icon large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span>2 jednolôžkové postele</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span>2 prístelky</span>
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
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-fridge</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Televízor</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-fridge</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Domáce kino</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-fridge</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Jedáleň - stoly a stoličky</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-fridge</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Krb</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-fridge</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Pec</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-fridge</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">2x sedačka</span>
                      </v-row>
                    </v-col>

                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-fridge</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Kuchynska linka s drezom</span>
                      </v-row>
                    </v-col>
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
                <v-sheet class="p-4 mx-auto" rounded outlined>
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
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Sprchový kút</span>
                      </v-row>
                    </v-col>
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">WC</span>
                      </v-row>
                    </v-col>
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Umývadlo</span>
                      </v-row>
                    </v-col>
                  </v-row>
                  <v-row class="justify-center">
                    <span>Základné vybavenie</span>
                  </v-row>

                  <v-divider />

                  <v-row class="justify-center">
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">uteráky</span>
                      </v-row>
                    </v-col>
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">mydlo</span>
                      </v-row>
                    </v-col>
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">toaletný papier</span>
                      </v-row>
                    </v-col>
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">šampón</span>
                      </v-row>
                    </v-col>
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
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <span>Základné vybavenie</span>
                  </v-row>

                  <v-divider />

                  <v-row class="justify-center">
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">posteľné obliečky</span>
                      </v-row>
                    </v-col>
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">paplóny</span>
                      </v-row>
                    </v-col>
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alpha-p-circle-outline</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">vankúše</span>
                      </v-row>
                    </v-col>
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
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <v-icon>mdi-fireplace</v-icon>
                    <span class="ml-1">Vykurovanie chaty na tuhé palivo s teplovzdušnými rozvodmi po celej chate</span>
                  </v-row>
                  <v-divider />
                  <v-row class="justify-center">
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-water-boiler</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Ohrev vody pomocou boileru</span>
                      </v-row>
                    </v-col>
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-solar-panel-large</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Ohrev vody pomocou solárneho zariadenia</span>
                      </v-row>
                    </v-col>
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
                <v-sheet class="p-4 mx-auto" rounded outlined>
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
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-calendar-end</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Dlhodobé pobyty povolené - možný pobyt na 28 alebo viac dní</span>
                      </v-row>
                    </v-col>
                    <v-col class="p-4">
                      <v-row class="justify-center">
                        <v-icon>mdi-alert-circle</v-icon>
                      </v-row>

                      <v-row class="justify-center">
                        <span class="ml-1">Snažíme sa vyriešiť akúkoľvek poruchu 24/7</span>
                      </v-row>
                    </v-col>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>

            <v-row align="center">
              <v-divider />
              Nezaradené
              <v-divider />
            </v-row>

            <v-row>
              <v-col>
                <v-sheet class="p-4 mx-auto" rounded outlined>
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
