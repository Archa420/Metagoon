import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Vakances from '@/views/Vakances.vue'
import Favoriti from '@/views/Favoriti.vue'
import Login from '@/views/Login.vue'
import Regis from '@/views/Regis.vue'
import Profile from '@/views/Profile.vue'
import VacancyDetailed from "@/views/VacancyDetailed.vue";

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/vakances', name: 'vakances', component: Vakances},
  { path: '/favoriti', name: 'favoriti', component: Favoriti},
    { path: '/login', name: 'ļogin', component: Login, meta: {
      hideHeader: true,
     }},
     { path: '/registracija', name: 'registracija', component: Regis, meta: {
      hideHeader: true,
     }},
  { path: '/profile', name: "profile", component: Profile},
  { path: "/vacancy/:id", component: VacancyDetailed, props: true }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
