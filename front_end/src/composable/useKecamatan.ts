import { ref } from "vue"
import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"

export function useKecamatan() {
	const kecamatanList = ref<{ id: string; nama: string }[]>([])
	const error = ref<string | null>(null)
	const loadingKecamatan = ref<boolean>(false)

	const fetchKecamatan = async () => {
		loadingKecamatan.value = true
		try {
			const response = await requestor.get(ENDPOINTS.GET_KECAMATAN)
			kecamatanList.value = response.data // Adjust this based on API structure
		} catch (err) {
			error.value = "Failed to load kecamatan list"
		} finally {
			loadingKecamatan.value = false
		}
	}

	return {
		kecamatanList,
		error,
		loadingKecamatan,
		fetchKecamatan,
	}
}
