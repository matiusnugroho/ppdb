/**
 * Formats a date string from 'd-m-Y' to 'Y-m-d'.
 * @param dateString - The date string in 'd-m-Y' format.
 * @returns - The formatted date string in 'Y-m-d' format.
 */
export function formatDateToStandar(dateString: string | null): string {
	if (dateString) {
		const [day, month, year] = dateString.split("-")
		return `${year}-${month}-${day}`
	}
	return ""
}
