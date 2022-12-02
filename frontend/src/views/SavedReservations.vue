<template>
<div class="saved_reservations w-100 h-100">
  <v-container class="mt-16">
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-card class="rounded p-5" elevation="0">
      <v-icon>mdi-volume-high</v-icon>
      Pripravujeme automatické uloženie nedokončených rezervácií.
    </v-card>
  </v-container>
</div>
</template>

<script>
export default {
  name: "SavedReservations",
  components: {},
  data() {
    return {
      username: localStorage.getItem("username"),
      show: false,
      overlay: true,
    }
  },
  mounted() {
    setTimeout(() => {
      this.overlay = false;
    }, 500)
  },

  updated() {},

  methods: {
    updateRouter(tab) {
      this.$router.push(tab)
    },
  },
}
</script>

<style>

</style>
