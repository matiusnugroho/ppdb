import { ref } from "vue"
import requestor from "@/services/requestor"
import { ENDPOINTS, replacePlaceholder } from "@/config/endpoint"
import type { DataSekolah } from "@/types"
import { usePaginationStore } from "@/stores/paginationStore"

export function useSekolah() {
	const dataSekolah = ref<DataSekolah | null>(null)
	const sekolahList = ref<{ id: string; nama: string }[]>([])
	const error = ref<string | null>(null)
	const loadingSekolah = ref<boolean>(false)
	const paginationStore = usePaginationStore()

	const fetchAllSekolah = async (per_page: number = 20, page: number = 1, jenjang: string = "", kecamatan_id: string = "") => {
		const queryParameters = []

		if (page !== null) queryParameters.push(`page=${page}`)

		if (per_page !== null) queryParameters.push(`per_page=${per_page}`)

		if (jenjang !== null) queryParameters.push(`jenjang=${jenjang}`)

		if (kecamatan_id !== null) queryParameters.push(`kecamatan_id=${kecamatan_id}`)

		// Join the parameters with '&' and create the final URL
		const url = `${ENDPOINTS.GET_SEKOLAH_ALL}${queryParameters.length ? "?" + queryParameters.join("&") : ""}`

		paginationStore.per_page = per_page
		paginationStore.page = page
		paginationStore.currentPage = page
		paginationStore.jenjang = jenjang
		paginationStore.kecamatan_id = kecamatan_id
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
