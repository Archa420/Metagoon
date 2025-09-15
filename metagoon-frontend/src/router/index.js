import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Vakances from '@/views/Vakances.vue'


const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/vakances', name: 'vakances', component: Vakances}
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
