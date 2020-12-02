import Login from '../pages/login'
import Home from '../pages/content'


import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'

Vue.use(Router)

const routes = [
    { path: '/', component: Home },
  { path: '/login', component: Login },
 
  {
    path: '*',
    name: 'error',
    component: Error,
    props: route => ({
      id: route.params.id ? route.params.id : 404
    })
  }

]

export default routes

// router.beforeEach((to, from, next) => {
//   if(to.matched.some(record => record.meta.requiresAuth)) {
//     if (store.getters.isLoggedIn) {
//       next()
//       return
//     }
//     next('/login') 
//   } else {
//     next() 
//   }
// })