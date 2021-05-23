<template>
<div class="about_us w-100 h-100">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col class="pl-3 pr-3">
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
                <v-tab v-for="item in items" :key="item">
                  {{ item }}
                </v-tab>
              </v-tabs>
            </template>
          </v-app-bar>

          <v-tabs-items v-model="tab" class="pt-3 pt-lg-5 pt-md-5">
            <v-tab-item v-for="item in items" :key="item">
            </v-tab-item>
            <NavigationDrawer :drawer="drawer" />
            <v-card class="rounded" elevation="0">
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
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>
<script>
import NavigationDrawer from "@/components/NavigationDrawer.vue";
export default {
  name: "AboutUs",
  components: {
    NavigationDrawer,
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

.v-navigation-drawer {
  position: fixed !important;
  width: 300px !important;
  box-shadow: unset !important;
}

.v-overlay__scrim {
  position: fixed !important;
}
</style>
