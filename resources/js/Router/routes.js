import Vue from 'vue';
import VueRouter from 'vue-router';

import home from '../components/HomePage'
import login from '../components/auth/Login'
import logout from '../components/auth/Logout'

import admin from '../components/admin/AdminHome'
import edituser from '../components/admin/EditUser'
import alluser from '../components/admin/user/AllUser'
import allclient from '../components/admin/client/AllClient'

Vue.use(VueRouter);

const routes = [
  { path: '/', component: home, name: 'home'},
  { path: '/login', component: login, name: 'login'},
  { path: '/logout', component: logout},
  { path: '/admin', component: admin,
    children: [
      {path: 'all-user', component: alluser},
      {path: 'edit/:id', component: edituser, name: 'edituser'},
      {path: 'all-client', component: allclient},
    ]
  },
  
  ]

  const router = new VueRouter({
    routes, // short for `routes: routes`
    hashbang: false,
    mode: 'history'
  })

  export default router;