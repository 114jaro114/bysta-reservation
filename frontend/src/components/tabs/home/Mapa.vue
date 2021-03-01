<template>
<div class="mapa w-100 h-100 text-uppercase secondary-color">
  <div class="row justify-content-center mr-0 ml-0">
    <div class="col pl-0 pr-0">
      <md-card class="">
        <md-card-header>
          <div class="md-title">Poloha</div>
        </md-card-header>

        <md-card-content>
          <span>Byšta, Košický kraj, Slovensko</span>
          <gmap-map :center="position" :zoom="10" style="width: 100%; height: 440px;">
            <gmap-info-window :options="infoWindowOptions" :position="position" :opened="infoWindowOpened" @closeclick="handleInfoWindowClose">
              <div class="info-window">
                <h5>Chata Byšta</h5>
              </div>
            </gmap-info-window>
            <gmap-marker :position="position" :clickable="true" :draggable="false" @click="handleMarkerClicked()"></gmap-marker>
          </gmap-map>
        </md-card-content>
      </md-card>
    </div>
  </div>
</div>
</template>

<script>
export default {
  name: "Mapa",
  components: {},
  data() {
    return {
      infoWindowOptions: {
        pixelOffset: {
          width: 0,
          height: -35
        }
      },
      infoWindowOpened: false,
    }
  },
  methods: {
    handleMarkerClicked() {
      this.infoWindowOpened = true;
    },
    handleInfoWindowClose() {
      this.infoWindowOpened = false;
    },
  },
  computed: {
    position() {
      return {
        lat: 48.52268,
        lng: 21.55209
      };
    },
  },
}
</script>

<style lang="scss">
</style>
