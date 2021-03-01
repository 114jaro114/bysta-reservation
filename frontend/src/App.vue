<template>
  <v-app id="app">
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
