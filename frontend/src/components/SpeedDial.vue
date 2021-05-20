<template>
<v-card id="create">
  <v-speed-dial v-if="this.$store.getters['speedDialState'].state" v-model="fab" :bottom="bottom" :right="right" :direction="direction" :open-on-hover="hover" :transition="transition">
    <template v-slot:activator>
      <v-btn color="primary" v-model="fab" fab>
        <v-icon v-if="fab"> mdi-close </v-icon>
        <v-icon v-else> mdi-pencil </v-icon>
      </v-btn>
    </template>
    <v-btn color="primary" fab small to="/messenger">
      <v-icon>mdi-facebook-messenger</v-icon>
    </v-btn>
    <v-btn color="primary" fab small to="/contact_us">
      <v-icon>mdi-email</v-icon>
    </v-btn>
  </v-speed-dial>
</v-card>
</template>
<script>
export default {
  data: () => ({
    direction: 'top',
    fab: false,
    fling: false,
    hover: false,
    tabs: null,
    top: false,
    right: true,
    bottom: true,
    transition: 'scale-transition',
  }),

  mounted() {
    //do something after mounting vue instance
    // console.log("SpeedDial mounted");

    if (JSON.parse(localStorage.getItem("speed_dial")) == true) {
      this.$store.dispatch('speedDialState', {
        status: true
      });
    } else {
      this.$store.dispatch('speedDialState', {
        status: false
      });
    }
  },

  updated() {
    //do something after updating vue instance
    // console.log("SpeedDial updated");
  }
}
</script>
<style>
/* This is for documentation purposes and will not be needed in your application */
#create .v-speed-dial {
  position: fixed;
}

#create .v-btn--floating {
  position: relative;
}

.v-speed-dial--bottom {
  bottom: 150px !important;
}
</style>
