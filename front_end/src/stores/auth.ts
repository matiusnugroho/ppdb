import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import requestor from '@/services/requestor'
import { ENDPOINTS } from '@/config/endpoint'
import { useRouter } from 'vue-router'
import type { Student, User } from '@/types'

interface AuthState {
  token: string | null
  user: User | null
  biodata: Student | null
  role: string | null
}

const router = useRouter()

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    token: useStorage('token', null).value as string | null,
    user: null,
    biodata: null,
    role: null
  }),
  persist: true,
  actions: {
    async login(username: string, password: string) {
      try {
        const response = await requestor.post(ENDPOINTS.LOGIN, { username, password })
        this.token = response.data.token
        this.user = response.data.user
        this.biodata = response.data.biodata
        this.role = response.data.role
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
      this.biodata = null
      this.role = null
      useStorage('token', null).value = null
      router.push({ name: 'login' })
    },
    isLoggedIn() {
      return !!this.token
    }
  }
})
