import requestor from "@/services/requestor"
import { ref } from "vue"
import { ENDPOINTS } from "@/config/endpoint"
import axios from "axios"

export function useAkun() {
	const loadingAkun = ref(false)
	const loadingGantiPassword = ref(false)
	const error = ref<string | null>(null)

	const updateAkun = async (data: any) => {
		loadingAkun.value = true
		try {
			const response = await requestor.post(ENDPOINTS.UPDATE_AKUN_ADMIN, data)
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				return err.response.data
			} else {
				// Log other types of errors
				return { message: "An unknown error occurred" } // Provide a fallback for unknown errors
			}
		} finally {
			loadingAkun.value = false
		}
	}
	const gantiPassword = async (data: any) => {
		loadingGantiPassword.value = true
		try {
			const response = await requestor.post(ENDPOINTS.GANTI_PASSWORD, data)
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				return err.response.data
			} else {
				// Log other types of errors
				return { message: "An unknown error occurred" } // Provide a fallback for unknown errors
			}
		} finally {
			loadingGantiPassword.value = false
		}
	}

	return {
		loadingAkun,
		loadingGantiPassword,
		error,
		gantiPassword,
		updateAkun,
	}
}
