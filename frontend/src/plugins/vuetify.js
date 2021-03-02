import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import '@mdi/font/css/materialdesignicons.css';

Vue.use(Vuetify);
// import colors from 'vuetify/lib/util/colors'
// https://lobotuerto.com/vuetify-color-theme-builder/#generated-code
export default new Vuetify({
  theme: {
    themes: {
      dark: {
        primary: '#21CFF3',
        accent: '#E0E0E0',
        secondary: '#EEEEEE',
        success: '#4CAF50',
        info: '#2196F3',
        warning: '#FB8C00',
        error: '#EA1616',
        background: '#1E1E1E'
      },
      light: {
        primary: '#0D47A1',
        accent: '#212121',
        secondary: '#ffffff',
        success: '#4CAF50',
        info: '#2196F3',
        warning: '#FB8C00',
        error: '#EA1616',
        background: '#FFFFFF'
      }
    },
  },
});