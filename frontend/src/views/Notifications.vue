<template>
<div class="notifications w-100 h-100 mt-16">
  <v-tabs grow>
    <v-tab :to="tabs[0].route" exact>
      Všetky
    </v-tab>
    <v-tab :to="tabs[1].route">
      <v-badge :content="$store.getters['notificationCounter']" :value="$store.getters['notificationCounter']" color="orange">
        Nové
      </v-badge>
    </v-tab>
    <v-tab :to="tabs[2].route">
      Uložené
    </v-tab>
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
  name: "Notifcations",
  components: {},
  data() {
    return {
      username: localStorage.getItem("username"),
      tab: null,
      activeTab: '/notifications',
      tabs: [{
        id: 1,
        name: 'Všetky',
        route: '/notifications'
      }, {
        id: 2,
        name: 'Nové',
        route: '/notifications/new'
      }, {
        id: 3,
        name: 'Dôležité',
        route: '/notifications/saved'
      }],
      notifications: null,
    }
  },
  updated() {
    this.notifications = this.$store.getters['notificationCounter'];
  },

  methods: {
    updateRouter(tab) {
      this.$router.push(tab)
    },
  }
}
</script>
<style type="scss" scoped>

</style>
