import { defineStore } from 'pinia'
import requestor from '@/services/requestor'
import { ENDPOINTS } from '@/config/endpoint'
import type { Student, User } from '@/types'

interface AuthState {
  user: User | null
  biodata: Student | null
  role: string | null,
}



export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    user: null,
    biodata: null,
    role: null,
  }),
  persist: true,
  actions: {
    async login(username: string, password: string) {
      try {
        const response = await requestor.post(ENDPOINTS.LOGIN, { username, password })
        this.user = response.data.user
        this.biodata = response.data.biodata
        this.role = response.data.role
        return response.data
      } catch (error) {
        console.error('Login error:', error)
        throw error
      }
    },
    logout() {
      this.$reset()
    },
    isLoggedIn() {
      return !!this.user
    }
  }
})
