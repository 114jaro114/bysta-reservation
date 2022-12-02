<template>
<div class="app_settings w-100 h-100">
  <v-container>
    <v-lazy :options="{
            threshold: .4
          }" min-height="100vh" transition-group="scale-transition">
      <v-row justify="center" class="ml-0 mr-0">
        <v-col class="pl-3 pr-3">
          <!-- <v-card> -->
          <v-list class="rounded" flat subheader three-line>
            <v-list-item-group v-model="ntf" multiple active-class="">
              <v-subheader>Notifikácie</v-subheader>
              <v-list-item>
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-checkbox :input-value="active"></v-checkbox>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>Notifikácie</v-list-item-title>
                    <v-list-item-subtitle>Informovať ma o nových udalostiach</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>
            <v-list-item-group v-model="ntfs" multiple active-class="">
              <v-list-item>
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-checkbox :input-value="active"></v-checkbox>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>Zvuky</v-list-item-title>
                    <v-list-item-subtitle>Zapnúť alebo vypnúť zvuky k notifikáciám</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>

            <v-divider></v-divider>


            <v-list-item-group v-model="dlm" multiple active-class="">
              <v-subheader>Nastavenie režimu</v-subheader>
              <!-- <v-list-item-title>Tmavý/Svetlý režim</v-list-item-title> -->
              <v-row class="pl-3 pr-3 pb-3" justify="center">
                <v-col class="d-flex" cols="12" sm="6">
                  <v-tooltip v-if="!$vuetify.theme.dark" bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn :disabled="autoDLMon" v-on="on" @click="toggle_dark_mode" block large rounded>
                        <v-icon>mdi-theme-light-dark</v-icon>
                      </v-btn>
                    </template>
                    <span>Zapnúť dark mód</span>
                  </v-tooltip>

                  <v-tooltip v-else bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn :disabled="autoDLMon" v-on="on" @click="toggle_dark_mode" block large rounded>
                        <v-icon>mdi-theme-light-dark</v-icon>
                      </v-btn>
                    </template>
                    <span>Vypnúť dark mód</span>
                  </v-tooltip>
                </v-col>
              </v-row>

              <v-list-item>
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-switch color="primary" :input-value="active" inset></v-switch>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>Automatický režim </v-list-item-title>
                    <v-list-item-subtitle>Automatické nastavenie tmavého/svetlého režimu (nemusí fungovať na všetkých prehliadačoch)</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>

            <v-divider></v-divider>

            <v-list-item-group v-model="sd" multiple active-class="">
              <v-list-item :disabled="lockSpeedDial">
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-switch color="primary" :input-value="active" inset></v-switch>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>Speed dial (<v-icon medium>mdi-web</v-icon>)</v-list-item-title>
                    <v-list-item-subtitle>Zapnúť alebo vypnúť zobrazenie speed dialu (len rozlíšenie webu)</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>

            <v-divider></v-divider>

            <v-list-item-group v-model="bn" multiple active-class="">
              <v-list-item :disabled="lockBottomNavigation">
                <template v-slot:default="{ active }">
                  <v-list-item-action>
                    <v-switch color="primary" :input-value="active" inset></v-switch>
                  </v-list-item-action>

                  <v-list-item-content>
                    <v-list-item-title>spodná navigačná lišta (<v-icon medium>mdi-cellphone-cog</v-icon>)</v-list-item-title>
                    <v-list-item-subtitle>Zapnúť alebo vypnúť zobrazenie spodnej lišty (len pre mobily)</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </v-list-item>
            </v-list-item-group>

            <v-divider></v-divider>

            <v-subheader>Jazyk aplikácie</v-subheader>

            <v-row class="pl-3 pr-3 pb-3" justify="center">
              <v-col cols="12" sm="6">
                <!-- language select menu -->
                <v-menu :close-on-content-click="false" rounded="xl">
                  <template v-slot:activator="{ on, attrs }">
                    <div class="lang">
                      <v-btn class="p-0" block rounded large v-bind="attrs" v-on="on">
                        <div class="pt-1">
                          <div v-if="$root.language.selectedLang == '1'">
                            <CountryFlag :country="'gb'" size='normal' />
                            <span class="position-relative white--color mr-2" style="top:-14px">en</span>
                          </div>
                          <div v-else>
                            <CountryFlag :country="'sk'" size='normal' />
                            <span class="position-relative white--color mr-2" style="top:-14px">sk</span>
                          </div>
                        </div>
                      </v-btn>
                    </div>
                  </template>
                  <v-card class="rounded">
                    <v-list-item-content class="justify-center p-0">
                      <v-list class="p-0">
                        <v-list-item-group v-model="$root.language.selectedLang" color="primary">
                          <v-list-item class="p-0 justify-center" v-for="(item, i) in $root.language.countries" :key="i" @click="setlang(item)" :disabled="i == $root.language.selectedLang">
                            <div class="position-relative" style="padding-right: 28px">
                              <CountryFlag :country='item.flag' size='normal' />
                              <span class="text-uppercase position-absolute" style="top: 12px">{{item.name}}</span>
                            </div>
                          </v-list-item>
                        </v-list-item-group>
                      </v-list>
                    </v-list-item-content>
                  </v-card>
                </v-menu>
              </v-col>
            </v-row>


          </v-list>
        </v-col>
      </v-row>
    </v-lazy>
  </v-container>
</div>
</template>

