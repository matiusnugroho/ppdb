import { defineStore } from "pinia"
import { ref } from "vue"

export const usePaginationStore = defineStore(
	"pagination",
	() => {
		const per_page = ref<number | null>(null)
		const page = ref<number | null>(1)
		const jenjang = ref<string | null>(null)
		const kecamatan_id = ref<string | null>(null)

		return {
			per_page,
			page,
			jenjang,
			kecamatan_id,
		}
	},
	{ persist: true },
)
