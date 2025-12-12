import { ref } from "vue"
import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import { useAuthStore } from "@/stores/auth"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import type { ProfileSekolahRequest, School } from "@/types"

export function useUpdateSekolahProfile() {
	const loadingUpdateSekolah = ref(false)
	const formValidationErrors = useFormValidationErrorsStore()
	const authStore = useAuthStore()

	const updateSekolahProfile = async (payload: ProfileSekolahRequest) => {
		formValidationErrors.clearErrors()
		loadingUpdateSekolah.value = true
		try {
			const { data } = await requestor.patch(ENDPOINTS.UPDATE_SEKOLAH_ME, payload)

			if (data.success) {
				const updatedSchool = data.data?.school as School
				if (authStore) {
					authStore.biodata = updatedSchool as unknown as any
					authStore.user = data.data?.user ?? authStore.user
				}
				return true
			}

			formValidationErrors.errors = data.errors || {}
			return false
		} catch (error: any) {
			formValidationErrors.errors = error?.response?.data?.errors || {}
			return false
		} finally {
			loadingUpdateSekolah.value = false
		}
	}

	return {
		loadingUpdateSekolah,
		updateSekolahProfile,
	}
}
