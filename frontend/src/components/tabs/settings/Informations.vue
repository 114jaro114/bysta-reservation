<template>
<div class="informations">
  <v-container>
    <v-lazy :options="{
            threshold: .4
          }" transition="scale-transition">
      <v-row justify="center" class="m-0">
        <v-col class="p-0">
          <v-expansion-panels accordion focusable>
            <v-expansion-panel>
              <v-expansion-panel-header>
                <span>Krajina/región</span>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <span>krajina</span>
              </v-expansion-panel-content>
            </v-expansion-panel>
            <v-divider class="m-0" />
            <v-expansion-panel>
              <v-expansion-panel-header>
                <span>O aktuálnej verzií</span>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <span>O aktuálnej verzií</span>
              </v-expansion-panel-content>
            </v-expansion-panel>
            <v-divider class="m-0" />
            <v-expansion-panel>
              <v-expansion-panel-header>
                <span>Podmienky používania</span>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <span>Podmienky používania</span>
              </v-expansion-panel-content>
            </v-expansion-panel>
            <v-divider class="m-0" />
            <v-expansion-panel>
              <v-expansion-panel-header>
                <span>Zásady ochrany osobných údajov</span>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <span>Zásady ochrany osobných údajov</span>
              </v-expansion-panel-content>
            </v-expansion-panel>
            <v-divider class="m-0" />
            <v-expansion-panel>
              <v-expansion-panel-header>
                <span>Časté otázky</span>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <span>Časté otázky</span>
              </v-expansion-panel-content>
            </v-expansion-panel>
            <v-divider class="m-0" />
            <v-expansion-panel>
              <v-expansion-panel-header>
                <span>Kontakt</span>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <span>Kontakt</span>
              </v-expansion-panel-content>
            </v-expansion-panel>
            <v-divider class="m-0" />
            <v-expansion-panel>
              <v-expansion-panel-header>
                <span>Poďakovanie</span>
              </v-expansion-panel-header>
              <v-expansion-panel-content>
                <span>Poďakovanie</span>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>
        </v-col>
      </v-row>
    </v-lazy>
  </v-container>
</div>
</template>

<script>
export default {
  name: "Informations",
  components: {},
  data() {
    return {
      model: [],
      items: [{
          name: 'Krajina/region',
          content: 'Content of Item One'
        },
        {
          name: 'Item Two',
          content: 'Content of Item Two'
        },
        {
          name: 'Item Three',
          content: 'Content of Item Three'
        },
        {
          name: 'Item Two',
          content: 'Content of Item Two'
        },
        {
          name: 'Item Two',
          content: 'Content of Item Two'
        },
        {
          name: 'Item Two',
          content: 'Content of Item Two'
        },
        {
          name: 'Item Two',
          content: 'Content of Item Two'
        },
      ],

      date: null,
      trip: {
        name: '',
        location: null,
        start: null,
        end: null,
      },
      locations: ['Australia', 'Barbados', 'Chile', 'Denmark', 'Ecuador', 'France'],
    }
  },

  methods: {},
  watch: {},
}
</script>

<style type="scss">
.v-expansion-panel:before {
  box-shadow: none !important;
}
</style>
