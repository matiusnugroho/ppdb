import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import type { RegistrationRequest } from "@/types"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { ref } from "vue"

export function useDaftarKesekolah() {
	const loadingRegister = ref(false)
	const formValidationErrors = useFormValidationErrorsStore()
	const registerSekolah = async (data: RegistrationRequest) => {
		loadingRegister.value = true
		try {
			const response = await requestor.post(ENDPOINTS.DAFTAR_KE_SEKOLAH, data)

			if (response.data.success) {
				return true
			} else {
				formValidationErrors.errors = response.data.errors
				return false
			}
		} catch (error: any) {
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
