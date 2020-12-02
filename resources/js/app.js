require('./bootstrap');

import Vue from 'vue'
import App from './layouts/main'
import vuetify from './vuetify'
import { createRouter } from './router/index'
import store from './store'
import Axios from 'axios'


Vue.prototype.$http = Axios;
const token = localStorage.getItem('token')
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] ='Bearer '+ token
}
const router = createRouter()
new Vue({
  el: '#app',
  router,  
  store,
  vuetify,
  ...App,
  
  mounted () {
  },
  methods: {
    
  }
})
export default {
  created: function () {
    this.$http.interceptors.response.use(undefined, function (err) {
      return new Promise(function (resolve, reject) {
        if (err.status === 401 && err.config && !err.config.__isRetryRequest) {
          this.$store.dispatch("logout")
        }
        throw err;
      });
    });
  }
}