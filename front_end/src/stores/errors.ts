import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useErrorsStore = defineStore(
  'errors',
  () => {
    const errors = ref<Record<string, string>>({})

    const addError = (key: string, message: string) => {
      errors.value[key] = message
    }

    const removeError = (key: string) => {
      delete errors.value[key]
    }

    const clearErrors = () => {
      errors.value = {}
    }

    return {
      errors,
      addError,
      removeError,
      clearErrors
    }
  },
  {
    persist: true
  }
)
