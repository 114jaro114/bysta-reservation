<template>
<div class="hodnotenie w-100 h-100">
  <v-container>
    <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
      <v-row justify="center" class="ml-0 mr-0">
        <v-col class="p-0">
          <v-card class="rounded" elevation="0">
            <Rating />
          </v-card>
        </v-col>
      </v-row>
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
