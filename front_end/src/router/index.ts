import { createRouter, createWebHistory } from 'vue-router'
import routes from '@/router/routes'



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { left: 0, top: 0 }
  }
})

router.beforeEach((to, from, next) => {
  document.title = `PPDB ${to.meta.title}`
  next()
})

export default router
