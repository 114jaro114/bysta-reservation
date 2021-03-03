<template>
<div class="informations w-100 h-100 text-uppercase">
  <v-row justify="center" class="ml-0 mr-0">
    <v-col>
      <v-expansion-panels accordion>
        <v-expansion-panel>
          <v-expansion-panel-header>
            <span>Krajina/región</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <span>krajina</span>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header>
            <span>O aktuálnej verzií</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <span>O aktuálnej verzií</span>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header>
            <span>Podmienky používania</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <span>Podmienky používania</span>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header>
            <span>Zásady ochrany osobných údajov</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <span>Zásady ochrany osobných údajov</span>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header>
            <span>Časté otázky</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <span>Časté otázky</span>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header>
            <span>Kontakt</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <span>Kontakt</span>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header>
            <span>Poďakovanie</span>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <span>Poďakovanie</span>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>

      <!-- <v-expansion-panels color="primary" accordion>
        <v-expansion-panel v-for="(item,i) in items" :key="i" ripple>
          <v-expansion-panel-header>{{item.name}}</v-expansion-panel-header>
          <v-expansion-panel-content>
            {{ item.content }}
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels> -->
      <!-- <v-card color=" primary pt-3 pb-3" dark>
        <span class="secondary--color">Krajina/region</span>
        <v-divider class="secondary" />
        <span class="secondary--color">O aktuálnej verzií</span>
        <v-divider class="secondary" />
        <span class="secondary--color">Podmienky používania</span>
        <v-divider class="secondary" />
        <span class="secondary--color">Zásady ochrany osobných údajov</span>
        <v-divider class="secondary" />
        <span class="secondary--color">Časté otázky</span>
        <v-divider class="secondary" />
        <span class="secondary--color">Kontakt</span>
        <v-divider class="secondary" />
        <span class="secondary--color">Poďakovanie</span>
      </v-card> -->
    </v-col>
  </v-row>
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
  watch: {
    // model(nxt, old) {
    //   let oldIdx = old.indexOf(true)
    //   if (oldIdx >= 0) {
    //     nxt[oldIdx] = false
    //   }
    //   let activeIdx = nxt.indexOf(true)
    //   console.log("activeIdx", activeIdx)
    // },
  },
}
</script>

<style type="scss">
</style>
