import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import type { RegistrationRequest } from "@/types"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { ref } from "vue"

export function useDaftarKesekolah() {
	const loadingRegister = ref(false)
	const formValidationErrors = useFormValidationErrorsStore()
	const errorDaftar = ref<string | null>(null)
	const registerSekolah = async (data: RegistrationRequest) => {
		loadingRegister.value = true
		try {
			const response = await requestor.post(ENDPOINTS.DAFTAR_KE_SEKOLAH, data)

			console.log({ response }, "response from daftar kesekolah")

			if (response.data.success) {
				//kembalikan response untuk diolah lebih lanjut
				return response
			} else {
				formValidationErrors.errors = response.data.errors
				console.log({ response }, "response from daftar kesekolah")
				errorDaftar.value = response.data.message
				return false
			}
		} catch (error: any) {
			formValidationErrors.errors = error.response?.data?.errors || {}
			const message = error.response?.data?.message
			errorDaftar.value = message
			return false
		} finally {
			loadingRegister.value = false
		}
	}

	return {
		registerSekolah,
		loadingRegister,
		errorDaftar,
	}
}
