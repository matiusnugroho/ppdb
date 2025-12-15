<template>
	<DefaultLayout>
		<BreadcrumbDefault pageTitle="Master Data Sekolah" />
		<MasterSekolahTable
			:data="dataSekolah!"
			:loading="loadingSekolah"
			@filter="handleFilter"
            @refresh="loadData"
			@prev-page="goToPrevPage"
			@next-page="goToNextPage"
			@page-change="goToPage" />
	</DefaultLayout>
</template>

<script setup lang="ts">
import { onMounted, watch } from "vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import MasterSekolahTable from "@/components/Dashboard/MasterSekolahTable.vue"
import { useSekolah } from "@/composable/useSekolah"
import { usePaginationStore } from "@/stores/paginationStore"
import { useKecamatan } from "@/composable/useKecamatan"

const paginationStore = usePaginationStore()
const { fetchAllSekolah, loadingSekolah, dataSekolah } = useSekolah()
const { fetchKecamatan } = useKecamatan()

const loadData = () => {
    fetchAllSekolah(
        paginationStore.per_page as number, 
        paginationStore.currentPage, 
        paginationStore.jenjang as string, 
        paginationStore.kecamatan_id as string,
        paginationStore.search as string
    )
}

const goToPage = (page: number) => {
	paginationStore.page = page
	paginationStore.currentPage = page
	loadData()
}

const goToNextPage = () => {
	paginationStore.page = (paginationStore.page as number) + 1
	paginationStore.currentPage = (paginationStore.currentPage as number) + 1
	loadData()
}

const goToPrevPage = () => {
	paginationStore.page = (paginationStore.page as number) - 1
	paginationStore.currentPage = (paginationStore.currentPage as number) - 1
	loadData()
}

const handleFilter = (kecamatan: string, jenjang: string, search: string) => {
	paginationStore.kecamatan_id = kecamatan
	paginationStore.jenjang = jenjang
    paginationStore.search = search
    paginationStore.page = 1
    paginationStore.currentPage = 1
    loadData()
}

onMounted(async () => {
	await paginationStore.resetTodefault()
	fetchKecamatan()
	loadData()
})
</script>
