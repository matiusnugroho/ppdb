import { ref } from "vue"
import requestor from "@/services/requestor"
import type { StatistikData } from "@/types"
import { ENDPOINTS } from "@/config/endpoint"
import { useAuthStore } from "@/stores/auth"

export function useStatistik() {
	const error = ref<string | null>(null)
	const loadingStatistik = ref<boolean>(false)
	const statistik = ref<StatistikData | null>(null)

	const fetchStatistik = async (params: any = {}) => {
		const authStore = useAuthStore()
		const url = authStore.role === "super_admin" ? ENDPOINTS.STATISTIK_ADMIN : ENDPOINTS.STATISTIK_SEKOLAH
		loadingStatistik.value = true
		try {
			const response = await requestor.get(url, { params }) // Pass params to the request
			console.log(response.data)
			statistik.value = response.data // Adjust this based on API structure
			return true
		} catch (err: any) {
			console.error(err)
			error.value = "Failed to load statistik " + err.response?.message
			return false
		} finally {
			loadingStatistik.value = false
		}
	}
	const fetchPublicStatistik = async () => {
		loadingStatistik.value = true
		try {
			const response = await requestor.get(ENDPOINTS.STATISTIK_PUBLIC)
			statistik.value = response.data // Adjust this based on API structure
			return true
		} catch (err: any) {
			console.error(err)
			error.value = "Failed to load statistik " + err.response?.message
			return false
		} finally {
			loadingStatistik.value = false
		}
	}

	return {
		statistik,
		error,
		loadingStatistik,
		fetchStatistik,
		fetchPublicStatistik,
	}
}
