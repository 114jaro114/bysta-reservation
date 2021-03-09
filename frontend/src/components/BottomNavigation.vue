<template>
<div class="phone-viewport w-100 m-auto">
  <!-- v-model="value" -->
  <v-bottom-navigation color="secondary" :input-value="activeBottomNavigation" background-color="primary" shift grow>
    <v-btn to="/home" value="home">
      <span>Domov</span>
      <v-icon color="secondary">mdi-home</v-icon>
    </v-btn>
    <v-btn to="/administration" value="administration">
      <span>Administrácia</span>
      <v-icon color="secondary">mdi-clipboard-text</v-icon>
    </v-btn>
    <v-btn to="/reservation" value="reservation">
      <span>Rezervácia</span>
      <v-icon color="secondary">mdi-calendar-month</v-icon>
    </v-btn>
    <v-btn to="/messenger" value="messenger">
      <span>Messenger</span>
      <!-- <v-badge :content="num" :value="num" color="green" style="top:10px;" overlap bordered>
        <v-icon color="secondary">mdi-facebook-messenger</v-icon>
      </v-badge> -->
      <v-icon color="secondary">mdi-facebook-messenger</v-icon>
    </v-btn>
    <v-btn to="/settings" value="settings">
      <span>Nastavenia</span>
      <v-icon color="secondary">mdi-cog</v-icon>
    </v-btn>
  </v-bottom-navigation>

  <!-- {{value}}
  <v-bottom-navigation shift v-model="value">
    <v-btn value="recent">
      <span>Recent</span>

      <v-icon>mdi-history</v-icon>
    </v-btn>

    <v-btn value="carro">
      <span>Carrito</span>
      <v-badge dot overlap color="green" style="top:10px">
        <v-icon>mdi-cart-outline</v-icon>
      </v-badge>
    </v-btn>

    <v-btn value="nearby">
      <span>Nearby</span>

      <v-icon>mdi-map-marker</v-icon>
    </v-btn>
  </v-bottom-navigation> -->
</div>
</template>

<script>
export default {
  data() {
    return {
      value: '',
      num: 5,
      activeBottomNavigation: true
    }
  },
  methods: {
    // home() {
    //   this.$router.push('/home');
    // },
    // messenger() {
    //   this.$router.push('/messenger');
    // },
    // reservation() {
    //   this.$router.push('/reservation');
    // },
    // administration() {
    //   this.$router.push('/administration');
    // },
    // settings() {
    //   this.$router.push('/settings');
    // },
  }
}
</script>

<style>
.bottom-nav {
  .btn:not(.btn--active) {
    filter: none;
    opacity: 1;

    i,
    span:first-child {
      filter: grayscale(100%);
      opacity: 0.5;
    }

    .badge__badge {
      span {
        filter: none;
        opacity: 1;
      }
    }
  }
}
</style>
