<template>
<div class="welcome vh-100 p-3">
  <!-- SIGN CONTROLS -->
  <div class="sign-controls">
    <!-- SIGN IN -->
    <div class="login-content">
      <router-link :to="{ name: 'Login' }">
        <v-btn color="primary" class="text-uppercase font-weight-bold cursor-pointer text-decoration-none" elevation="2" x-large outlined rounded block>
          <v-icon class="pr-1">mdi-login</v-icon>Prihlásiť sa
        </v-btn>
      </router-link>
    </div>
    <div class="text pb-5">
    </div>
    <!-- GET STARTED -->
    <div class="register-content">
      <router-link :to="{ name: 'Register' }">
        <v-btn color="primary" class="text-uppercase font-weight-bold text-decoration-none" elevation="2" x-large rounded block>
          <v-icon class="pr-1">mdi-account-plus</v-icon>Zaregistrovať sa
        </v-btn>
      </router-link>
    </div>
  </div>

  <!-- content -->
  <div class="content verticalhorizontal">
    <v-row justify="center">
      <!-- <v-col> -->
      <div v-if="this.$vuetify.theme.dark">
        <img src="/img/logo_welcome_theme_dark.png" lazy-src="/img/logo_welcome_theme_dark.png" class="m-auto w-100" color="primary">
      </div>
      <div v-else>
        <img src="/img/logo_welcome_theme_light.png" lazy-src="/img/logo_welcome_theme_light.png" class="m-auto w-100" color="primary">
      </div>
      <!-- <img src="/img/logo.png" lazy-src="/img/logo3.png" class="m-auto w-100" color="primary"> -->
      <!-- </v-col> -->
      <!-- <v-col>
      <v-row>
        <h1 class="secondary-text font-weight-bold text-uppercase">Chata Byšta</h1>
      </v-row>
      <v-row>
        <h6 class="secondary-text">Ak pochopíš krásu prírody, nemôžeš zablúdiť</h6>
      </v-row>
    </v-col> -->
    </v-row>
  </div>
</div>
</template>

<script>
export default {
  name: "Welcome",
  components: {},
  data() {
    return {}
  },

  mounted() {
    //do something after mounting vue instance
    console.log('Component Register mounted.')
    this.$store.dispatch('mutationLogout', {
      username: '',
      logout: false
    });
  },

  created() {
    console.log('Component Register created')
  },
};
</script>

<style lang="css">
  .sign-controls {
    position: fixed;
    right: 15px;
    display: flex;
    flex-wrap: wrap;
    padding-top: 1rem;
  }
  .flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
  }
  .position-ref {
    position: relative;
  }
  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }
  .content {
    text-align: center;
    width: 85vw;
    margin: auto;
    display:flex;
    top: 30vh;
    position: relative;
    /* float: left; */
  }
  .login-content {
    padding: 0px 15px 0px 15px;
  }
  .register-content {
    padding: 0px 15px 0px 15px;
  }
  .text,
  .text2,
  .text3 {
    display: none;
  }

  .sign-controls button:focus {
    outline: unset !important;
  }
</style>
