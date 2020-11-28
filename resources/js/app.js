require('./bootstrap');

import Vue from 'vue'
import App from './layouts/main'
import vuetify from './vuetify'
import { createRouter } from './router/index'

const router = createRouter()
new Vue({
  el: '#app',
  router,  
  vuetify,
  ...App,
  
  mounted () {
  },
  methods: {
    
  }
})