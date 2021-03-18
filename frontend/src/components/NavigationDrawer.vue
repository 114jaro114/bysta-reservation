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
        <v-badge :content="this.$store.getters['notificationCounter']" :value="this.$store.getters['notificationCounter']" color="orange" overlap bordered>
          <v-icon>mdi-bell</v-icon>
        </v-badge>
        <v-list-item-title>Notifikácie</v-list-item-title>
      </v-list-item>
      <v-list-item to="/administration">
        <v-icon>mdi-clipboard-text</v-icon>
        <v-list-item-title>Administrácia</v-list-item-title>
      </v-list-item>
      <v-list-item to="/reservation">
        <v-icon>mdi-calendar-month</v-icon>
        <v-list-item-title>Rezervácia</v-list-item-title>
      </v-list-item>
      <v-list-item to="/messenger">
        <v-badge :content="messages" :value="messages" color="primary" overlap bordered>
          <v-icon>mdi-facebook-messenger</v-icon>
        </v-badge>
        <v-list-item-title>Messenger</v-list-item-title>
      </v-list-item>
      <v-list-item to="/price_list">
        <v-icon>mdi-credit-card</v-icon>
        <v-list-item-title>Cenník</v-list-item-title>
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

  <template v-slot:append>
    <v-divider class="mb-2 mt-0"></v-divider>
    <v-list-item>
      <v-btn color="primary" @click="messages++" block>
        Send Message
      </v-btn>
    </v-list-item>

    <v-list-item>
      <v-btn color="error" @click="messages = 0" block>
        Clear Notifications
      </v-btn>
    </v-list-item>
    <v-list-item>
      <v-btn color="accent" @click="messages = 0; logout()" block>
        Odhlásiť sa
      </v-btn>
    </v-list-item>
  </template>
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
</template>
<script>
import axios from 'axios'
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

      // badge
      messages: 0,
      show: false,
      notifications: 5,
    }
  },
  computed: {
    drawer2() {
      return this.drawer;
    },
  },
  methods: {
    logout() {
      this.$emit('childToParent', 'true');
      const api = 'http://127.0.0.1:8000/api/auth/logout';
      const config = {
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken"),
        },
      };
      axios.post(api, null, config)
        .then((res) => {
          this.$emit('childToParent', 'false');
          console.log(res);
          this.$store.dispatch('isLoggedOut', {
            username: localStorage.getItem("username"),
            logout: true
          });
          localStorage.removeItem("username");
          localStorage.removeItem("authToken");
          this.$router.push("/login");
        })
        .catch(e => {
          this.$emit('childToParent', 'false'),
            console.log(e);
        })
    },
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
  color: #21CFF3;
}

.v-list-item-group .v-list-item--active.theme--light {
  color: #0D47A1;
}

.v-navigation-drawer:not(.v-navigation-drawer--floating) .v-navigation-drawer__border {
  background-color: unset !important;
}
</style>
