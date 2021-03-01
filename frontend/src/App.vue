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
  }
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
