<template>
<div class="new w-100 h-100 text-uppercase mt-1">
  <v-lazy :options="{
            threshold: .8
          }" transition="fade-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <!-- <v-lazy v-model="isActive" :options="{
          threshold: .5
        }" min-height="200" transition="fade-transition"> -->
        <v-btn color="primary" icon width="170px" height="170px">
          <v-icon style="font-size: 150px">mdi-bell-cancel</v-icon>
        </v-btn>
        <!-- </v-lazy> -->
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>

<script>
export default {
  name: "New",
  components: {},
  data() {
    return {
      isActive: true,
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
