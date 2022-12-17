<template>
<div class="prispevky">
  <Posts />
</div>
</template>
<script>
import Posts from "@/components/Posts.vue";
// import LightBox from 'vue-it-bigger'
// import('vue-it-bigger/dist/vue-it-bigger.min.css') // when using webpack

export default {
  name: "Prispevky",
  components: {
    // LightBox,
    Posts,
  },
  data() {
    return {
      index: null,
      media: [{ // For an image
        type: 'image', // Can be omitted for image
        thumb: 'https://www.dropbox.com/s/rtsy3zfcloqipjx/1.png?raw=1',
        src: 'https://www.dropbox.com/s/rtsy3zfcloqipjx/1.png?raw=1',
        caption: '', // Optional
        srcset: 'https://www.dropbox.com/s/rtsy3zfcloqipjx/1.png?raw=1' // Optional for displaying responsive images
      }],
    }
  },

  methods: {
    openGallery(index) {
      this.$refs.lightbox.showImage(index)
    },
  }
}
</script>
<style lang="scss">
.silentbox-item {
    border-radius: 0.5rem;
    margin-right: 1rem;
    overflow: hidden;
}

.lb-grid {
    height: 350px;
}

.btn-outline-danger,
.btn-outline-primary {
    border-color: unset !important;
    background-color: unset !important;
    border: unset !important;
}

.btn-outline-danger:focus,
.btn-outline-primary:focus {
    box-shadow: unset !important;
}

.fa-times {
    font-size: 20px;
}

.fa-angle-right:hover::before {
    animation-duration: 1s !important;
    animation-iteration-count: infinite !important;
    animation-name: pulsingNext !important;
}

.lb-item:hover {
    opacity: 0.9;
}

.v-card .theme--dark .lb-item {
    border-top: 5px solid #1E1E1E !important;
    border-right: 5px solid #1E1E1E !important;
    /* border-top-left-radius: 20px;
  border-bottom-left-radius: 20px; */
}

.v-card .theme--light .lb-item {
    // border-top: 5px solid #ffffff !important;
    // border-right: 5px solid #ffffff !important;
    padding: 0.25rem;
    /* border-top-left-radius: 20px;
  border-bottom-left-radius: 20px; */
}

.v-skeleton-loader__image {
    height: 350px !important;
}

.lb-modal {
    background-color: rgba(0, 0, 0, .9) !important;
}

.image {
    width: 150px;
    height: 150px;
    margin: 0 auto;
}
</style>
