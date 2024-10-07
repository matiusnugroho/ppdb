import { ref } from "vue"
import requestor from "@/services/requestor"
import { ENDPOINTS, replacePlaceholder } from "@/config/endpoint"

export function useSekolah() {
	const sekolahList = ref<{ id: string; nama: string }[]>([])
	const error = ref<string | null>(null)
	const loadingSekolah = ref<boolean>(false)

	const fetchSekolah = async (idKecamatan: string, jenjang: string = "") => {
		const url = replacePlaceholder(ENDPOINTS.GET_SEKOLAH, { kecamatan_id: idKecamatan, jenjang: jenjang })
		loadingSekolah.value = true
		try {
			const response = await requestor.get(url)
			sekolahList.value = response.data.data // Adjust this based on API structure
		} catch (err) {
			error.value = "Failed to load sekolah list"
		} finally {
			loadingSekolah.value = false
		}
	}

	return {
		sekolahList,
		error,
		loadingSekolah,
		fetchSekolah,
	}
}
