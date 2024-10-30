<script setup lang="ts">
import { onMounted, computed, ref, watch } from "vue"
import HomeLayout from "@/layouts/HomeLayout.vue"
import TabelSekolahComponent from "@/components/Dashboard/TabelSekolahComponent.vue"
import { useSekolah } from "@/composable/useSekolah"
import { usePaginationStore } from "@/stores/paginationStore"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"
import { useKecamatan } from "@/composable/useKecamatan"
import { buatOption } from "@/helpers/buatOption"
import type { DataSekolah, Option } from "@/types"
import InputGroup from "@/components/Forms/InputGroup.vue"
const { kecamatanList, fetchKecamatan, loadingKecamatan } = useKecamatan()
const kecamatan_id = ref("")
const jenjang = ref("")
const per_page = ref()
const kecamatanOption = computed<Option[]>(() => {
	const options = buatOption(kecamatanList.value, "nama", "id")
	return [{ value: null, label: "Semua Kecamatan" }, ...options]
})
const jenjangOption = ref<Option[]>([
	{ label: "Semua Jenjang", value: null },
	{ label: "SD", value: "sd" },
	{ label: "SMP", value: "smp" },
])
const paginationStore = usePaginationStore()
const { fetchAllSekolah, loadingSekolah, dataSekolah } = useSekolah()
const loadingDataSekolah: DataSekolah = {
	total: 0,
	currentPage: 1,
	prevPage: null,
	nextPage: null,
	lastPage: 1,
	data: [],
}

watch(kecamatan_id, (newVal) => {
	paginationStore.kecamatan_id = newVal
	fetchAllSekolah(paginationStore.per_page as number, 1, paginationStore.jenjang as string, paginationStore.kecamatan_id as string)
})

watch(jenjang, (newVal) => {
	paginationStore.jenjang = newVal
	fetchAllSekolah(paginationStore.per_page as number, 1, paginationStore.jenjang as string, paginationStore.kecamatan_id as string)
})

const goToPage = (page: number) => {
	paginationStore.page = page
	paginationStore.currentPage = page
	fetchAllSekolah(paginationStore.per_page as number, paginationStore.page as number, paginationStore.jenjang as string, paginationStore.kecamatan_id as string)
}
const goToNextPage = () => {
	paginationStore.page = paginationStore.page + 1
	paginationStore.currentPage = paginationStore.currentPage + 1
	fetchAllSekolah(paginationStore.per_page as number, paginationStore.page as number, paginationStore.jenjang as string, paginationStore.kecamatan_id as string)
}
const goToPrevPage = () => {
	paginationStore.page = paginationStore.page - 1
	paginationStore.currentPage = paginationStore.currentPage - 1
	fetchAllSekolah(paginationStore.per_page as number, paginationStore.page as number, paginationStore.jenjang as string, paginationStore.kecamatan_id as string)
}

onMounted(async () => {
	await paginationStore.resetTodefault()
	fetchKecamatan()
	fetchAllSekolah(paginationStore.per_page as number, paginationStore.page as number, paginationStore.jenjang as string, paginationStore.kecamatan_id as string)
})
</script>

<template>
	<HomeLayout>
		<div class="flex justify-end gap-4 mb-4 p-8">
			<SearchableSelect placeholder="Pilih Kecamatan" :options="kecamatanOption" v-model="kecamatan_id" :loading="loadingKecamatan" />
			<SearchableSelect placeholder="Pilih Jenjang" :options="jenjangOption" v-model="jenjang" />
			<InputGroup palaceholder="per_page" v-model="per_page" name="per_page" />
			<span class="text-sm text-black">Total Sekolah: {{ loadingSekolah ? "sedang dihitung" : dataSekolah?.total }}</span>
		</div>
		<TabelSekolahComponent :data="loadingSekolah ? loadingDataSekolah : dataSekolah!" :loading="loadingSekolah" @prev-page="goToPrevPage" @next-page="goToNextPage" @page-change="goToPage" />
</HomeLayout>
</template>
