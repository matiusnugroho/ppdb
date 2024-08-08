import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import requestor from '@/services/requestor'
import { ENDPOINTS } from '@/config/endpoint'
import { useRouter } from 'vue-router'

interface AuthState {
  token: string | null
  user: Record<string, any> | null
}

const router = useRouter()

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    token: useStorage('token', null).value as string | null,
    user: null as any
  }),
  persist: {
    storage: sessionStorage
  },
  actions: {
    async login(username: string, password: string) {
      try {
        const response = await requestor.post(ENDPOINTS.LOGIN, { username, password })
        this.token = response.data.token
        this.user = response.data.user
        useStorage('token', this.token).value = this.token
        return response.data
      } catch (error) {
        console.error('Login error:', error)
        throw error
      }
    },
    logout() {
      this.token = null
      this.user = null
      useStorage('token', null).value = null
      router.push({ name: 'login' })
    },
    isLoggedIn() {
      return !!this.token
    }
  }
})
