<template>
<div class="reservation w-100 h-100 mt-16">
  <div class="pt-3 pt-lg-5 pt-md-5">
    <CreateReservation />
  </div>
</div>
</template>

<script>
import CreateReservation from "@/components/CreateReservation.vue";
export default {
  name: "Reservation",
  components: {
    CreateReservation,
  },
  data() {
    return {}
  },
  updated() {},
  methods: {}
}
</script>

<style type="scss" scoped>

</style>
