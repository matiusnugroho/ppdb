import axios from 'axios'
import { ENDPOINTS } from '@/config/endpoint'
import router from '@/router'

// Create an instance of axios with the base URL
const requestor = axios.create({
  baseURL: ENDPOINTS.BASE_URL,
  withCredentials: true,
})

requestor.interceptors.response.use(
  (response) => {
    // If the response is successful, just return it
    return response
  },
  (error) => {
    if (error.response && error.response.status === 401) {
      /* router.replace({ name: 'login' }).then(() => {
        window.location.reload()
      }) */
      router.push({ name: 'login' })
    }
    // Return the error to be handled locally or by other interceptors
    return Promise.reject(error)
  }
)
export default requestor
