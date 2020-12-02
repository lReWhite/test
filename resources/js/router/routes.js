import Login from '../pages/login'
import Home from '../pages/content'

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