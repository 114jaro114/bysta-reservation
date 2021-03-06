<template>
<div class="hodnotenie w-100 h-100 text-uppercase mt-1">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col>
        <v-card>
          <Rating />
        </v-card>
      </v-col>
    </v-row>
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
