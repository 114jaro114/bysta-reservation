<template>
<div class="hodnotenie w-100 h-100 text-uppercase mt-1">
  <v-row justify="center" class="ml-0 mr-0">
    <v-col>
      <!-- <v-lazy v-model="isActive" :options="{
          threshold: .5
        }" min-height="200" transition="fade-transition"> -->
      <!-- <v-card> -->
      <Rating />
      <!-- </v-card> -->
      <!-- </v-lazy> -->
    </v-col>
  </v-row>
</div>
</template>
<script>
import Rating from "@/components/Rating.vue";
export default {
  name: "Hodnotenie",
  components: {
    Rating
  },
  data() {
    return {
      isActive: false,
    }
  },
}
</script>
<style lang="scss">
</style>
