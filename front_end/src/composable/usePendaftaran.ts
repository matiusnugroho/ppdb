/*
MEnangani hal hal terkait pendaftaran ke sekolah
*/
import { ENDPOINTS, replacePlaceholder } from "@/config/endpoint"
import requestor from "@/services/requestor"
import type { Pendaftar, JalurPendaftaran } from "@/types"
import { ref } from "vue"
import axios from "axios"
export function usePendaftaran() {
	const dataPendaftar = ref<Pendaftar[] | null>(null)
	const dataJalurPendaftaran = ref<JalurPendaftaran[] | []>([])
	const dataDetailVerifikasi = ref<Pendaftar | null>(null)
	const loadingPendaftar = ref<boolean>(false)
	const loadingVerifikasi = ref<boolean>(false)
	const totalPendaftar = ref<number>(0)
	const loadingLuluskan = ref<boolean>(false)
	const error = ref<string | null>(null)

	const fetchPendaftar = async () => {
		loadingPendaftar.value = true
		try {
			const response = await requestor.get(ENDPOINTS.GET_PENDAFTAR)
			dataPendaftar.value = response.data.data // Adjust this based on API structure
			totalPendaftar.value = response.data.total
		} catch (err) {
			error.value = "Failed to load Pendaftaran list"
		} finally {
			loadingPendaftar.value = false
		}
	}

	const verifikasiPendaftaran = async (id: string) => {
		loadingVerifikasi.value = true
		try {
			const response = await requestor.post(ENDPOINTS.VERIFIKASI_PENDAFTARAN, { id })
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				// Log the error for debugging
				return err.response.data // Return the Axios response error
			} else {
				// Log other types of errors
				return { message: "An unknown error occurred" } // Provide a fallback for unknown errors
			}
		} finally {
			loadingVerifikasi.value = false
		}
	}

	const verifikasiDokumen = async (id: string) => {
		loadingVerifikasi.value = true
		const url = replacePlaceholder(ENDPOINTS.VERIFIKASI_DOKUMEN, { id_dokumen: id })
		try {
			const response = await requestor.post(url)
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				// Log the error for debugging
				return err.response.data // Return the Axios response error
			} else {
				// Log other types of errors
				return { message: "An unknown error occurred" } // Provide a fallback for unknown errors
			}
		} finally {
			loadingVerifikasi.value = false
		}
	}

	const luluskan = async (id: string, kelulusan: string) => {
		loadingLuluskan.value = true
		const url = replacePlaceholder(ENDPOINTS.LULUSKAN, { id })
		try {
			const response = await requestor.post(url, { kelulusan })
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				// Log the error for debugging
				return err.response.data // Return the Axios response error
			} else {
				// Log other types of errors
				return { message: "An unknown error occurred" } // Provide a fallback for unknown errors
			}
		} finally {
			loadingLuluskan.value = false
		}
	}

	const getVerifiedByMe = async () => {
		loadingVerifikasi.value = true
		try {
			const response = await requestor.get(ENDPOINTS.GET_VERIFIED_BY_ME)
			dataPendaftar.value = response.data.data // Adjust this based on API structure
			totalPendaftar.value = response.data.total
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				// Log the error for debugging
				return err.response.data // Return the Axios response error
			} else {
				// Log other types of errors
				return { message: "An unknown error occurred" } // Provide a fallback for unknown errors
			}
		} finally {
			loadingVerifikasi.value = false
		}
	}
	const getDetailVerifikasi = async (id: string) => {
		loadingVerifikasi.value = true
		const url = replacePlaceholder(ENDPOINTS.DETAIL_VERIFIKASI, { id: id })
		try {
			const response = await requestor.get(url)
			console.log(response.data.data)
			dataDetailVerifikasi.value = response.data.data // Adjust this based on API structure
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				// Log the error for debugging
				return err.response.data // Return the Axios response error
			} else {
				// Log other types of errors
				return { message: "An unknown error occurred" } // Provide a fallback for unknown errors
			}
		} finally {
			loadingVerifikasi.value = false
		}
	}

	const rejectDokumen = async (id: string, alasan: string) => {
		loadingVerifikasi.value = true
		const url = replacePlaceholder(ENDPOINTS.REJECT_DOKUMEN, { id_dokumen: id })
		try {
			const response = await requestor.post(url, { alasan })
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				// Log the error for debugging
				return err.response.data // Return the Axios response error
			} else {
				// Log other types of errors
				return { message: "An unknown error occurred" } // Provide a fallback for unknown errors
			}
		} finally {
			loadingVerifikasi.value = false
		}
	}


	const fetchJalurPendaftaran = async () => {
		loadingPendaftar.value = true
		try {
			const response = await requestor.get(ENDPOINTS.GET_JALUR)
			dataJalurPendaftaran.value = response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				return err.response.data
			} else {
				return { message: "An unknown error occurred" }
			}
		} finally {
			loadingPendaftar.value = false
		}
	}

	const bukaPendaftaran = async (data: any) => {
		loadingPendaftar.value = true
		try {
			const response = await requestor.post(ENDPOINTS.BUKA_PENDAFTARAN, data)
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				return err.response.data
			} else {
				return { message: "An unknown error occurred" }
			}
		} finally {
			loadingPendaftar.value = false
		}
	}

	const tutupPendaftaran = async () => {
		loadingPendaftar.value = true
		try {
			const response = await requestor.post(ENDPOINTS.TUTUP_PENDAFTARAN)
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				return err.response.data
			} else {
				return { message: "An unknown error occurred" }
			}
		} finally {
			loadingPendaftar.value = false
		}
	}

	const fetchAllPeriods = async () => {
		try {
			const response = await requestor.get(ENDPOINTS.GET_ALL_PERIODS)
			return response.data
		} catch (err) {
			console.error("Failed to fetch periods", err)
			return []
		}
	}

	return {
		dataPendaftar,
		error,
		loadingPendaftar,
		loadingVerifikasi,
		loadingLuluskan,
		totalPendaftar,
		dataDetailVerifikasi,
		dataJalurPendaftaran,
		fetchPendaftar,
		verifikasiPendaftaran,
		getVerifiedByMe,
		getDetailVerifikasi,
		verifikasiDokumen,
		luluskan,
		rejectDokumen,
		fetchJalurPendaftaran,
		bukaPendaftaran,
		tutupPendaftaran,
		fetchAllPeriods,
	}
}
