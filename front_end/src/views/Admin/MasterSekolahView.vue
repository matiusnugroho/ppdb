<template>
	<DefaultLayout>
		<BreadcrumbDefault pageTitle="Master Data Sekolah" />
		
		<div class="mb-4 flex justify-end">
			<button
				@click="openAddModal"
				class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
				<HeroIcon name="plus" class="mr-2 h-5 w-5" />
				Tambah Sekolah
			</button>
		</div>

		<MasterSekolahTable
			:data="dataSekolah!"
			:loading="loadingSekolah"
			@filter="handleFilter"
            @refresh="loadData"
			@prev-page="goToPrevPage"
			@next-page="goToNextPage"
			@page-change="goToPage" />
			
		<AddSekolahModal
			:is-open="isAddModalOpen"
			@close="closeAddModal"
			@success="handleSuccessAdd" />
	</DefaultLayout>
</template>

<script setup lang="ts">
import { onMounted, watch, ref } from "vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import MasterSekolahTable from "@/components/Dashboard/MasterSekolahTable.vue"
import { useSekolah } from "@/composable/useSekolah"
import { usePaginationStore } from "@/stores/paginationStore"
import { useKecamatan } from "@/composable/useKecamatan"
import AddSekolahModal from "@/components/Dashboard/AddSekolahModal.vue"
import HeroIcon from "@/components/Icon/HeroIcon.vue"

const paginationStore = usePaginationStore()
const { fetchAllSekolah, loadingSekolah, dataSekolah } = useSekolah()
const { fetchKecamatan } = useKecamatan()

const isAddModalOpen = ref(false)

const openAddModal = () => {
	isAddModalOpen.value = true
}

const closeAddModal = () => {
	isAddModalOpen.value = false
}

const handleSuccessAdd = () => {
	loadData()
}

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
