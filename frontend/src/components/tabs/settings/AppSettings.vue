<template>
<div class="app_settings w-100 h-100 text-uppercase">
  <div class="row justify-content-center mr-0 ml-0">
    <div class="col pl-0 pr-0 mt-3">
      <div>
        <v-tooltip v-if="!$vuetify.theme.dark" bottom>
          <template v-slot:activator="{ on }">
            <!-- <v-btn v-on="on" small fab @click="darkMode">
              <v-icon class="mr-1">mdi-moon-waxing-crescent</v-icon>
            </v-btn> -->
            <v-btn icon v-on="on" @click="toggle_dark_mode">
              <v-icon>mdi-theme-light-dark</v-icon>
            </v-btn>
          </template>
          <span>Dark Mode On</span>
        </v-tooltip>

        <v-tooltip v-else bottom>
          <template v-slot:activator="{ on }">
            <!-- <v-btn v-on="on" small fab @click="darkMode">
              <v-icon>mdi-white-balance-sunny</v-icon>
            </v-btn> -->
            <v-btn icon v-on="on" @click="toggle_dark_mode">
              <v-icon>mdi-theme-light-dark</v-icon>
            </v-btn>
          </template>
          <span>Dark Mode Off</span>
        </v-tooltip>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  name: "AppSettings",
  components: {},
  data() {
    return {

    }
  },
  mounted() {
    const theme = localStorage.getItem("dark_theme");
    if (theme) {
      if (theme === "true") {
        this.$vuetify.theme.dark = true;
      } else {
        this.$vuetify.theme.dark = false;
      }
    } else if (
      window.matchMedia &&
      window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
      this.$vuetify.theme.dark = true;
      localStorage.setItem(
        "dark_theme",
        this.$vuetify.theme.dark.toString()
      );
    }
  },
  methods: {
    toggle_dark_mode() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      localStorage.setItem("dark_theme", this.$vuetify.theme.dark.toString());
    },
  }
}
</script>

<style type="scss">
</style>
