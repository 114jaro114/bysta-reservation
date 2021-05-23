<template>
<div class="user_profile w-100 h-100">
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

    <v-tabs-items class="pt-3 pt-lg-5 pt-md-5" v-model="activeTab" grow>
      <v-tab-item v-for="tab in tabs" :key="tab.id" :value="tab.route">
        <router-view />
      </v-tab-item>
      <NavigationDrawer :drawer="drawer" />
    </v-tabs-items>
  </v-card>
</div>
</template>

<script>
import NavigationDrawer from "@/components/NavigationDrawer.vue";
export default {
  name: "ShowProfile",
  components: {
    NavigationDrawer,
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
