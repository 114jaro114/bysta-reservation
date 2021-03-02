<template>
<v-card id="create">
  <v-speed-dial v-model="fab" :bottom="bottom" :right="right" :direction="direction" :open-on-hover="hover" :transition="transition">
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
  // computed: {
  //   // activeFab() {
  //   //   // switch (this.tabs) {
  //   //   //   case 'one':
  //   //   //     return {
  //   //   //       class: 'white', icon: 'account_circle'
  //   //   //     }
  //   //   //     case 'two':
  //   //   //       return {
  //   //   //         class: 'white', icon: 'edit'
  //   //   //       }
  //   //   //       default:
  //   //   //         return {}
  //   //   // }
  //   // },
  // },
  // watch: {
  //   right(val) {
  //     this.left = !val
  //   },
  //   bottom(val) {
  //     this.top = !val
  //   },
  // },
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

.v-speed-dial button:focus {
  outline: 0px !important;
}
</style>
