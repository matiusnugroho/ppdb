import { defineStore } from "pinia"
import { ref } from "vue"

export const usePaginationStore = defineStore(
	"pagination",
	() => {
		const per_page = ref<number | null>(20)
		const currentPage = ref<number>(1)
		const page = ref<number>(1)
		const jenjang = ref<string | null>(null)
		const kecamatan_id = ref<string | null>(null)

		const resetTodefault = () => {
			per_page.value = 20
			currentPage.value = 1
			page.value = 1
			jenjang.value = null
			kecamatan_id.value = null
		}

		return {
			per_page,
			page,
			jenjang,
			kecamatan_id,
			currentPage,
			resetTodefault,
		}
	},
	{ persist: true },
)
