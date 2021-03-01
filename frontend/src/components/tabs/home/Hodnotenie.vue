<template>
<div class="hodnotenie w-100 h-100 text-uppercase secondary-color">
  <v-lazy v-model="isActive" :options="{
          threshold: .5
        }" min-height="200" transition="fade-transition">
    <v-card class="mx-auto">
      <Rating />
    </v-card>
  </v-lazy>
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
