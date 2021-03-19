<template>
<div class="about_us w-100 h-100 text-uppercase secondary-color">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <v-lazy :options="{
        threshold: .4
      }" min-height="100vh" transition-group="scale-transition">
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
          <v-tabs grow>
            <v-tab v-for="item in items" :key="item">
              {{ item }}
            </v-tab>
          </v-tabs>
        </template>
      </v-toolbar>
      <v-tabs-items v-model="tab" class="p-3 pt-1">
        <v-tab-item v-for="item in items" :key="item">
        </v-tab-item>
        <NavigationDrawer :drawer="drawer" />
        <v-card>
          <v-img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" height="200px"></v-img>
          <v-card-title> Chata byšta </v-card-title>
          <v-card-subtitle> 1,000 miles of wonder </v-card-subtitle>
          <v-card-actions>
            <!-- <v-btn color="orange lighten-2" text> Explore </v-btn> -->
            <v-spacer></v-spacer>
            <v-btn icon @click="show = !show">
              <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
            </v-btn>
          </v-card-actions>
          <v-expand-transition>
            <div v-show="show">
              <v-divider></v-divider>
              <v-card-text> I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a
                one
                and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape. </v-card-text>
            </div>
          </v-expand-transition>
        </v-card>
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
  name: "AboutUs",
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
      items: ['O nás', ],
      show: false,
    }
  },
  updated() {
    this.drawer = this.drawerNew;
  },
  methods: {}
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
