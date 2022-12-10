<template id="NavigationDrawer">
<div>
  <v-overlay v-if="overlayLogout == true" :value="overlayLogout" style="background: rgba(255,255,255,0.5);backdrop-filter: blur(5px);z-index:6">
    <span class="mr-3">Prebieha odhlásenie</span>
    <v-progress-circular indeterminate size="24" color="white"></v-progress-circular>
  </v-overlay>

  <v-navigation-drawer class="mt-16" :value="drawer2" absolute temporary>
    <v-list class="text-uppercase" nav dense>
      <v-list-item-group v-model="group" active-class="primary--text text--accent-4">
        <v-list-item to="/home">
          <v-icon>mdi-home</v-icon>
          <v-list-item-title>Domov</v-list-item-title>
        </v-list-item>
        <v-list-item to="/notifications">
          <v-badge :content="this.$store.getters['notificationCounter']" :value="this.$store.getters['notificationCounter']" color="orange" overlap bordered>
            <v-icon>mdi-bell</v-icon>
          </v-badge>
          <v-list-item-title>Notifikácie</v-list-item-title>
        </v-list-item>
        <v-list-item to="/administration">
          <v-badge :content="this.$store.getters['reservationCounter']" :value="this.$store.getters['reservationCounter']" color="orange" overlap bordered>
            <v-icon>mdi-clipboard-text</v-icon>
          </v-badge>
          <v-list-item-title>Administrácia</v-list-item-title>
        </v-list-item>
        <v-list-item to="/reservation">
          <v-icon>mdi-calendar-month</v-icon>
          <v-list-item-title>Rezervácia</v-list-item-title>
        </v-list-item>
        <v-list-item to="/messenger">
          <v-badge :content="this.$store.getters['msgUnreadCounter']" :value="this.$store.getters['msgUnreadCounter']" color="orange" overlap bordered>
            <v-icon>mdi-facebook-messenger</v-icon>
          </v-badge>
          <v-list-item-title>Messenger</v-list-item-title>
        </v-list-item>
        <v-list-item to="/saved_reservations">
          <v-badge :content="this.$store.getters['savedReservationCounter']" :value="this.$store.getters['savedReservationCounter']" color="orange" overlap bordered>
            <v-icon>mdi-content-save-edit</v-icon>
          </v-badge>

          <v-list-item-title>Uložené rezervácie</v-list-item-title>
        </v-list-item>
        <v-list-item to="/price_list">
          <v-icon>mdi-credit-card</v-icon>
          <v-list-item-title>Cenník</v-list-item-title>
        </v-list-item>
        <v-list-item to="/settings">
          <v-icon>mdi-cog</v-icon>
          <v-list-item-title>Nastavenia</v-list-item-title>
        </v-list-item>
        <v-list-item to="/contact">
          <v-icon>mdi-account-box</v-icon>
          <v-list-item-title>Kontakt</v-list-item-title>
        </v-list-item>
      </v-list-item-group>
    </v-list>

    <!-- <template v-slot:append> -->
    <!-- <v-divider class="mb-2 mt-0"></v-divider> -->
    <!-- <v-list-item>
      <v-btn color="primary" @click="messages++" block>
        Send Message
      </v-btn>
    </v-list-item>

    <v-list-item>
      <v-btn color="error" @click="messages = 0" block>
        Clear Notifications
      </v-btn>
    </v-list-item> -->
    <!-- <v-list-item>
        <v-btn color="accent" @click="logout()" block>
          <v-icon class="background--text mr-1">mdi-logout</v-icon><span class="background--text">Odhlásiť sa</span>
        </v-btn>
      </v-list-item> -->
    <!-- </template> -->
    <!-- <template v-slot:append>
    <v-list-item link @click="logout">
      <v-list-item-icon>
        <v-icon>logout</v-icon>
      </v-list-item-icon>

      <v-list-item-content>
        <v-list-item-title>
          logout
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </template> -->
  </v-navigation-drawer>
</div>
</template>
<script>
// import axios from 'axios'
// import AvatarImageComponent from "@/components/AvatarImageComponent.vue";
export default {
  name: "NavigationDrawer",
  components: {
    // AvatarImageComponent,
  },
  props: ['drawer'],
  data() {
    return {
      username: localStorage.getItem("username"),
      drawerNew: false,
      group: null,
      // badge
      show: false,
      overlayLogout: false,
    }
  },
  computed: {
    drawer2() {
      return this.drawer;
    },
  },
  methods: {
    // logout() {
    //   this.overlayLogout = true;
    //   this.$emit('childToParent', 'true');
    //   const api = `${process.env.VUE_APP_API_URL}/auth/logout`;
    //   const config = {
    //     headers: {
    //       Accept: "application/json",
    //       Authorization: "Bearer " + localStorage.getItem("authToken"),
    //     },
    //   };
    //   axios.post(api, null, config)
    //     .then(() => {
    //       window.location.href = "/login";
    //       this.$emit('childToParent', 'false');
    //       localStorage.setItem('logout', true);
    //       localStorage.removeItem("user_id");
    //       localStorage.removeItem("authToken");
    //       this.overlayLogout = false;
    //     })
    //     .catch((e) => {
    //       console.log(e);
    //     })
    // },
  }
}
</script>
<style type="scss">
.v-navigation-drawer {
  position: fixed !important;
  width: 300px !important;
  box-shadow: unset !important;
  z-index: 51 !important;
}

.v-navigation-drawer__append {
  /* margin-bottom: 64px; */
  margin-bottom: 6px;

}

.v-overlay__scrim {
  position: fixed !important;
}

#SidebarNavigation .theme--dark.v-icon {
  color: red !important;
}

.v-list-item-group .theme--dark.v-list-item--active {
  color: #0D47A1;
}

.v-list-item-group .v-list-item--active.theme--light {
  color: #0D47A1;
}

.v-navigation-drawer:not(.v-navigation-drawer--floating) .v-navigation-drawer__border {
  background-color: unset !important;
}
</style>
