import { defineStore } from "pinia"
import { ref } from "vue"

export const useFormValidationErrorsStore = defineStore(
	"formValidationErrors",
	() => {
		const errors = ref<Record<string, string[]>>({})

		const addError = (key: string, message: string) => {
			if (!errors.value[key]) {
				errors.value[key] = []
			}
			errors.value[key].push(message)
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
			clearErrors,
		}
	},
	{
		persist: true,
	},
)
