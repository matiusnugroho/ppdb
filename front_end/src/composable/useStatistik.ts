import { ref } from "vue"
import requestor from "@/services/requestor"
import type { StatistikData } from "@/types"
import { ENDPOINTS } from "@/config/endpoint"

export function useStatistik() {
	const error = ref<string | null>(null)
	const loadingStatistik = ref<boolean>(false)
	const statistik = ref<StatistikData | null>(null)

	const fetchStatistik = async () => {
		loadingStatistik.value = true
		try {
			const response = await requestor.get(ENDPOINTS.STATISTIK_SEKOLAH)
			statistik.value = response.data // Adjust this based on API structure
			return true
		} catch (err: any) {
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
	}
}
