<template id="NavigationDrawer">
<v-navigation-drawer :value="drawer2" absolute temporary>
  <v-list-item class="px-2">
    <v-list-item-avatar size="52" class="mr-0 ml-0" style="left:8px;">
      <AvatarImageComponent />
    </v-list-item-avatar>
    <v-list-item class="pl-5">
      <span class="font-weight-bold">{{ username }}</span>
    </v-list-item>
  </v-list-item>
  <!-- <v-list-item>
      <v-list-item-title>
        <v-btn block color="primary" to="/profile">
          {{ username }}
          <v-icon dark right>
            mdi-pencil-circle-outline
          </v-icon>
        </v-btn>
      </v-list-item-title>
    </v-list-item> -->
  <v-divider class="mb-0 mt-0"></v-divider>
  <v-list nav dense>
    <v-list-item-group v-model="group" active-class="deep-blue--text text--accent-4">
      <v-list-item to="/home">
        <v-icon>mdi-home</v-icon>
        <v-list-item-title>Home</v-list-item-title>
      </v-list-item>
      <v-list-item to="/notifications">
        <v-icon>mdi-bell</v-icon>
        <v-list-item-title>Notifikácie</v-list-item-title>
      </v-list-item>
      <v-list-item to="/administration">
        <v-icon>mdi-clipboard-text</v-icon>
        <v-list-item-title>Administrácia</v-list-item-title>
      </v-list-item>
      <v-list-item to="/reservation">
        <v-icon>mdi-calendar-month</v-icon>
        <v-list-item-title>Rezervácie</v-list-item-title>
      </v-list-item>
      <v-list-item to="/messenger">
        <v-icon>mdi-facebook-messenger</v-icon>
        <v-list-item-title>Messenger</v-list-item-title>
      </v-list-item>
      <v-list-item to="/settings">
        <v-icon>mdi-cog</v-icon>
        <v-list-item-title>Nastavenia</v-list-item-title>
      </v-list-item>
      <v-list-item to="/about_us">
        <v-icon>mdi-information</v-icon>
        <v-list-item-title>O nás</v-list-item-title>
      </v-list-item>
    </v-list-item-group>
  </v-list>
</v-navigation-drawer>
</template>
<script>
import AvatarImageComponent from "@/components/AvatarImageComponent.vue";
export default {
  name: "NavigationDrawer",
  components: {
    AvatarImageComponent,
  },
  props: ['drawer'],
  data() {
    return {
      username: localStorage.getItem("username"),
      drawerNew: false,
      group: null,
    }
  },
  computed: {
    drawer2() {
      return this.drawer;
    },
  },
  methods: {
    // childToParentFunction(param) {
    //   console.log
    //   console.log("cau: ");
    // },
  }
}
</script>
<style type="scss">
.v-navigation-drawer {
  position: fixed !important;
  width: 300px !important;
  box-shadow: unset !important;
}

.v-overlay__scrim {
  position: fixed !important;
}

#SidebarNavigation .theme--dark.v-icon {
  color: red !important;
}

.v-list-item-group .theme--dark.v-list-item--active {
  color: #21CFF3;
}

.v-list-item-group .v-list-item--active.theme--light {
  color: #0D47A1;
}
</style>
