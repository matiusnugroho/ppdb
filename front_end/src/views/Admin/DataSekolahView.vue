<template>
	<DefaultLayout>
		<BreadcrumbDefault pageTitle="Data Sekolah" />
		<!-- <div> -->
		<!-- No data state -->

		<!-- <NoDataComponent v-if="dataSekolah?.data?.length === 0" title="Data Sekolah" message="Tidak ada data sekolah" /> -->
		<!-- Data available state -->
		<!-- <template v-else> -->
		<div class="flex justify-end gap-4 mb-4 items-center">
			<SearchableSelect placeholder="Pilih Kecamatan" :options="kecamatanOption" v-model="kecamatan_id" :loading="loadingKecamatan" />
			<SearchableSelect placeholder="Pilih Jenjang" :options="jenjangOption" v-model="jenjang" />
			<SearchableSelect v-model="per_page" name="per_page" :options="perPageOption" />
			<HeroIcon name="file-spreadsheet" size="32" class="h-24 w-24" />
			<span class="text-sm text-black">Total Sekolah: {{ loadingSekolah ? "sedang dihitung" : dataSekolah?.total }}</span>
		</div>
		<TabelSekolahComponent :data="loadingSekolah ? loadingDataSekolah : dataSekolah!" :loading="loadingSekolah" @prev-page="goToPrevPage" @next-page="goToNextPage" @page-change="goToPage" />
		<!-- </template> -->
		<!-- </div> -->
	</DefaultLayout>
</template>

<script setup lang="ts">
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import TabelSekolahComponent from "@/components/Dashboard/TabelSekolahComponent.vue"
import { useSekolah } from "@/composable/useSekolah"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { usePaginationStore } from "@/stores/paginationStore"
import { onMounted, computed, ref, watch } from "vue"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"
import { useKecamatan } from "@/composable/useKecamatan"
import { buatOption } from "@/helpers/buatOption"
import type { DataSekolah, Option } from "@/types"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
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

const perPageOption = ref<Option[]>([
	{ label: "10", value: 10 },
	{ label: "25", value: 25 },
	{ label: "50", value: 50 },
	{ label: "100", value: 100 },
	{ label: "Semua", value: "all" },
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

watch(per_page, (newVal) => {
	paginationStore.per_page = newVal
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
