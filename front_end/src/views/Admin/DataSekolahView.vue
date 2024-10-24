<template>
	<DefaultLayout>
		<BreadcrumbDefault pageTitle="Data Sekolah" />
		<div>
			<!-- Loading state -->
			{{ dataSekolah?.data.length }}
			<p v-if="loadingSekolah">Loading...</p>
			<!-- No data state -->

			<NoDataComponent v-else-if="!loadingSekolah && (!dataSekolah || dataSekolah.data?.length === 0)" title="Data Sekolah" message="Tidak ada data sekolah" />
			<!-- Data available state -->

			<TabelSekolahComponent v-else :data="dataSekolah!" />
		</div>
	</DefaultLayout>
</template>

<script setup lang="ts">
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import TabelSekolahComponent from "@/components/Dashboard/TabelSekolahComponent.vue"
import NoDataComponent from "@/components/UI/NoDataComponent.vue"
import { useSekolah } from "@/composable/useSekolah"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { usePaginationStore } from "@/stores/paginationStore"
import { onMounted } from "vue"

const paginationStore = usePaginationStore()
const { fetchAllSekolah, loadingSekolah, dataSekolah } = useSekolah()

onMounted(() => {
	fetchAllSekolah(paginationStore.per_page as number, paginationStore.page as number, paginationStore.jenjang as string, paginationStore.kecamatan_id as string)
})
</script>
