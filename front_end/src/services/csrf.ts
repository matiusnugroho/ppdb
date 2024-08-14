import { ENDPOINTS } from '@/config/endpoint'
import axios from 'axios'

export const getCSRFToken = async (): Promise<void> => {
  try {
    await axios.get(ENDPOINTS.CSRF, { withCredentials: true })
  } catch (error) {
    if (axios.isAxiosError(error)) {
      throw new Error(error.response?.data.message || 'Failed to get CSRF token')
    } else {
      throw new Error('An unexpected error occurred')
    }
  }
}
