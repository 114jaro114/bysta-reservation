<template>
<div class="all w-100 h-100 text-uppercase">
  <v-row justify="center" class="ml-0 mr-0">
    <v-col v-for="(item, i) in items" :key="i" cols="12">
      <v-card color="primary" dark>
        <div class="d-flex flex-no-wrap justify-space-between">
          <div>
            <v-card-title class="headline" v-text="item.title"></v-card-title>

            <v-card-subtitle v-text="item.artist"></v-card-subtitle>

            <v-card-actions v-if="item.artist === 'Ellie Goulding'">
              <v-btn class="ml-2 mt-3" fab icon small>
                <v-icon>mdi-star-box-multiple-outline</v-icon>
              </v-btn>

              <v-btn class="ml-2 mt-3" outlined rounded medium>
                START RADIO
              </v-btn>
            </v-card-actions>

            <v-card-actions v-else>
              <v-btn class="ml-2 mt-3" fab icon small>
                <v-icon>mdi-star-box-multiple-outline</v-icon>
              </v-btn>

              <v-btn class="ml-2 mt-3" outlined rounded medium>
                START RADIO
              </v-btn>
            </v-card-actions>
          </div>

          <v-avatar class="ma-3" size="125" tile>
            <v-img :src="item.src"></v-img>
          </v-avatar>
        </div>
      </v-card>
    </v-col>
  </v-row>
</div>
</template>

<script>
export default {
  name: "All",
  components: {},
  data() {
    return {
      items: [{
          src: 'https://cdn.vuetifyjs.com/images/cards/foster.jpg',
          title: 'Supermodel',
          artist: 'Foster the People',
        },
        {
          src: 'https://cdn.vuetifyjs.com/images/cards/halcyon.png',
          title: 'Halcyon Days',
          artist: 'Ellie Goulding',
        },
      ],
    }
  },
}
</script>

<style type="scss">
/* .md-empty-state {
    margin-top: 5rem !important;
  } */
</style>
