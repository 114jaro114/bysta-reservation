<template>
<v-app id="app" :style="{background: $vuetify.theme.themes[isDark].background}">
  <router-view />
</v-app>
</template>

<script>
// import HelloWorld from './components/HelloWorld.vue'

export default {
  name: 'App',
  created() {
    window.Echo.private('testchannel')
      .listen('Test', (e) => {
        console.log('test successful ' + e)
      })
  },
  computed: {
    isDark() {
      return (this.$vuetify.theme.dark) ? 'dark' : 'light'
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
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
