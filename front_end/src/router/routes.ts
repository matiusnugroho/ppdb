export default [
  {
    path: '/',
    name: 'home',
    component: () => import('@/views/HomeView.vue'),
    meta: {
      title: 'PPDB Kuantan Singing',
      requiresAuth: false
    }
  },
  {
    path: '/dashboard',
    name: 'ppdbDashboard',
    component: () => import('@/views/Dashboard/DashBoardSiswaView.vue'),
    meta: {
      title: 'PPDB Kuantan Singing',
      requiresAuth: true
    }
  },
  {
    path: '/biodata',
    name: 'biodata',
    component: () => import('@/views/BiodataView.vue'),
    meta: {
      title: 'Biodata',
      requiresAuth: true
    }
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/Authentication/SigninView.vue'),
    meta: {
      title: 'Login',
      requiresAuth: false
    }
  },
  {
    path: '/daftar',
    name: 'daftar',
    component: () => import('@/views/Authentication/SignupView.vue'),
    meta: {
      title: 'Daftar',
      requiresAuth: false
    }
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('@/views/Errors/Error404View.vue'),
    meta: {
      title: '404 Not Found'
    }
  }
]
