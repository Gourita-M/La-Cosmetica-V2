
import { createRouter, createWebHistory } from 'vue-router'

import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Products from './pages/Products.vue'
import Order from './pages/Order.vue'

const routes = [
    { path: '/login', component: Login },
    { path: '/register', component: Register },

    {
        path: '/products',
        component: Products,
        meta: { requiresAuth: true }
    },

    { path: '/', redirect: '/products'}
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  if (to.meta.requiresAuth && !token) {
    next('/login')
  } else if ((to.path === '/login' || to.path === '/register') && token) {
    next('/products')
  } else {
    next()
  }
})

export default router