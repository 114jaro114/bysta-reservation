import Vue from 'vue'

import VueI18n from 'vue-i18n';
Vue.use(VueI18n);

const messages = {
  sk: {

  },

  en: {

  }
};

const i18n = new VueI18n({
  locale: localStorage.getItem('language'),
  messages
});

export default i18n