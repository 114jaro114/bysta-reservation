<template>
<div class="phone-viewport w-100" :style="test">
  <v-bottom-navigation color="secondary" :input-value="this.$store.getters['bottomNavigationState'].state" background-color="primary" app shift grow>
    <v-btn class="text-white" to="/home" value="home">
      <span class="text--white">Domov</span>
      <v-icon color="white">mdi-home</v-icon>
    </v-btn>
    <v-btn class="text-white" to="/administration" value="administration">
      <span>Administrácia</span>
      <v-icon color="white">mdi-clipboard-text</v-icon>
    </v-btn>
    <v-btn class="text-white" to="/reservation" value="reservation">
      <span>Rezervácia</span>
      <v-icon color="white">mdi-calendar-month</v-icon>
    </v-btn>
    <!-- <v-btn to="/messenger" value="messenger">
      <span>Messenger</span> -->
    <!-- <v-badge :content="num" :value="num" color="green" style="top:10px;" overlap bordered>
        <v-icon color="secondary">mdi-facebook-messenger</v-icon>
      </v-badge> -->
    <!-- <v-icon color="secondary">mdi-facebook-messenger</v-icon>
    </v-btn> -->
    <v-btn class="text-white" to="/settings" value="settings">
      <span>Nastavenia</span>
      <v-icon color="white">mdi-cog</v-icon>
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
      test: null,
    }
  },

  mounted() {
    //do something after mounting vue instance
    this.bottomNavigationStyle();

    if (JSON.parse(localStorage.getItem("bottom_navigation")) == true) {
      this.$store.dispatch('bottomNavigationState', {
        status: true
      });
    } else {
      this.$store.dispatch('bottomNavigationState', {
        status: false
      });
    }
  },

  updated() {
    //do something after updating vue instance
    this.bottomNavigationStyle();
  },

  methods: {
    bottomNavigationStyle() {
      if (window.innerWidth <= 480 && this.$store.getters['bottomNavigationState'].state == true) {
        this.test = 'margin-top:56px;display:block';
      } else {
        this.test = 'margin-top:0px;display:none';
      }
      window.addEventListener('resize', () => {
        if (window.innerWidth <= 480 && this.$store.getters['bottomNavigationState'].state == true) {
          this.test = 'margin-top:56px;display:block';
        } else {
          this.test = 'margin-top:0px;display:none';
        }
      });
    }
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
/* .bottom-nav {
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
} */

.v-bottom-navigation {
  z-index: 12 !important;
}

.phone-viewport .v-btn:not(.v-btn--round).v-size--default {
  height: 56px !important;
  min-width: 0 !important;
  padding: 0 !important;
}
</style>
