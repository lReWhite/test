import Vue from 'vue'
import Vuetify from 'vuetify/dist/vuetify.min'
import ru from 'vuetify/es5/locale/ru'

Vue.use(Vuetify)

export default new Vuetify({
  lang: {
    current: 'ru',
    locales: { ru }
  },
  icons: {
    iconfont: 'fa',
    values: {
      cancel: 'fas fa-times-circle',
      sort: 'fas fa-arrow-up'
    }
  }
})
