import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import '@mdi/font/css/materialdesignicons.css';
import {
  Ripple
} from 'vuetify/lib/directives';

Vue.use(Vuetify, {
  directives: {
    Ripple,
  }
});
// import colors from 'vuetify/lib/util/colors'
// https://lobotuerto.com/vuetify-color-theme-builder/#generated-code
export default new Vuetify({
  theme: {
    themes: {
      dark: {
        // primary: '#21CFF3',
        primary: '#0D47A1',
        accent: '#E0E0E0',
        secondary: '#555',
        success: '#4CAF50',
        info: '#2196F3',
        warning: '#FB8C00',
        error: '#EA1616',
        // background: '#1E1E1E',
        background: '#333333',
      },
      light: {
        primary: '#0D47A1',
        accent: '#212121',
        secondary: '#555',
        success: '#4CAF50',
        info: '#2196F3',
        warning: '#FB8C00',
        error: '#EA1616',
        background: '#FFFFFF'
      }
    },
  },
});