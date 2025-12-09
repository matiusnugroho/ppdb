import axios from "axios"
import { ENDPOINTS } from "@/config/endpoint"
import router from "@/router"
import { showToast } from "@/utils/ui/toast"

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
		if (error.response) {
			if (!error.config.headers["Bypass-Interceptor"]) {
				const currentRoute = router.currentRoute.value

				if (error.response.status === 401) {
					// Only redirect if not already on login page
					if (currentRoute.name !== 'login') {
						router.push({
							name: "login",
							query: { intended: currentRoute.fullPath, prompt: "Sesi anda telah berakhir, silakan login kembali" },
						})
					}
				} else if (error.response.status === 403) {
					showToast({
						message: "Tindakan ditolak: Anda tidak memiliki akses.",
						type: "error"
					})
				}
			}
		}
		// Return the error to be handled locally or by other interceptors
		return Promise.reject(error)
	},
)

export default requestor
