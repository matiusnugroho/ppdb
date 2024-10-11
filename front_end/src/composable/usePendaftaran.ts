/*
MEnangani hal hal terkait pendaftaran ke sekolah
*/
import { ENDPOINTS } from "@/config/endpoint"
import requestor from "@/services/requestor"
import type { Pendaftar } from "@/types"
import { ref } from "vue"
import axios from "axios"
export function usePendaftaran() {
	const dataPendaftar = ref<Pendaftar[] | null>(null)
	const loadingPendaftar = ref<boolean>(false)
	const loadingVerifikasi = ref<boolean>(false)
	const totalPendaftar = ref<number>(0)
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

	return {
		dataPendaftar,
		error,
		loadingPendaftar,
		loadingVerifikasi,
		totalPendaftar,
		fetchPendaftar,
		verifikasiPendaftaran,
	}
}
