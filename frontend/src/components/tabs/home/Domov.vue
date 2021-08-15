<template>
<div class="domov w-100 h-100">
  <v-container>
    <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
      <v-row justify="center" class="ml-0 mr-0">
        <v-col class="pl-3 pr-3">
          <v-card class="rounded" elevation="0">
            <!-- <v-toolbar class="rounded-top" color="primary" flat dark>
            <v-row align="center">
              <span>Chata sa nachadza v byvalej lokalite kupelov byšta obklopena prekrasnou prirodou. Navšteva tokajskych pivnic. Termalne kupalisko 30 min autom. Možnost turistiky, hubarčenia, cykloturistiky, jazero vhodne na rybolov.</span>
            </v-row>
          </v-toolbar> -->
            <v-card-text>
              <span>Chata sa nachadza v byvalej lokalite kupelov byšta obklopena prekrasnou prirodou. Navšteva tokajskych pivnic. Termalne kupalisko 30 min autom. Možnost turistiky, hubarčenia, cykloturistiky, jazero vhodne na rybolov.</span>
            </v-card-text>

            <v-divider />

            <v-card-text>
              <h1 class="primary--text">Galéria</h1>
              <!-- <v-container> -->
              <!-- <v-row v-if="isLoaded == false">
              <v-col cols="6" class="pr-0 pt-0">
                <v-skeleton-loader class="sl1" type="image" tile />
              </v-col>

              <v-col cols="6" class="pl-1 pt-0">
                <v-skeleton-loader class="sl-2" type="image" height="175" tile />
                <v-skeleton-loader class="sl-3 pt-1" type="image" height="175" tile />
              </v-col>
            </v-row> -->
              <!-- </v-container> -->
              <!-- <v-row> -->
              <lightbox :cells="3" :items="images"></lightbox>
              <!-- @load="onImgLoad" -->
              <!-- </v-row> -->

              <!-- <CoolLightBox :items="images" :index="index" :fullScreen="true" @close="index = null">
              </CoolLightBox>

              <div class="images-wrapper">
                <div class="image" v-for="(image, imageIndex) in images" :key="imageIndex" @click="index = imageIndex" :style="{ backgroundImage: 'url(' + image + ')' }"></div>
              </div> -->

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
export default {
  name: "Domov",
  components: {
    // CoolLightBox
  },
  data() {
    return {
      images: ["img/stiahnuť (1).png", "img/stiahnuť (2).png", "img/stiahnuť (3).png", "img/stiahnuť (4).png", "img/stiahnuť (1).png", "img/stiahnuť (2).png", "img/stiahnuť (3).png", "img/stiahnuť (4).png", "img/stiahnuť (1).png",
        "img/stiahnuť (2).png",
      ],
      index: null,

      // isLoaded: false,
    }
  },

  methods: {
    // onImgLoad() {
    //   this.isLoaded = true
    // },
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
