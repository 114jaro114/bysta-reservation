<template>
<div class="hodnotenie">
  <v-container>
    <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
      <Rating />
    </v-lazy>
  </v-container>
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
