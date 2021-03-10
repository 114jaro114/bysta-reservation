<template>
<div class="app_settings w-100 h-100 text-uppercase mt-1">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card color="primary" dark>
          <v-card-title class="headline">
          </v-card-title>

          <span class="secondary--color">Dark/Light mod</span>

          <v-card-text>
            <v-row justify="center">
              <v-col class="d-flex" cols="12" sm="6">
                <v-tooltip v-if="!$vuetify.theme.dark" bottom>
                  <template v-slot:activator="{ on }">
                    <!-- <v-btn v-on="on" small fab @click="darkMode">
                      <v-icon class="mr-1">mdi-moon-waxing-crescent</v-icon>
                    </v-btn> -->
                    <v-btn v-on="on" @click="toggle_dark_mode" block large>
                      <v-icon>mdi-theme-light-dark</v-icon>
                    </v-btn>
                  </template>
                  <span>Zapnúť dark mód</span>
                </v-tooltip>

                <v-tooltip v-else bottom>
                  <template v-slot:activator="{ on }">
                    <!-- <v-btn v-on="on" small fab @click="darkMode">
                      <v-icon>mdi-white-balance-sunny</v-icon>
                    </v-btn> -->
                    <v-btn v-on="on" @click="toggle_dark_mode" block large>
                      <v-icon>mdi-theme-light-dark</v-icon>
                    </v-btn>
                  </template>
                  <span>Vypnúť dark mód</span>
                </v-tooltip>
              </v-col>
            </v-row>

          </v-card-text>

          <v-divider class="secondary" />

          <span class="secondary--color">Speed dial (<v-icon medium>mdi-web</v-icon>)</span>

          <v-card-text>
            <v-row justify="center">
              <v-col class="d-flex" cols="12" sm="6">
                <!-- <v-tooltip v-if="switch1" bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn v-on="on" :ripple="false" class="speed_dial_switch" block large depressed>
                      <span class="pr-4">skryť</span>
                      <v-switch color="primary" v-model="switch1" inset @click="speedDial()"></v-switch>
                      <span>Zobraziť</span>
                      <v-icon style="right:0px" small>mdi-information</v-icon>
                    </v-btn>
                  </template>
                  <span>Skryť speed dial</span>
                  <span>
                    <v-btn color="primary" fab dark x-small absolute bottom left>
                      <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                  </span>
                </v-tooltip>
                <v-tooltip v-else bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn v-on="on" :ripple="false" class="speed_dial_switch" block large>
                      <span class="pr-4">skryť</span>
                      <v-switch color="primary" v-model="switch1" inset @click="speedDial()"></v-switch>
                      <span>Zobraziť</span>
                    </v-btn>
                  </template>
                  <span>Zobraziť speed dial</span>
                </v-tooltip> -->
                <v-btn :ripple="false" class="speed_dial_switch" block large>
                  <span class="pr-4">skryť</span>
                  <v-switch color="primary" v-model="switch1" inset @click="speedDial()"></v-switch>
                  <span>Zobraziť</span>
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>

          <v-divider class="secondary" />

          <span class="secondary--color">Notifikácie</span>

          <v-card-text>
            <v-row justify="center">
              <v-col class="d-flex pb-0" cols="12" sm="6">
                <v-btn :ripple="false" class="speed_dial_switch" block large>
                  <span class="pr-4">vypnúť</span>
                  <v-switch color="primary" v-model="switch2" inset></v-switch>
                  <span>Zapnúť</span>
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>

          <v-divider class="secondary" />

          <span class="secondary--color">spodná navigačná lišta (<v-icon medium>mdi-cellphone-cog</v-icon>)</span>

          <v-card-text>
            <v-row justify="center">
              <v-col class="d-flex pb-0" cols="12" sm="6">
                <v-btn :ripple="false" class="speed_dial_switch" block large>
                  <span class="pr-4">skryt</span>
                  <v-switch color="primary" v-model="switch3" @click="bottomNavigation()" inset></v-switch>
                  <span>Zobraziť</span>
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>

          <v-divider class="secondary" />

          <span class="secondary--color">Jazyk aplikácie</span>

          <v-card-text class="select_country">
            <v-row justify="center">
              <v-col class="d-flex pb-0" cols="12" sm="6">
                <v-select v-model="select" :items="countries" item-text="name" label="Jazyk" solo>
                  <template slot="selection" slot-scope="slotProps">
                    <i :class="['mr-2', 'mdi', slotProps.item.flag]"></i>
                    {{slotProps.item.name}}
                  </template>
                  <template v-slot:item="slotProps">
                    <i :class="['mr-2', 'mdi', slotProps.item.flag]"></i>
                    {{slotProps.item.name}}
                  </template>
                  <span>Vybrať jayzk</span>
                </v-select>
              </v-col>
            </v-row>
          </v-card-text>

          <v-card-actions>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>

