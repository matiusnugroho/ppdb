import axios from 'axios'
import { ENDPOINTS } from '@/config/endpoint'
import { useAuthStore } from '@/stores/auth'

// Create an instance of axios with the base URL
const requestor = axios.create({
  baseURL: ENDPOINTS.BASE_URL
})

// Add a request interceptor to include the token in headers
requestor.interceptors.request.use(
  (config) => {
    const authStore = useAuthStore()
    const token = authStore.token || localStorage.getItem('token') // Retrieve the token from authStore or localStorage
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

export default requestor
