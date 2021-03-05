<template>
<div class="reset">
  <v-lazy :options="{
          threshold: .4
        }" min-height="100vh" transition-group="fade-transition">
    <ResetForm />
  </v-lazy>
</div>
</template>

<script>
// @ is an alias to /src
import ResetForm from "@/components/ResetForm.vue";

export default {
  name: "Reset",
  components: {
    ResetForm,
  },
};
</script>
