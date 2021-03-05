<template>
<div class="messenger w-100 h-100 text-uppercase secondary-color">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="fade-transition">
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
          <v-tabs v-model="tab" grow>
            <v-tab v-for="item in items" :key="item">
              {{ item }}
            </v-tab>
          </v-tabs>
        </template>
      </v-toolbar>

      <v-tabs-items grow v-model="tab">
        <v-tab-item v-for="item in items" :key="item">
          <!-- messenger -->
          <chat-app></chat-app>
        </v-tab-item>
        <NavigationDrawer :drawer="drawer" />
      </v-tabs-items>
    </v-card>

    <SpeedDial />

    <BottomNavigation />
    <Footer />
  </v-lazy>
</div>
</template>

<script>
import axios from 'axios';
import Footer from "../components/Footer.vue";
import ChatApp from "../components/messenger/ChatApp.vue";
import SpeedDial from "@/components/SpeedDial.vue";
import NavigationDrawer from "@/components/NavigationDrawer.vue";
import BottomNavigation from "@/components/BottomNavigation.vue";
export default {
  name: "Messenger",
  components: {
    Footer,
    ChatApp,
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
      items: [
        'Messenger',
      ],
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
  methods: {
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
