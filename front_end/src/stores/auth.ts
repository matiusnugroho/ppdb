import { defineStore } from 'pinia'
import { ref } from 'vue'
import requestor from '@/services/requestor'
import { ENDPOINTS } from '@/config/endpoint'
import type { Student, User } from '@/types'

export const useAuthStore = defineStore(
  'auth',
  () => {
    const user = ref<User | null>(null)
    const biodata = ref<Student | null>(null)
    const role = ref<string | null>(null)
    const intendedURL = ref<string | null>(null)
    const login = async (username: string, password: string) => {
      try {
        const response = await requestor.post(ENDPOINTS.LOGIN, { username, password })
        user.value = response.data.user
        biodata.value = response.data.biodata
        role.value = response.data.role
        return response.data
      } catch (error) {
        console.error('Login error:', error)
        throw error
      }
    }

    const logout = () => {
      user.value = null
      biodata.value = null
      role.value = null
      intendedURL.value = null
    }

    const isLoggedIn = () => {
      return !!user.value
    }

    // Return state and actions
    return {
      user,
      biodata,
      role,
      intendedURL,
      login,
      logout,
      isLoggedIn
    }
  },
  {
    persist: true
  }
)
