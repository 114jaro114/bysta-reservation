<template>
<div class="administration w-100 h-100">
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
          <v-tab v-for="tab in tabs" :key="tab.id" :to="tab.route" exact>{{ tab.name }}</v-tab>
        </v-tabs>
      </template>
    </v-app-bar>
    <v-tabs-items v-model="activeTab" @change="updateRouter($event)" grow>
      <v-tab-item v-for="tab in tabs" :key="tab.id" :value="tab.route">
        <router-view />
      </v-tab-item>
      <NavigationDrawer :drawer="drawer" />
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
  name: "Administration",
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
      activeTab: '/administration',
      tabs: [{
        id: 1,
        name: 'Administrácia',
        route: '/administration'
      }, {
        id: 2,
        name: 'Detaily',
        route: '/administration/details'
      }, ],
    }
  },
  updated() {
    this.drawer = this.drawerNew;
  },
  watch: {
    group() {
      this.drawer = false
    },
  },
  methods: {}
}
</script>
<style type="scss">
/*
.v-navigation-drawer {
  position: fixed !important;
  width: 300px !important;
  box-shadow: unset !important;
}

.v-overlay__scrim {
  position: fixed !important;
} */
</style>
