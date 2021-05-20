<template>
<div class="mapa w-100 h-100 mt-3">
  <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
    <v-row justify="center" class="ml-0 mr-0">
      <v-col class="pl-3 pr-3">
        <v-card class="rounded" elevation="0">
          <v-toolbar class="rounded-top" color="primary" flat dark>
            <v-row align="center">
              <v-divider />
              <span>Byšta, Košický kraj, Slovensko</span>
              <v-divider />
            </v-row>
          </v-toolbar>

          <v-card-text>
            <gmap-map :center="position" :zoom="10" style="width: 100%; height: 440px;">
              <gmap-info-window :options="infoWindowOptions" :position="position" :opened="infoWindowOpened" @closeclick="handleInfoWindowClose">
                <div class="info-window">
                  <h5>Chata Byšta</h5>
                </div>
              </gmap-info-window>
              <gmap-marker :position="position" :clickable="true" :draggable="false" @click="handleMarkerClicked()"></gmap-marker>
            </gmap-map>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-lazy>
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
