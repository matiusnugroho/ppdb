import { ref } from "vue"
import requestor from "@/services/requestor"
import { ENDPOINTS, replacePlaceholder } from "@/config/endpoint"
import type { DataSekolah } from "@/types"

export function useSekolah() {
	const dataSekolah = ref<DataSekolah | null>(null)
	const sekolahList = ref<{ id: string; nama: string }[]>([])
	const error = ref<string | null>(null)
	const loadingSekolah = ref<boolean>(false)

	const fetchAllSekolah = async (per_page: number = 20, page: number = 1, jenjang: string = "", kecamatan_id: string = "") => {
		const url = `${ENDPOINTS.GET_SEKOLAH_ALL}?page=${page}&per_page=${per_page}&jenjang=${jenjang}&kecamatan_id=${kecamatan_id}`
		loadingSekolah.value = true
		try {
			const response = await requestor.get(url)
			dataSekolah.value = response.data // response.data // Adjust this based on API structure
		} catch (err) {
			error.value = "Failed to load sekolah list"
		} finally {
			loadingSekolah.value = false
		}
	}
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
		dataSekolah,
		error,
		loadingSekolah,
		sekolahList,
		fetchAllSekolah,
		fetchSekolah,
	}
}
