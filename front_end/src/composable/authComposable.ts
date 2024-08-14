import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

export function useAuth() {
  const router = useRouter()
  const authStore = useAuthStore()

  const login = async (username: string, password: string) => {
    try {
      const response = await authStore.login(username, password)
      if (response.success) {
        await router.push('/dashboard')
      }
    } catch (error: any) {
      console.error('Login error:', error)
      throw error
    }
  }

  const logout = async () => {
    await authStore.logout()
    router.push({ name: 'login' })
  }

  return { login, logout }
}
