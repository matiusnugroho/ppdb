import { ref } from "vue"
import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import type { Registration } from "@/types"

export function useCekPendaftaran() {
	const registrationData = ref<Registration | null>(null)
	const error = ref<string | null>(null)
	const loadingRegistration = ref<boolean>(false)

	const fetchRegistration = async () => {
		loadingRegistration.value = true
		try {
			const response = await requestor.get(ENDPOINTS.CEK_PENDAFTARAN)
			registrationData.value = response.data.registration
			return response.data
		} catch (err) {
			error.value = "Failed to load Registration list"
		} finally {
			loadingRegistration.value = false
		}
	}

	return {
		registrationData,
		error,
		loadingRegistration,
		fetchRegistration,
	}
}
