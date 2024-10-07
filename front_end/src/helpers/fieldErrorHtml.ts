import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"

const formValidationErrors = useFormValidationErrorsStore()
export const field_error_html = (field: string) => {
	const errors = formValidationErrors.errors[field]

	if (errors && errors.length > 0) {
		console.log(`
      <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
        ${errors.join(", ")}
      </span>
    `)
		return `
      <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
        ${errors.join(", ")}
      </span>
    `
	}
	return ""
}
