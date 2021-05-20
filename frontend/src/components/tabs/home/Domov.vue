<template>
<div class="domov w-100 h-100 mt-3">
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
            <!-- <v-skeleton-loader v-bind="attrs" type="image image"></v-skeleton-loader> -->
            <lightbox :cells="3" :items="images"></lightbox>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-lazy>
</div>
</template>
<script>
// import Lightbox from '@morioh/v-lightbox'
export default {
  name: "Domov",
  components: {},
  data() {
    return {
      images: ["img/stiahnuť (1).png", "img/stiahnuť (2).png", "img/stiahnuť (3).png", "img/stiahnuť (4).png", "img/stiahnuť (1).png", "img/stiahnuť (2).png", "img/stiahnuť (3).png", "img/stiahnuť (4).png", "img/stiahnuť (1).png",
        "img/stiahnuť (2).png",
      ],
      gallery: [{
        src: 'img/stiahnuť (1).png',
        description: 'Star Night Sky Ravine by Mark Basarab, from Unsplash.',
        alt: 'Blue starry night photo.',
        // thumbnailWidth: '260px'
      }, {
        src: 'img/stiahnuť (2).png',
        description: 'Corno Nero, Italy by Luca Zanon, from Unsplash.',
        alt: 'Landscape photo of mountain with fog.',
        // thumbnailWidth: '260px'
      }, {
        src: 'img/stiahnuť (3).png',
        description: 'Remote forest path in Gävle, Sweden by Geran de Klerk, from Unsplash.',
        alt: 'Low angle photo of pine trees.',
        // thumbnailWidth: '260px'
      }, {
        src: 'img/stiahnuť (4).png',
        description: 'Remote forest path in Gävle, Sweden by Geran de Klerk, from Unsplash.',
        alt: 'Low angle photo of pine trees.',
        // thumbnailWidth: '260px'
      }, ]
    }
  },
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
    border-top: 5px solid #ffffff !important;
    border-right: 5px solid #ffffff !important;
    /* border-top-left-radius: 20px;
  border-bottom-left-radius: 20px; */
}

.lb-modal {
    background-color: rgba(0, 0, 0, .9) !important;
}
</style>
