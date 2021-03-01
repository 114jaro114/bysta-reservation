<template>
  <div class="new w-100 h-100 text-uppercase secondary-color">
    <md-empty-state class="md-accend mt-3" md-rounded>
      <!-- <md-icon class="primary-color">notifications_active</md-icon> -->
      <i class="fas fa-bell fa-9x primary-color pb-3"></i>
      <span class="font-weight-bold text-uppercase primary-color">Nothing new</span>
    </md-empty-state>
  </div>
</template>

<script>
  export default {
    name: "New",
    components: {},
    data() {
      return {

      }
    },
  }
</script>

<style type="scss">
  /* .md-empty-state {
    margin-top: 5rem !important;
  } */
  @media only screen and (max-width: 550px) {
    .md-empty-state {
      width: 250px !important;
      height: 250px !important;
      padding: 0 !important;
    }
  }
</style>
