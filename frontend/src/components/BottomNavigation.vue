<template>
  <div class="phone-viewport w-100 m-auto">
    <v-bottom-navigation background-color="blue" dark shift>
      <v-btn to="/home">
        <span>Domov</span>
        <v-icon>mdi-home</v-icon>
      </v-btn>
      <v-btn to="/reservation">
        <span>Rezervácia</span>
        <v-icon>mdi-calendar-month</v-icon>
      </v-btn>
      <v-btn to="/administration">
        <span>Administrácia</span>
        <v-icon>mdi-clipboard-text</v-icon>
      </v-btn>
      <v-btn to="/Settings">
        <span>Nastavenia</span>
        <v-icon>mdi-cog</v-icon>
      </v-btn>
    </v-bottom-navigation>
  </div>
</template>
