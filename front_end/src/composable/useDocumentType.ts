import { ENDPOINTS } from "@/config/endpoint"
import requestor from "@/services/requestor"
import { ref } from "vue"
import type { Document } from "@/types"
export function useDocumentType() {
	const documentTypeList = ref<Document[]>([])
	const error = ref<string | null>(null)
	const loadingDocumentType = ref<boolean>(false)

	const fetchDocumentType = async () => {
		loadingDocumentType.value = true
		try {
			const response = await requestor.get(ENDPOINTS.GET_DOCUMENT_TYPE)
			documentTypeList.value = response.data // Adjust this based on API structure
		} catch (err) {
			error.value = "Failed to load Document Type list"
		} finally {
			loadingDocumentType.value = false
		}
	}

	return {
		documentTypeList,
		error,
		loadingDocumentType,
		fetchDocumentType,
	}
}
