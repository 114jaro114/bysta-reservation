<template>
<div class="administration w-100 h-100 text-uppercase secondary-color">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-lazy v-model="isActive" :options="{
        threshold: .8
      }" min-height="100vh" transition-group="fade-transition">
    <v-card class="v-content">
      <v-toolbar elevation="2" class="mb-3">
        <v-app-bar-nav-icon :drawerNew="drawerNew" @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title class="position-absolute" style="right:14px">
          <span class="md-title font-weight-bold">
            <img class="logo2 align-middle" src="/img/logo2.png">
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
          <router-view></router-view>
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
import axios from 'axios';
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
      tab: null,
      items: ['Administrácia', ],
      isActive: false,
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
      axios.post(api, null, config).then((res) => {
        console.log(res);
        localStorage.removeItem("username");
        localStorage.removeItem("authToken");
        this.$router.push("/");
      }).catch(e => {
        console.log(e);
      })
    },
  }
}
</script>
<style type="scss">
.v-card.v-content {
  min-height: 100vh;
  border-radius: 0px;
}

.v-card {
  border-top-left-radius: unset !important;
  border-top-right-radius: unset !important;
}

.v-navigation-drawer {
  position: fixed !important;
  width: 300px !important;
  box-shadow: unset !important;
}

.v-overlay__scrim {
  position: fixed !important;
}
</style>
