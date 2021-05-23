<template>
<div class="profile w-100 h-100">
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

    <v-tabs-items class="pt-3 pt-lg-5 pt-md-5" v-model="activeTab" @change="updateRouter($event)" grow>
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
  name: "Profile",
  components: {
    NavigationDrawer,
  },
  data() {
    return {
      username: localStorage.getItem("username"),
      drawer: false,
      tab: null,
      activeTab: '/profile',
      tabs: [{
        id: 1,
        name: 'Môj profil',
        route: '/profile'
      }, {
        id: 2,
        name: 'Pridať priateľa',
        route: '/profile/add_friends'
      }, {
        id: 3,
        name: 'Zoznam priateľov',
        route: '/profile/friend_list'
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
  }
}
</script>

<style type="scss">
.md-toolbar.md-large.md-dense {
  min-height: 64px;
}

.profile {
  position: unset !important;
  left: 0 !important;
  top: 0 !important;
}
</style>
