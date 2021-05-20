<template>
<div class="messenger w-100 h-100">
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

    <v-tabs-items v-model="activeTab" grow>
      <v-tab-item v-for="tab in tabs" :key="tab.id" :value="tab.route">
        <!-- messenger -->
        <chat-app></chat-app>
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
      activeTab: '/messenger',
      tabs: [{
        id: 1,
        name: 'Messenger',
        route: '/messenger'
      }],
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
.md-toolbar.md-large.md-dense {
  min-height: 64px !important;
}
</style>