<script>
export default {
  name: "AppSettings",
  components: {},
  data() {
    return {
      select: 'Slovensky',
      countries: [{
          name: "Slovensky",
          flag: "vti__flag sk"
        },
        {
          name: "Česky",
          flag: "vti__flag cz"
        },
        {
          name: "Anglicky",
          flag: "vti__flag gb"
        },
        {
          name: "Nemecky",
          flag: "vti__flag de"
        },
        {
          name: "Poľsky",
          flag: "vti__flag pl"
        },
      ],
      switch1: JSON.parse(localStorage.getItem("speed_dial")),
      switch2: true,
      switch3: JSON.parse(localStorage.getItem("bottom_navigation")),
    }
  },
  mounted() {
    const theme = localStorage.getItem("dark_theme");
    if (theme) {
      if (theme === "true") {
        this.$vuetify.theme.dark = true;
      } else {
        this.$vuetify.theme.dark = false;
      }
    } else if (
      window.matchMedia &&
      window.matchMedia("(prefers-color-scheme: dark)")
      .matches
    ) {
      this.$vuetify.theme.dark = true;
      localStorage.setItem(
        "dark_theme",
        this.$vuetify.theme.dark.toString()
      );
    }

    if (JSON.parse(localStorage.getItem("speed_dial")) == true) {
      this.$store.dispatch('actionSpeedDialState', {
        status: true
      });
    } else {
      this.$store.dispatch('actionSpeedDialState', {
        status: false
      });
    }

    if (JSON.parse(localStorage.getItem("bottom_navigation")) == true) {
      this.$store.dispatch('actionBottomNavigationState', {
        status: true
      });
    } else {
      this.$store.dispatch('actionBottomNavigationState', {
        status: false
      });
    }

    this.select = localStorage.getItem('language');
  },
  methods: {
    toggle_dark_mode() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
    },

    speedDial() {
      if (JSON.parse(localStorage.getItem('speed_dial')) == true) {
        localStorage.setItem('speed_dial', false);
        this.switch1 = false;
        this.$store.dispatch('actionSpeedDialState', {
          status: false
        });
      } else {
        localStorage.setItem('speed_dial', true);
        this.switch1 = true;
        this.$store.dispatch('actionSpeedDialState', {
          status: true
        });
      }
    },

    bottomNavigation() {
      if (JSON.parse(localStorage.getItem('bottom_navigation')) == true) {
        localStorage.setItem('bottom_navigation', false);
        this.switch3 = false;
        this.$store.dispatch('actionBottomNavigationState', {
          status: false
        });
      } else {
        localStorage.setItem('bottom_navigation', true);
        this.switch3 = true;
        this.$store.dispatch('actionBottomNavigationState', {
          status: true
        });
      }
    },
  },

  updated() {
    //do something after updating vue instance
    localStorage.setItem('language', this.select);
    // console.log(this.$store.getters['gettersSpeedDialState']);
    // console.log(this.$store.getters['gettersBottomNavigationState']);
  }
}
</script>

<style type="scss">
/* .v-input__slot {
  margin-bottom: 0px;
} */

.speed_dial_switch .v-input--selection-controls {
  margin-top: 22px !important;
}

.menuable__content__active {
  z-index: 51 !important;
}
</style>