<script>
import CountryFlag from 'vue-country-flag';
export default {
  name: "AppSettings",
  components: {
    CountryFlag
  },
  data() {
    return {
      windowWidth: window.innerWidth,
      txt: '',
      lockSpeedDial: false,
      lockBottomNavigation: false,
      autoDLMon: false,
      settings: [],

      ntf: [],
      ntfs: [],
      dlm: [],
      sd: [],
      bn: [],

      arraySwitchesSliders: [],
      //language
    }
  },


  mounted() {
    if (!(localStorage.getItem('language'))) {
      localStorage.setItem('language', 'sk');
      this.$root.language.selectedLang = 0;
    }

    if (localStorage.getItem('language') == 'sk') {
      this.$root.language.selectedLang = 0;
    } else {
      this.$root.language.selectedLang = 1;
    }

    if (this.windowWidth <= 480) {
      this.lockSpeedDial = true;
      this.lockBottomNavigation = false;
    } else {
      this.lockSpeedDial = false;
      this.lockBottomNavigation = true;
    }
    window.addEventListener('resize', () => {
      this.windowWidth = window.innerWidth
      if (this.windowWidth <= 480) {
        this.lockSpeedDial = true;
        this.lockBottomNavigation = false;
      } else {
        this.lockSpeedDial = false;
        this.lockBottomNavigation = true;
      }
    });

    const theme = localStorage.getItem("dark_theme");
    if (theme) {
      if (theme === "true") {
        this.$vuetify.theme.dark = true;
        localStorage.setItem('graph_theme', 'dark');
        localStorage.setItem('graph_text_color', '#ffffff');
        localStorage.setItem('recaptcha_theme', 'dark');
      } else {
        this.$vuetify.theme.dark = false;
        localStorage.setItem('graph_theme', 'light');
        localStorage.setItem('graph_text_color', '#2c3e50');
        localStorage.setItem('recaptcha_theme', 'light');
      }
    }

    if (JSON.parse(localStorage.getItem("auto_dlm")) == true) {
      this.autoDLMon = true;
      this.dlm.push(0);
      this.$store.dispatch('autoDarkLightModeState', {
        status: true
      });
    } else {
      this.autoDLMon = false;
      this.dlm.splice(0, 1);
      this.$store.dispatch('autoDarkLightModeState', {
        status: false
      });
    }

    if (JSON.parse(localStorage.getItem("notifState")) == true) {
      this.ntf.push(0);
    }

    if (JSON.parse(localStorage.getItem("notifSoundState")) == true) {
      this.ntfs.push(0);
    }

    if (JSON.parse(localStorage.getItem("speed_dial")) == true) {
      this.sd.push(0);
      this.$store.dispatch('speedDialState', {
        status: true
      });
    } else {
      this.sd.splice(0, 1);
      this.$store.dispatch('speedDialState', {
        status: false
      });
    }

    if (JSON.parse(localStorage.getItem("bottom_navigation")) == true) {
      this.bn.push(0);
      this.$store.dispatch('bottomNavigationState', {
        status: true
      });
    } else {
      this.bn.splice(0, 1);
      this.$store.dispatch('bottomNavigationState', {
        status: false
      });
    }
  },

  methods: {
    //set language
    setlang(item) {
      localStorage.setItem('language', item.name);
      if (item.name == 'sk') {
        this.$root.language.selectedLang = 0;
        this.$i18n.locale = 'sk';
      } else {
        this.$root.language.selectedLang = 1;
        this.$i18n.locale = 'en';
      }
    },

    toggle_dark_mode() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
      if (this.$vuetify.theme.dark == true) {
        localStorage.setItem('graph_theme', 'dark');
        localStorage.setItem('graph_text_color', '#ffffff');
        localStorage.setItem('recaptcha_theme', 'dark');
      } else {
        localStorage.setItem('graph_theme', 'light');
        localStorage.setItem('graph_text_color', '#2c3e50');
        localStorage.setItem('recaptcha_theme', 'light');
      }
    },
  },

  updated() {
    //do something after updating vue instance
    if (this.ntf.length != 0) {
      localStorage.setItem('notifState', true);
    } else {
      localStorage.setItem('notifState', false);
    }

    if (this.ntfs.length != 0) {
      localStorage.setItem('notifSoundState', true);
    } else {
      localStorage.setItem('notifSoundState', false);
    }
    if (this.dlm.length != 0) {
      this.autoDLMon = true;
      localStorage.setItem('auto_dlm', true);
      this.$store.dispatch('autoDarkLightModeState', {
        status: true
      });
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)')
        .matches) {
        this.$vuetify.theme.dark = true;
        localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
        localStorage.setItem('graph_theme', 'dark');
        localStorage.setItem('graph_text_color', '#ffffff');
        localStorage.setItem('recaptcha_theme', 'dark');
      } else {
        this.$vuetify.theme.dark = false;
        localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
        localStorage.setItem('graph_theme', 'light');
        localStorage.setItem('graph_text_color', '#2c3e50');
        localStorage.setItem('recaptcha_theme', 'light');
      }
    } else {
      this.autoDLMon = false;
      localStorage.setItem('auto_dlm', false);
      this.$store.dispatch('autoDarkLightModeState', {
        status: false
      });
    }

    if (this.sd.length != 0) {
      localStorage.setItem('speed_dial', true);
      this.$store.dispatch('speedDialState', {
        status: true
      });
    } else {
      localStorage.setItem('speed_dial', false);
      this.$store.dispatch('speedDialState', {
        status: false
      });
    }

    if (this.bn.length != 0) {
      localStorage.setItem('bottom_navigation', true);
      this.$store.dispatch('bottomNavigationState', {
        status: true
      });
    } else {
      localStorage.setItem('bottom_navigation', false);
      this.$store.dispatch('bottomNavigationState', {
        status: false
      });
    }
  },
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
  z-index: 204 !important;
}

::v-deep .lang-select .v-list {
  padding: 0 !important;
}
</style>
