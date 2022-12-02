<template>
<div class="settings w-100 h-100">
  <v-card>
    <v-tabs grow class="mt-16">
      <v-tab v-for="tab in tabs" :key="tab.id" :to="tab.route" exact>{{ tab.name }}</v-tab>
    </v-tabs>

    <v-card-text class="p-0 text-center">
      <v-tabs-items class="pt-3 pt-lg-5 pt-md-5" v-model="activeTab" @change="updateRouter($event)" grow>
        <v-tab-item v-for="tab in tabs" :key="tab.id" :value="tab.route">
          <router-view />
        </v-tab-item>
      </v-tabs-items>
    </v-card-text>
  </v-card>
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
