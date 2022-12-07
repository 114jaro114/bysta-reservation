<template>
<div class="settings w-100 h-100 mt-16">

  <v-tabs grow>
    <v-tab v-for="tab in tabs" :key="tab.id" :to="tab.route" exact>{{ tab.name }}</v-tab>
  </v-tabs>

  <v-tabs-items v-model="activeTab" @change="updateRouter($event)" grow>
    <v-tab-item v-for="tab in tabs" :key="tab.id" :value="tab.route">
      <router-view />
    </v-tab-item>
  </v-tabs-items>
</div>
</template>

<script>
export default {
  name: "Settings",
  components: {},
  data() {
    return {
      username: localStorage.getItem("username"),
      tab: null,
      activeTab: '/settings',
      tabs: [{
        id: 1,
        name: 'Nastavenia',
        route: '/settings'
      }, {
        id: 2,
        name: 'Informácie',
        route: '/settings/info'
      }],
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

<style type="scss" scoped>
</style>
