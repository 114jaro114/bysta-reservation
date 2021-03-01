<template>
  <v-footer class="p-0">
    <v-card flat tile width="100%" class="grey lighten-1 text-center">
      <v-card-text>
        <v-btn v-for="icon in icons" :key="icon" class="mx-4" icon>
          <v-icon size="24px">
            {{ icon }}
          </v-icon>
        </v-btn>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-text class="white--text">
        <v-icon color="white">mdi-copyright</v-icon> {{ new Date().getFullYear() }} — <strong>Chata Byšta. Všetky práva vyhradené.</strong>
      </v-card-text>
    </v-card>
  </v-footer>
</template>
<script type="text/javascript">
  export default {
    name: "Footer",
    data() {
      return {
        icons: ['mdi-facebook', 'mdi-instagram', ],
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

  .footer {
    background-color: #e9ecef;
  }

  .footer-content {
    margin-top: -3px;
  }

</style>
