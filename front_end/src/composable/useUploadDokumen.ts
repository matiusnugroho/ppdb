import requestor from "@/services/requestor"
import { ENDPOINTS, replacePlaceholder } from "@/config/endpoint"
import type { DokumenRequest } from "@/types"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { ref } from "vue"

type UploadMode = "upload" | "revisi"
type EndpointKeys = keyof typeof ENDPOINTS

export function useUploadDokumen() {
	const loadingUploadDokumen = ref(false)
	const formValidationErrors = useFormValidationErrorsStore()
	const uploadDokumen = async (data: DokumenRequest, mode: UploadMode,alasan?: string) => {
		loadingUploadDokumen.value = true
		let urlsegment : EndpointKeys		
		try {
			switch (mode) {
				case "upload":
					urlsegment = "UPLOAD_DOKUMEN" as EndpointKeys
					break
				case "revisi":
					urlsegment = "REVISI_DOKUMEN" as EndpointKeys
					break
				default:
					urlsegment = "REVISI_DOKUMEN" as EndpointKeys
			}
			const url = replacePlaceholder(ENDPOINTS[urlsegment], { id_dokumen: data.id_dokumen })
			const formData = new FormData()
			formData.append("file", data.file)
			formData.append("id_dokumen", data.id_dokumen)
			if(alasan) formData.append("alasan", alasan)
			const response = await requestor.post(url, formData)

			if (response.data.success) {
				return response.data
			} else {
				formValidationErrors.errors = response.data.errors
				return false
			}
		} catch (error: any) {
			formValidationErrors.errors = error.response?.data?.errors || { file: [error.response.message] }
			return error.response.data
		} finally {
			loadingUploadDokumen.value = false
		}
	}

	return {
		uploadDokumen,
		loadingUploadDokumen,
	}
}
