<template>
<div class="domov">
  <v-container>
    <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
      <v-row justify="center" class="m-0">
        <v-col class="p-0">
          <v-card class="rounded" elevation="0">
            <v-card-text>
              <span>Chata sa nachadza v byvalej lokalite kupelov byšta obklopena prekrasnou prirodou. Navšteva tokajskych pivnic. Termalne kupalisko 30 min autom. Možnost turistiky, hubarčenia, cykloturistiky, jazero vhodne na rybolov.</span>
            </v-card-text>

            <v-divider />

            <v-card-text>
              <h1 class="primary--text">Galéria</h1>
              <!-- <lightbox :cells="3" :items="images"></lightbox> -->
              <v-container class="m-0">
                <v-row>
                  <v-col v-for="(image, index) in media" :key="'media4' + index" class="d-flex child-flex container_images p-1" cols="12" lg="4" md="4" sm="6" style="overflow: hidden">
                    <v-card class="card_images" elevation="0" tile>
                      <v-img style="cursor: pointer" class="zoom" :lazy-src="image.thumb" :src="image.thumb" aspect-ratio="1.5" @click="openGallery(index)">
                        <template v-slot:placeholder>
                          <v-row class="fill-height ma-0" align="center" justify="center">
                            <v-progress-circular indeterminate color="primary"></v-progress-circular>
                          </v-row>
                        </template>
                      </v-img>
                    </v-card>
                  </v-col>
                  <LightBox ref="lightbox" :media="media" :show-caption="true" :show-light-box="false" closable />
                </v-row>
              </v-container>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-lazy>
  </v-container>
</div>
</template>
<script>
// import CoolLightBox from "vue-cool-lightbox";
// import "vue-cool-lightbox/dist/vue-cool-lightbox.min.css";
import LightBox from 'vue-it-bigger'
import('vue-it-bigger/dist/vue-it-bigger.min.css') // when using webpack

export default {
  name: "Domov",
  components: {
    LightBox,
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
      }, { // For an image
        type: 'image', // Can be omitted for image
        thumb: 'https://www.dropbox.com/s/s5hmidluzqcypaq/2.png?raw=1',
        src: 'https://www.dropbox.com/s/s5hmidluzqcypaq/2.png?raw=1',
        caption: '', // Optional
        srcset: 'https://www.dropbox.com/s/s5hmidluzqcypaq/2.png?raw=1' // Optional for displaying responsive images
      }, { // For an image
        type: 'image', // Can be omitted for image
        thumb: 'https://www.dropbox.com/s/pz0qzpgat025abr/3.png?raw=1',
        src: 'https://www.dropbox.com/s/pz0qzpgat025abr/3.png?raw=1',
        caption: '', // Optional
        srcset: 'https://www.dropbox.com/s/pz0qzpgat025abr/3.png?raw=1' // Optional for displaying responsive images
      }, { // For an image
        type: 'image', // Can be omitted for image
        thumb: 'https://www.dropbox.com/s/w4w55ibyhb7jlzq/4.png?raw=1',
        src: 'https://www.dropbox.com/s/w4w55ibyhb7jlzq/4.png?raw=1',
        caption: '', // Optional
        srcset: 'https://www.dropbox.com/s/w4w55ibyhb7jlzq/4.png?raw=1' // Optional for displaying responsive images
      }, { // For an image
        type: 'image', // Can be omitted for image
        thumb: 'https://www.dropbox.com/s/vlpeiff2fg5vcg0/5.png?raw=1',
        src: 'https://www.dropbox.com/s/vlpeiff2fg5vcg0/5.png?raw=1',
        caption: '', // Optional
        srcset: 'https://www.dropbox.com/s/vlpeiff2fg5vcg0/5.png?raw=1' // Optional for displaying responsive images
      }, ],
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
