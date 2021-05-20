<template>
<div class="price_list w-100 h-100 mt-3">
  <v-card elevation="0">
    <v-app-bar fixed flat>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title class="position-absolute" style="right:14px">
        <span class="md-title font-weight-bold" v-if="this.$vuetify.theme.dark">
          <img class="logo2 align-middle" src="/img/logos/logo_home_theme_dark.png">
        </span>
        <span class="md-title font-weight-bold" v-else>
          <img class="logo2 align-middle" src="/img/logos/logo_home_theme_light.png">
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

    <v-tabs-items v-model="tab" class="p-3 pt-1">
      <v-tab-item v-for="item in items" :key="item" disabled>
      </v-tab-item>
      <NavigationDrawer :drawer="drawer" />
      <v-card class="rounded p-5" elevation="0">
        <v-icon>mdi-volume-high</v-icon>
        Pripravujeme automatické uloženie nedokončených rezervácií.
      </v-card>
    </v-tabs-items>
  </v-card>
  <SpeedDial />
  <BottomNavigation />
  <Footer />
</div>
</template>

<script>
import Footer from "../components/Footer.vue";
import SpeedDial from "@/components/SpeedDial.vue";
import NavigationDrawer from "@/components/NavigationDrawer.vue";
import BottomNavigation from "@/components/BottomNavigation.vue";
export default {
  name: "SavedReservations",
  components: {
    Footer,
    SpeedDial,
    NavigationDrawer,
    BottomNavigation
  },
  props: ['drawerNew'],
  data() {
    return {
      username: localStorage.getItem("username"),
      drawer: false,
      tab: null,
      items: ['Uložené rezervácie'],
      show: false,
    }
  },
  updated() {
    this.drawer = this.drawerNew;
  },
  methods: {
    updateRouter(tab) {
      this.$router.push(tab)
    },
  }
}
</script>

<style>

</style>
