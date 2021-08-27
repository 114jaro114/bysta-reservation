<template>
<div class="contact w-100 h-100">
  <v-card elevation="0">
    <v-app-bar fixed flat>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title class="position-absolute" style="right:14px">
        <span class="md-title font-weight-bold" v-if="this.$vuetify.theme.dark">
          <v-img class="ma-lg-0 ma-md-0 ma-auto" :lazy-src="require('../../public/img/logos/logo_home_theme_dark.png')" max-height="100" max-width="200" :src="require('../../public/img/logos/logo_home_theme_dark.png')"></v-img>
        </span>
        <span class="md-title font-weight-bold" v-else>
          <v-img class="ma-lg-0 ma-md-0 ma-auto" :lazy-src="require('../../public/img/logos/logo_home_theme_light.png')" max-height="100" max-width="200" :src="require('../../public/img/logos/logo_home_theme_light.png')"></v-img>
        </span>
      </v-toolbar-title>

      <template v-slot:extension>
        <v-tabs grow>
          <v-tab v-for="item in items" :key="item">
            {{ item }}
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-tabs-items class="pt-3 pt-lg-5 pt-md-5" v-model="tab" grow>
      <v-tab-item v-for="item in items" :key="item" disabled>
      </v-tab-item>
      <NavigationDrawer :drawer="drawer" />
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-lazy :options="{
                      threshold: .4
                    }" transition="scale-transition">
        <v-row justify="center" class="ml-0 mr-0">
          <v-col class="pl-3 pr-3">
            <v-card class="rounded" elevation="0">
              <v-toolbar class="rounded-top" color="primary" flat dark>
                <v-row align="center">
                  <v-divider />
                  <v-icon class="pr-1">mdi-alert-circle</v-icon>
                  V prípade akýchkoľvek otázok nás neváhajte kontaktovať.
                  <v-divider />
                </v-row>
              </v-toolbar>
              <v-row justify="center" class="ml-0 mr-0 mt-3 pb-3">
                <v-col class="pl-3 pr-3 m-auto">
                  <v-btn class="mt-3" x-large color="primary" outlined dark to="/messenger">
                    <v-icon class="pr-1">mdi-facebook-messenger</v-icon>
                    Messenger
                  </v-btn>
                </v-col>
                <v-divider inset vertical></v-divider>
                <v-col class="pl-3 pr-3">
                  <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text class="p-3">
                      <v-text-field prepend-icon="mdi-email" v-model="email" :error-messages="error" :rules="emailRules" label="Email" filled clearable clear-icon="mdi-close"></v-text-field>

                      <v-textarea :rules="rules" v-model="message" label="Správa" rows="1" auto-grow prepend-icon="mdi-comment" counter="1000" clearable filled clear-icon="mdi-close"></v-textarea>
                    </v-card-text>
                    <hr class="mt-0 ml-4 mr-4">
                    <v-card-actions class="p-3">
                      <v-btn color="primary" @click="sendMessage()" block>
                        Odoslať správu
                      </v-btn>
                    </v-card-actions>
                  </v-form>
                </v-col>
              </v-row>
            </v-card>
          </v-col>
        </v-row>
      </v-lazy>
    </v-tabs-items>
  </v-card>
</div>
</template>

<script>
import NavigationDrawer from "@/components/NavigationDrawer.vue";
import axios from 'axios';
export default {
  name: "Contact",
  components: {
    NavigationDrawer,
  },
  props: ['drawerNew'],
  data() {
    return {
      overlay: true,
      username: localStorage.getItem("username"),
      drawer: false,
      tab: null,
      items: ['Kontakt'],
      show: false,
      email: '',
      emailRules: [
        v => !!v || 'E-mail je povinný',
        v => /.+@.+\..+/.test(v) || 'E-mail musí mať valídny tvar',
      ],
      message: '',
      rules: [
        v => (v && v.length <= 1000) || 'Maximálna dĺžka je 1000 znakov'
      ],
    }
  },

  mounted() {
    this.getAccData();
  },

  updated() {
    this.drawer = this.drawerNew;
  },
  methods: {
    validate() {
      return this.$refs.form.validate();
    },

    updateRouter(tab) {
      this.$router.push(tab)
    },

    getAccData() {
      const api = `${process.env.VUE_APP_API_URL}/auth/user`;
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.get(api, config)
        .then((response) => {
          this.email = response.data.email;
          this.overlay = false;
        })
        .catch((error) => {
          console.log(error)
        })
    },
  }
}
</script>

<style>

</style>
