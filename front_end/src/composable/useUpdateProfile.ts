import { ref } from "vue"
import requestor from "@/services/requestor" // Import your Axios instance
import { ENDPOINTS } from "@/config/endpoint"
import { useAuthStore } from "@/stores/auth"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import type { ProfileSiswaRequest } from "@/types"

export function useUpdateProfile() {
	const uploadProgress = ref(0)
	const loadingUpdatePhoto = ref(false)
	const loadingUpdateProfile = ref(false)
	const uploadError = ref<string | null>(null)
	const uploadSuccess = ref<boolean>(false)
	const url = ENDPOINTS.UPDATE_PHOTO_SISWA
	const urlMe = ENDPOINTS.ME_SISWA

	const authStore = useAuthStore()
	const formValidationErrors = useFormValidationErrorsStore()

	const uploadPhoto = async (file: File): Promise<boolean> => {
		uploadProgress.value = 0
		uploadError.value = null
		uploadSuccess.value = false

		const formData = new FormData()
		formData.append("foto", file)

		try {
			loadingUpdatePhoto.value = true
			const response = await requestor.post(url, formData, {
				onUploadProgress: (progressEvent) => {
					if (progressEvent.total) {
						uploadProgress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total)
					}
				},
			})

			if (response.data.success) {
				const data = response.data.data
				if (authStore.biodata) {
					authStore.biodata.thumbnail_url = data.thumbnail_url
					authStore.biodata.foto_url = data.foto_url
				}
				uploadSuccess.value = true
				return true
			} else {
				formValidationErrors.errors = response.data.errors
				return false
			}
		} catch (error: any) {
			uploadError.value = error.response?.data?.message || "An error occurred during upload."
			formValidationErrors.errors = error.response.data.errors
			return false
		} finally {
			loadingUpdatePhoto.value = false
		}
	}

	const updateProfile = async (data: ProfileSiswaRequest) => {
		uploadError.value = null
		loadingUpdateProfile.value = true
		try {
			const response = await requestor.patch(urlMe, data)

			if (response.data.success) {
				const data = response.data.data
				console.log("Response update profile:", data)
				if (authStore.biodata) {
					authStore.biodata = data.biodata
					authStore.user = data.user
				}
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
			loadingUpdateProfile.value = false
		}
	}

	return {
		uploadPhoto,
		loadingUpdatePhoto,
		uploadProgress,
		uploadError,
		uploadSuccess,
		updateProfile,
		loadingUpdateProfile,
	}
}
