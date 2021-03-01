import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import '@mdi/font/css/materialdesignicons.css';

Vue.use(Vuetify);
// import colors from 'vuetify/lib/util/colors'

// const vuetify = new Vuetify({
//
// })

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: '#007bff',
        secondary: '#000000',
        accent: '#fff',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107',
        background: '#ffffff'
      },
      dark: {
        primary: '#007bff',
        background: '#000000'
      },
    },
  },
});