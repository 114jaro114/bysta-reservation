<template>
<div class="settings w-100 h-100 text-uppercase secondary-color">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-card class="v-content">
    <v-toolbar elevation="2" class="mb-3">
      <v-app-bar-nav-icon :drawerNew="drawerNew" @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title class="position-absolute" style="right:14px">
        <span class="md-title font-weight-bold" v-if="this.$vuetify.theme.dark">
          <img class="logo2 align-middle" src="/img/logo_home_theme_dark.png">
        </span>
        <span class="md-title font-weight-bold" v-else>
          <img class="logo2 align-middle" src="/img/logo_home_theme_light.png">
        </span>
      </v-toolbar-title>
      <template v-slot:extension>
        <v-tabs grow class="tabs" v-model="activeTab">
          <v-tab v-for="tab in tabs" :key="tab.id" :to="tab.route" exact>{{ tab.name }}</v-tab>
        </v-tabs>
      </template>
    </v-toolbar>
    <v-tabs-items grow v-model="activeTab" @change="updateRouter($event)">
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
import axios from 'axios';
import Footer from "../components/Footer.vue";
import SpeedDial from "@/components/SpeedDial.vue";
import NavigationDrawer from "@/components/NavigationDrawer.vue";
import BottomNavigation from "@/components/BottomNavigation.vue";
export default {
  name: "Settings",
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
      activeTab: '/settings',
      tabs: [{
        id: 1,
        name: 'Informácie',
        route: '/settings'
      }, {
        id: 2,
        name: 'Nastavenia',
        route: '/settings/app_settings'
      }],
    }
  },
  updated() {
    this.drawer = this.drawerNew;
  },
  methods: {
    updateRouter(tab) {
      this.$router.push(tab)
    },

    logout() {
      const api = 'http://127.0.0.1:8000/api/auth/logout';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };

      axios.post(api, null, config)
        .then((res) => {
          console.log(res);
          localStorage.removeItem("username");
          localStorage.removeItem("authToken");
          this.$router.push("/");
        })
        .catch(e => {
          console.log(e);
        })
    },
  }
}
</script>

<style type="scss">
.md-toolbar.md-large.md-dense {
  min-height: 64px !important;
}
</style>
