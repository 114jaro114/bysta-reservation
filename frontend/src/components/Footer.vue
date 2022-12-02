<template>
<v-footer class="p-0" style="bottom: 0">
  <v-card flat tile class="text-center w-100">
    <!-- <v-divider class="mt-0" /> -->
    <v-card-text class="p-0 pt-3 mb-5">
      <v-row class="ml-5 mr-5">
        <v-col cols="12" lg="6" md="6" class="pl-0 pr-0 mt-5 d-flex">
          <v-flex class="pl-0 pr-0 justify-lg-start justify-md-start justify-center">
            <span class="md-title font-weight-bold" v-if="this.$vuetify.theme.dark">
              <v-img class="ma-lg-0 ma-md-0 ma-auto" :lazy-src="require('../../public/img/logos/logo_home_theme_dark.png')" max-height="100" max-width="400" :src="require('../../public/img/logos/logo_home_theme_dark.png')"></v-img>
            </span>
            <span class="md-title font-weight-bold" v-else>
              <v-img class="ma-lg-0 ma-md-0 ma-auto" :lazy-src="require('../../public/img/logos/logo_home_theme_light.png')" max-height="100" max-width="400" :src="require('../../public/img/logos/logo_home_theme_light.png')"></v-img>
            </span>
          </v-flex>
        </v-col>

        <v-col class="d-block-xs d-lg-none d-md-none">
          <v-divider class="d-lg-none d-md-none d-block mb-0" />
        </v-col>

        <v-col cols="12" lg="6" md="6" class="pl-0 pr-0 d-flex">
          <v-container class="pl-0 pr-0 justify-lg-end justify-md-end justify-center text-lg-end text-md-end text-center">
            <strong class="text-h5 mb-6 font-weight-bold">Adresa</strong>
            <v-spacer></v-spacer>
            <span class="text-h6 mb-6 font-weight-light">Chata Byšta</span>
            <v-spacer></v-spacer>
            <span class="text-h6 mb-6 font-weight-light">Hlavná 40, 076 13 Byšta</span>
            <v-spacer></v-spacer>
            <span class="text-h6 mb-6 font-weight-light">Rekreačná osada Byšta-kúpele</span>
            <v-spacer></v-spacer>
            <span class="text-h6 mb-6 font-weight-light">Slovenská republika</span>
          </v-container>
        </v-col>

        <v-col class="d-block-xs d-lg-none d-md-none">
          <v-divider class="d-lg-none d-md-none d-block mt-0" />
        </v-col>
      </v-row>
    </v-card-text>

    <v-btn id="footerCustomBtn" class="text-h6 font-weight-bold mt-3" outlined disabled>Sociálne siete</v-btn>

    <v-row class="ml-0 mr-0 mt-2">
      <v-col>
        <v-btn color="primary" v-for="item in items" :key="item.id" :href="item.link" class="mx-4" fab icon>
          <v-icon large>
            {{ item.icon }}
          </v-icon>
        </v-btn>
      </v-col>
    </v-row>

    <v-divider />

    <v-card-text class="justify-center" justify="center">
      <v-icon color="primary">mdi-copyright</v-icon> {{ new Date().getFullYear() }} — <strong>CHATA BYŠTA</strong>
      <v-spacer></v-spacer>
      <span>Made with
        <strong>
          <v-icon color="primary" small>mdi-heart-outline</v-icon>
        </strong>
        <span> by </span>
        <strong class="primary--text">WeBa</strong>
      </span>
    </v-card-text>
  </v-card>
</v-footer>
</template>
<script type="text/javascript">
export default {
  name: "Footer",
  data() {
    return {
      items: [{
          id: 1,
          icon: 'mdi-facebook',
          link: ''
        },
        {
          id: 2,
          icon: 'mdi-instagram',
          link: ''
        }
      ]
    }
  },
}
</script>
<style>
.facebook {
  color: #3490dc;
  font-size: 30px;
  margin-top: -3px;
}

.facebook:hover {
  color: #165283;
}

.instagram {
  color: #e3342f;
  font-size: 30px;
  margin-top: -3px;
}

.instagram:hover {
  color: #b41e18;
  ;
}

#footerCustomBtn.v-btn--disabled.theme--light {
  color: #0d47a1 !important;
}

#footerCustomBtn.v-btn--disabled.theme--dark {
  color: #0d47a1 !important;
}
</style>
