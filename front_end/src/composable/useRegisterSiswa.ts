import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import type { ProfileSiswaRequest } from "@/types"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { ref } from "vue"

export function useRegisterSiswa() {
    const loadingRegister = ref(false)
    const formValidationErrors = useFormValidationErrorsStore()
    const registerSiswa = async (data: ProfileSiswaRequest) => {
        loadingRegister.value = true
        try {
			const response = await requestor.post(ENDPOINTS.REGISTER_SISWA, data)

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
        registerSiswa,
        loadingRegister
    }
}

