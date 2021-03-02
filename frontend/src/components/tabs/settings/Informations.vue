<template>
<div class="informations w-100 h-100 text-uppercase">
  <v-row justify="center" class="ml-0 mr-0">
    <v-col>
      <v-expansion-panels accordion>
        <v-expansion-panel>
          <v-expansion-panel-header>
            <template>
              <v-row no-gutters>
                <v-col cols="4">
                  Krajina/región
                </v-col>

              </v-row>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-text-field v-model="trip.name" placeholder="Caribbean Cruise"></v-text-field>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header v-slot="{ open }">
            <v-row no-gutters>
              <v-col cols="4">
                O aktuálnej verzií
              </v-col>
              <v-col cols="8" class="text--secondary">
                <v-fade-transition leave-absolute>
                  <span v-if="open" key="0">
                    Select trip destination
                  </span>
                  <span v-else key="1">
                    {{ trip.location }}
                  </span>
                </v-fade-transition>
              </v-col>
            </v-row>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-row no-gutters>
              <v-spacer></v-spacer>
              <v-col cols="5">
                <v-select v-model="trip.location" :items="locations" chips flat solo></v-select>
              </v-col>

              <v-divider vertical class="mx-4"></v-divider>

              <v-col cols="3">
                Select your destination of choice
                <br>
                <a href="#">Learn more</a>
              </v-col>
            </v-row>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn text color="secondary">
                Cancel
              </v-btn>
              <v-btn text color="primary">
                Save
              </v-btn>
            </v-card-actions>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header v-slot="{ open }">
            <v-row no-gutters>
              <v-col cols="4">
                Start and end dates
              </v-col>
              <v-col cols="8" class="text--secondary">
                <v-fade-transition leave-absolute>
                  <span v-if="open">When do you want to travel?</span>
                  <v-row v-else no-gutters style="width: 100%">
                    <v-col cols="6">
                      Start date: {{ trip.start || 'Not set' }}
                    </v-col>
                    <v-col cols="6">
                      End date: {{ trip.end || 'Not set' }}
                    </v-col>
                  </v-row>
                </v-fade-transition>
              </v-col>
            </v-row>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-row justify="space-around" no-gutters>
              <v-col cols="3">
                <v-menu ref="startMenu" :close-on-content-click="false" :return-value.sync="trip.start" offset-y min-width="290px">
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field v-model="trip.start" label="Start date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                  </template>
                  <v-date-picker v-model="date" no-title scrollable>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="$refs.startMenu.isActive = false">
                      Cancel
                    </v-btn>
                    <v-btn text color="primary" @click="$refs.startMenu.save(date)">
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>

              <v-col cols="3">
                <v-menu ref="endMenu" :close-on-content-click="false" :return-value.sync="trip.end" offset-y min-width="290px">
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field v-model="trip.end" label="End date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                  </template>
                  <v-date-picker v-model="date" no-title scrollable>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="$refs.endMenu.isActive = false">
                      Cancel
                    </v-btn>
                    <v-btn text color="primary" @click="$refs.endMenu.save(date)">
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
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
      <v-card color=" primary pt-3 pb-3" dark>
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
      </v-card>
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
