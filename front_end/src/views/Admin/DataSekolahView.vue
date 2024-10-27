<template>
	<DefaultLayout>
		<BreadcrumbDefault pageTitle="Data Sekolah" />
		<div>
			<!-- No data state -->

			<NoDataComponent v-if="dataSekolah?.data?.length === 0" title="Data Sekolah" message="Tidak ada data sekolah" />
			<!-- Data available state -->
			<template v-else>
				<div class="flex justify-end gap-4 mb-4">
					<SearchableSelect placeholder="Pilih Kecamatan" :options="kecamatanOption" v-model="kecamatan_id" :loading="loadingKecamatan" />
					<SearchableSelect placeholder="Pilih Jenjang" :options="jenjangOption" v-model="jenjang" />
					<InputGroup palaceholder="per_page" v-model="per_page" name="per_page" />
					<span class="text-sm text-black">Total Sekolah: {{ loadingSekolah ? "sedang dihitung" : dataSekolah?.total }}</span>
				</div>
				<TabelSekolahComponent :data="loadingSekolah ? loadingDataSekolah : dataSekolah!" :loading="loadingSekolah" />
			</template>
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
import { onMounted, computed, ref } from "vue"
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
	return buatOption(kecamatanList.value, "nama", "id")
})
const jenjangOption = ref<Option[]>([
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

onMounted(async() => {
	fetchKecamatan()
	fetchAllSekolah(paginationStore.per_page as number, paginationStore.page as number, paginationStore.jenjang as string, paginationStore.kecamatan_id as string)
})
</script>
