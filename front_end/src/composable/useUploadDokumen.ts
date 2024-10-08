import requestor from "@/services/requestor"
import { ENDPOINTS, replacePlaceholder } from "@/config/endpoint"
import type { DokumenRequest } from "@/types"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { ref } from "vue"

export function useUploadDokumen() {
	const loadingUploadDokumen = ref(false)
	const formValidationErrors = useFormValidationErrorsStore()
	const uploadDokumen = async (data: DokumenRequest) => {
		loadingUploadDokumen.value = true
		try {
			const url = replacePlaceholder(ENDPOINTS.UPLOAD_DOKUMEN, { id_dokumen: data.id_dokumen })
			const formData = new FormData()
			formData.append("file", data.file)
			formData.append("id_dokumen", data.id_dokumen)
			const response = await requestor.post(url, formData)

			if (response.data.success) {
				return response.data
			} else {
				formValidationErrors.errors = response.data.errors
				return false
			}
		} catch (error: any) {
			formValidationErrors.errors = error.response?.data?.errors || {}
			return false
		} finally {
			loadingUploadDokumen.value = false
		}
	}

	return {
		uploadDokumen,
		loadingUploadDokumen,
	}
}
