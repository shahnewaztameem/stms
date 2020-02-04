import Vue from 'vue';
import VueRouter from 'vue-router';

import home from '../components/HomePage'
import login from '../components/auth/Login'
import logout from '../components/auth/Logout'

Vue.use(VueRouter);

const routes = [
  { path: '/', component: home, name: 'home'},
  { path: '/login', component: login, name: 'login'},
  { path: '/logout', component: logout},
  ]

  const router = new VueRouter({
    routes, // short for `routes: routes`
    hashbang: false,
    mode: 'history'
  })

  export default router;