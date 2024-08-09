import { ref } from 'vue'
import requestor from '@/services/requestor' // Import your Axios instance
import { ENDPOINTS } from '@/config/endpoint'
import { useAuthStore } from '@/stores/auth'

export function usePhotoUpload() {
  const uploadProgress = ref(0)
  const loadingUpdatePhoto = ref(false)
  const uploadError = ref<string | null>(null)
  const uploadSuccess = ref<boolean>(false)
  const url = ENDPOINTS.UPDATE_PHOTO_SISWA

  const authStore = useAuthStore()

  const uploadPhoto = async (file: File): Promise<boolean> => {
    uploadProgress.value = 0
    uploadError.value = null
    uploadSuccess.value = false

    const formData = new FormData()
    formData.append('foto', file)

    try {
      loadingUpdatePhoto.value = true
      const response = await requestor.post(url, formData, {
        onUploadProgress: (progressEvent) => {
          if (progressEvent.total) {
            uploadProgress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total)
          }
        }
      })

      if (response.data.success) {
        const data = response.data.data
        if (authStore.biodata) {
          authStore.biodata.thumbnail_url = data.thumbnail_url
          authStore.biodata.foto_url = data.foto_url
        }
        uploadSuccess.value = true
        return true
      } else {
        return false
      }
    } catch (error: any) {
      uploadError.value = error.response?.data?.message || 'An error occurred during upload.'
      return false
    } finally {
      loadingUpdatePhoto.value = false
    }
  }

  return {
    uploadPhoto,
    loadingUpdatePhoto,
    uploadProgress,
    uploadError,
    uploadSuccess
  }
}
