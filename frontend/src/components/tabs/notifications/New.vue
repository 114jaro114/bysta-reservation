<template>
<div class="new w-100 h-100 text-uppercase">
  <v-row justify="center" class="ml-0 mr-0">
    <v-col>
      <v-btn color="primary" icon width="170px" height="170px">
        <v-icon loading style="font-size: 150px">mdi-bell-cancel</v-icon>
      </v-btn>
    </v-col>
  </v-row>
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
