import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import requestor from '@/services/requestor'
import { ENDPOINTS } from '@/config/endpoint'

interface AuthState {
  token: string | null
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    token: useStorage('token', null).value as string | null
  }),
  actions: {
    async login(username: string, password: string) {
      try {
        const response = await requestor.post(ENDPOINTS.LOGIN, { username, password })
        this.token = response.data.token
        useStorage('token', this.token).value = this.token // Update token in storage
        return response.data
      } catch (error) {
        console.error('Login error:', error)
        throw error
      }
    },
    logout() {
      this.token = null
      useStorage('token', null).value = null // Clear token from storage
    },
    isLoggedIn() {
      return !!this.token
    }
  }
})
