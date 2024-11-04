import axios from "axios"
import { ENDPOINTS } from "@/config/endpoint"
import router from "@/router"

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
		// Check if the error response exists and if the Bypass-Interceptor header is not set
		if (error.response && error.response.status === 401) {
			if (!error.config.headers["Bypass-Interceptor"]) {
				const fromRoute = router.currentRoute.value.fullPath
				router.push({
					name: "login",
					query: { intended: fromRoute },
				})
			}
		}
		// Return the error to be handled locally or by other interceptors
		return Promise.reject(error)
	},
)

export default requestor
