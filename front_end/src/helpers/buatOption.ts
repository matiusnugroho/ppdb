import type { Option } from "@/types"

/**
 * Transforms an array of objects into an array of options with label and value keys.
 * @param {Array<T>} data - The input array of objects.
 * @param {keyof T} labelKey - The key to be used for the label.
 * @param {keyof T} valueKey - The key to be used for the value.
 * @returns {Array<Option>} - The transformed array of options.
 */
export function buatOption<T>(data: T[], labelKey: String, valueKey: String): Option[] {
	console.log({ data, labelKey, valueKey })
	return data.map((item) => ({
		label: item[labelKey as keyof T] as unknown as string, // Cast to string for the label
		value: item[valueKey as keyof T] as unknown as string | number, // Directly use the value, which is guaranteed to be string or number
	}))
}
