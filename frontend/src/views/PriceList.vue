<template>
<div class="price_list w-100 h-100 text-uppercase secondary-color">
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
            <v-tab v-for="item in items" :key="item">
              {{ item }}
            </v-tab>
          </v-tabs>
        </template>
      </v-toolbar>
      <v-tabs-items v-model="tab" class="p-3 pt-1">
        <v-tab-item v-for="item in items" :key="item" disabled>
        </v-tab-item>
        <NavigationDrawer :drawer="drawer" />
        <v-card>
          <v-card-text>
            <v-row>
              <v-col>
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <span>asd</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon large>mdi-bed-double</v-icon>
                    <v-icon large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span>1 manželská posteľ</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span>1 jednolôžková posteľ</span>
                  </v-row>
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet class="p-4 mx-auto" rounded outlined>
                  <v-row class="justify-center">
                    <span>asd</span>
                  </v-row>
                  <v-row class="justify-center">
                    <v-icon large>mdi-bed-double</v-icon>
                    <v-icon large>mdi-bed-single</v-icon>
                  </v-row>
                  <v-row class="justify-center">
                    <span>1 manželská posteľ</span>
                  </v-row>
                  <v-row class="justify-center">
                    <span>1 jednolôžková posteľ</span>
                  </v-row>
                </v-sheet>
              </v-col>
            </v-row>
          </v-card-text>
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
  name: "PriceList",
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
      items: ['Cenník'],
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
