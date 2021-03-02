<template>
<div class="phone-viewport w-100 m-auto">
  <v-bottom-navigation color="secondary" background-color="primary" shift>
    <v-btn to="/home">
      <span>Domov</span>
      <v-icon color="secondary">mdi-home</v-icon>
    </v-btn>
    <v-btn to="/reservation">
      <span>Rezervácia</span>
      <v-icon color="secondary">mdi-calendar-month</v-icon>
    </v-btn>
    <v-btn to="/administration">
      <span>Administrácia</span>
      <v-icon color="secondary">mdi-clipboard-text</v-icon>
    </v-btn>
    <v-btn to="/settings">
      <span>Nastavenia</span>
      <v-icon color="secondary">mdi-cog</v-icon>
    </v-btn>
  </v-bottom-navigation>
</div>
</template>
