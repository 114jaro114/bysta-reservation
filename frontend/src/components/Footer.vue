<template>
<v-footer class="p-0" style="bottom: 0">
  <v-card flat tile width="100%" class="text-center">
    <!-- <v-divider class="primary mt-0" /> -->

    <v-btn class="text-h6 font-weight-bold mt-3" outlined disabled>Sociálne siete</v-btn>

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
      <v-icon color="primary">mdi-copyright</v-icon> {{ new Date().getFullYear() }} — <strong>KPI FEI TUKE</strong>
      <v-spacer></v-spacer>
      <span>Made by — <strong>Chata Byšta</strong></span>
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

.footer .v-btn.v-btn--disabled:not(.v-btn--flat):not(.v-btn--text):not(.v-btn-outlined) {
  color: #2196f3 !important;
}
</style>
