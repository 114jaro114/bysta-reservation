<template>
<div class="administration w-100 h-100 mt-16">
  <v-tabs grow optional>
    <v-tab :to="tabs[0].route" exact>
      <v-badge :content="$store.getters['reservationCounter']" :value="$store.getters['reservationCounter']" color="orange">
        {{tabs[0].name}}
      </v-badge>
    </v-tab>
    <v-tab :to="tabs[1].route">
      {{tabs[1].name}}
    </v-tab>
    <v-tab :to="tabs[2].route" v-if="$root.me.name == 'admin'">
      {{tabs[2].name}}
    </v-tab>
  </v-tabs>

  <v-tabs-items v-model="activeTab" @change="updateRouter($event)" grow touchless>
    <v-tab-item :key="tabs[0].id" :value="tabs[0].route">
      <router-view />
    </v-tab-item>

    <v-tab-item :key="tabs[1].id" :value="tabs[1].route">
      <router-view />
    </v-tab-item>

    <v-tab-item :key="tabs[2].id" :value="tabs[2].route" v-if="$root.me.name == 'admin'">
      <router-view />
    </v-tab-item>
  </v-tabs-items>
</div>
</template>
<script>
export default {
  name: "Administration",
  components: {},
  data() {
    return {
      tab: null,
      activeTab: '/administration',
      tabs: [{
        id: 1,
        name: 'Administrácia',
        route: '/administration'
      }, {
        id: 2,
        name: 'Detaily',
        route: '/administration/details'
      }, {
        id: 3,
        name: 'Ceny',
        route: '/administration/prices'
      }, ],
    }
  },


  updated() {},

  methods: {
    updateRouter(tab) {
      this.$router.push(tab)
    },
  }
}
</script>
<style type="scss">
/*
.v-navigation-drawer {
  position: fixed !important;
  width: 300px !important;
  box-shadow: unset !important;
}

.v-overlay__scrim {
  position: fixed !important;
} */
</style>
