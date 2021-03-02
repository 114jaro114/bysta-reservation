<template>
<div class="domov w-100 h-100 text-uppercase">
  <div class="row justify-content-center mr-0 ml-0">
    <div class="col pl-0 pr-0 mt-3">
      <md-card-content>
        <span>Chata sa nachadza v byvalej lokalite kupelov byšta obklopena prekrasnou prirodou. Navšteva tokajskych pivnic. Termalne kupalisko 30 min autom. Možnost turistiky, hubarčenia, cykloturistiky, jazero vhodne na rybolov.</span>
        <h1>Gallery</h1>
        <lightbox :cells="3" :items="images"></lightbox>
      </md-card-content>
    </div>
  </div>
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

.lb-item {
    border-top: 2px solid #f5f5f5;
    border-right: 2px solid #f5f5f5;
    /* border-top-left-radius: 20px;
  border-bottom-left-radius: 20px; */
}

.lb-modal {
    background-color: rgba(0, 0, 0, .9) !important;
}
</style>
