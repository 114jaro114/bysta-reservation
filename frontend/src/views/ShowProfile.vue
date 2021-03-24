<template>
<div class="user_profile w-100 h-100 text-uppercase secondary-color">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
    <v-card class="v-content">
      <v-toolbar elevation="2" class="mb-3">
        <v-app-bar-nav-icon :drawerNew="drawerNew" @click="drawer = !drawer"></v-app-bar-nav-icon>
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
            <v-tab v-for="tab in tabs" :key="tab.id" :to="tab.route" exact>{{ tab.name }}</v-tab>
          </v-tabs>
        </template>
      </v-toolbar>
      <v-tabs-items v-model="activeTab" grow>
        <v-tab-item v-for="tab in tabs" :key="tab.id" :value="tab.route">
          <router-view />
        </v-tab-item>
        <NavigationDrawer :drawer="drawer" />
      </v-tabs-items>
    </v-card>
  </v-lazy>
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
  name: "ShowProfile",
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
      activeTab: '/profile/user_profile',
      tabs: [{
        id: 1,
        name: 'Profil používateľa',
        route: '/profile/user_profile'
      }],
    }
  },
  updated() {
    this.drawer = this.drawerNew;
  },
  methods: {}
}
</script>

<style type="scss">
.md-toolbar.md-large.md-dense {
  min-height: 64px !important;
}
</style>
