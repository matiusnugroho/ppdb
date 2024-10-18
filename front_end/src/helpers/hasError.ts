import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"

const formValidationErrors = useFormValidationErrorsStore()
export const hasError = (field: string) => {
	const errors = formValidationErrors.errors[field]
	return errors && errors.length > 0
}
