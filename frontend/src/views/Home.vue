<template>
<div class="home w-100 h-100 mt-16">
  <v-tabs grow>
    <v-tab v-for="tab in tabs" :key="tab.id" :to="tab.route">{{ tab.name }}</v-tab>
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
  name: "Home",
  components: {},
  data() {
    return {
      username: localStorage.getItem("username"),
      tab: null,
      activeTab: '/home',
      overlay: false,
      tabs: [{
        id: 1,
        name: 'Domov',
        route: '/home'
      }, {
        id: 2,
        name: 'Lokalita',
        route: '/home/lokalita'
      }, {
        id: 3,
        name: 'Vybavenie',
        route: '/home/vybavenie'
      }, {
        id: 4,
        name: 'Recenzie',
        route: '/home/recenzie'
      }, ],
    }
  },
  updated() {
    this.drawer = this.drawerNew;
  },
  // computed: {
  //   test2Function() {
  //     console.log(this.test2Test2);
  //     return this.test2Test2;
  //   }
  // },

  methods: {
    updateRouter(tab) {
      this.$router.push(tab)
    },
  }
}
</script>
<style type="scss" scoped>
.page-container {
  min-height: 300px;
  overflow: hidden;
  position: relative;
  border: 1px solid rgba(#000, .12);
}

.md-toolbar {
  z-index: 5 !important;
}

.border-bottom {
  border-width: 2px;
}

.top-video {
  position: absolute;
  width: 50px;
  height: 25px;
  top: 0;
  background-color: #ff8c1a;
  z-index: 50;
  padding-top: 2px;
}

.rating-video {
  position: absolute;
  width: 50px;
  height: 25px;
  top: 0;
  right: 0;
  background-color: #2e3034;
  z-index: 50;
  padding-top: 2px;
}

.fa-heart {
  position: relative;
  top: 2px;
}

.md-card-media .play-video {
  position: absolute;
  right: 0;
  left: 0;
  top: 50%;
  transform: translate(0, -50%);
  color: rgb(255, 140, 26);
}

.phone-viewport {
  display: none;
  width: 100vw;
  position: fixed;
  bottom: 0;
  overflow: hidden;
  z-index: 50;
}

.md-speed-dial {
  display: block;
  position: fixed;
  bottom: 50px;
  right: -16px;
}

.menu-list .md-ripple {
  justify-content: unset !important;
}

.menu-list-position {
  width: 40px;
}

.menu .edit-profile .md-list-item-content {
  padding: 0px !important;
}

/* .tab-disabled-opacity {
  opacity: 0 !important;
}

#tab-disabled-opacity {
  opacity: 0 !important;
} */


/*  */
/* .v-tab--active {
  background-color: white;
} */

/* .v-ripple__container {
    opacity: 0
} */
.theme--light.v-tabs .v-tab:hover::before {
  opacity: 0 !important;
}

.theme--dark.v-tabs .v-tab:hover::before {
  opacity: 0 !important;
}

.v-toolbar__content button:focus {
  outline: 0px !important;
}
</style>
