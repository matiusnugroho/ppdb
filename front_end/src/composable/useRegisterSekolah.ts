import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import type { ProfileSekolahRequest } from "@/types"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { ref } from "vue"

export function useRegisterSekolah() {
	const loadingRegister = ref(false)
	const formValidationErrors = useFormValidationErrorsStore()
	const registerSekolah = async (data: ProfileSekolahRequest) => {
		loadingRegister.value = true
		try {
			const response = await requestor.post(ENDPOINTS.REGISTER_SEKOLAH, data)

			if (response.data.success) {
				return true
			} else {
				formValidationErrors.errors = response.data.errors
				return false
			}
		} catch (error: any) {
			console.error("Update profile error:", error.response)
			formValidationErrors.errors = error.response?.data?.errors || {}
			return false
		} finally {
			loadingRegister.value = false
		}
	}

	return {
		registerSekolah,
		loadingRegister,
	}
}
