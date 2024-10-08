/*
MEnangani hal hal terkait pendaftaran ke sekolah
*/
import { ENDPOINTS } from "@/config/endpoint"
import requestor from "@/services/requestor"
import type { Pendaftar } from "@/types"
import { ref } from "vue"
export function usePendaftaran() {
	const dataPendaftar = ref<Pendaftar[] | null>(null)
	const loadingPendaftar = ref<boolean>(false)
	const error = ref<string | null>(null)

	const fetchPendaftar = async () => {
		loadingPendaftar.value = true
		try {
			const response = await requestor.get(ENDPOINTS.GET_PENDAFTAR)
			dataPendaftar.value = response.data // Adjust this based on API structure
		} catch (err) {
			error.value = "Failed to load Pendaftaran list"
		} finally {
			loadingPendaftar.value = false
		}
	}

	return {
		dataPendaftar,
		error,
		loadingPendaftar,
		fetchPendaftar,
	}
}
