import { ref } from "vue"
import requestor from "@/services/requestor"
import { ENDPOINTS, replacePlaceholder } from "@/config/endpoint"
import type { DataSekolah } from "@/types"
import { usePaginationStore } from "@/stores/paginationStore"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"

export function useSekolah() {
	const dataSekolah = ref<DataSekolah | null>(null)
	const sekolahList = ref<{ id: string; nama: string }[]>([])
	const error = ref<string | null>(null)
	const loadingSekolah = ref<boolean>(false)
	const paginationStore = usePaginationStore()

	const fetchAllSekolah = async (per_page: number = 20, page: number = 1, jenjang: string = "", kecamatan_id: string = "", search: string = "") => {
		let url = `${ENDPOINTS.GET_SEKOLAH_ALL}?per_page=${per_page}&page=${page}`
		if (jenjang && jenjang != "null") url += `&jenjang=${jenjang}`
		if (kecamatan_id && kecamatan_id != "null") url += `&kecamatan_id=${kecamatan_id}`
		if (search) url += `&search=${search}`

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
	const fetchSekolahById = async (id: string) => {
		const url = replacePlaceholder(ENDPOINTS.GET_SEKOLAH_BY_ID, { id })
		loadingSekolah.value = true
		try {
			const response = await requestor.get(url)
			return response.data.data
		} catch (err) {
			error.value = "Failed to load sekolah data"
			return null
		} finally {
			loadingSekolah.value = false
		}
	}

	const updateSekolah = async (id: string, data: any) => {
		const url = replacePlaceholder(ENDPOINTS.UPDATE_SEKOLAH, { id })
		loadingSekolah.value = true
		try {
			const response = await requestor.put(url, data)
			return response.data.success
		} catch (err) {
			error.value = "Failed to update sekolah"
			return false
		} finally {
			loadingSekolah.value = false
		}
	}

	const createSekolah = async (data: any) => {
		const url = ENDPOINTS.REGISTER_SEKOLAH
		const formValidationErrors = useFormValidationErrorsStore()
		loadingSekolah.value = true
		error.value = null
		try {
			const response = await requestor.post(url, data)
			return { success: true, data: response.data }
		} catch (err: any) {
			error.value = err.response?.data?.message || "Failed to create sekolah"
			if (err.response?.data?.errors) {
				formValidationErrors.errors = err.response.data.errors
			}
			return { success: false, error: error.value }
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
		fetchSekolahById,
		updateSekolah,
		createSekolah,
	}
}
