import requestor from "@/services/requestor"
import { type CommonData } from "@/types"
import { ENDPOINTS } from "@/config/endpoint"
import { ref, computed } from "vue"
import axios from "axios"

export function useSetting() {
	const settingData = ref<CommonData>({})
	const isLoading = ref(false)
	const error = ref<string | null>(null)
	const ytURL = computed(() => {
		const videoUrl = settingData.value.url_video_tutorial
		if (typeof videoUrl === "string" && videoUrl) {
			const videoId = videoUrl.split("v=")[1]?.split("&")[0]
			return videoId ? `https://www.youtube.com/embed/${videoId}` : ""
		}
		return ""
	})
	console.log("mengambil data setting")
	const fetchSetting = async () => {
		try {
			const response = await requestor.get(ENDPOINTS.GET_SETTING)
			settingData.value = response.data
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				// Log the error for debugging
				return err.response.data // Return the Axios response error
			} else {
				// Log other types of errors
				return { message: "An unknown error occurred" } // Provide a fallback for unknown errors
			}
		}
	}
	const updateSetting = async (data: CommonData) => {
		isLoading.value = true
		error.value = null
		try {
			const response = await requestor.post(ENDPOINTS.UPDATE_SETTING, data)
			settingData.value = response.data.data
			return response.data
		} catch (err) {
			if (axios.isAxiosError(err) && err.response) {
				error.value = err.response.data.message || "Error updating settings"
				return err.response.data
			} else {
				error.value = "An unknown error occurred"
				return { message: "An unknown error occurred" }
			}
		} finally {
			isLoading.value = false
		}
	}
	return {
		settingData,
		isLoading,
		error,
		updateSetting,
		fetchSetting,
		ytURL,
	}
}
