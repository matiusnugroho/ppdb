import { ref } from "vue"
import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"

export function usePersyaratan() {
	const persyaratan = ref<any>(null)
	const loadingPersyaratan = ref<boolean>(false)
	const error = ref<string | null>(null)

	const fetchPersyaratan = async () => {
		loadingPersyaratan.value = true
		try {
			const response = await requestor.get(ENDPOINTS.PERSYARATAN)
			persyaratan.value = response.data
			return response.data
		} catch (err) {
			error.value = "Failed to load persyaratan list"
		} finally {
			loadingPersyaratan.value = false
		}
	}

	return {
		persyaratan,
		loadingPersyaratan,
		error,
		fetchPersyaratan,
	}
}
