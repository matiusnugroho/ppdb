<template>
	<div class="flex flex-col h-full">
		<div class="flex flex-wrap justify-end gap-2 sm:gap-4 mb-4 items-center">
			<div class="w-full sm:w-auto">
				<SearchableSelect v-model="per_page" name="per_page" :options="perPageOption" class="w-full sm:w-auto" />
			</div>
			<!-- Container for button and total sekolah -->
			<div class="w-full sm:w-auto flex justify-end items-center gap-2">
				<span class="inline-flex overflow-visible rounded-md bg-white shadow-sm">
					<div class="tooltip" data-tip="Download Excel">
						<button class="inline-block border-e p-3 text-gray-700 hover:bg-gray-50 focus:relative" title="Edit Product" @click="exportSekolah">
							<HeroIcon name="file-spreadsheet" size="18" class="h-6 w-6" />
						</button>
					</div>
					<div v-if="needimportbutton" class="tooltip" data-tip="Import Excel">
						<button class="inline-block p-3 text-gray-700 hover:bg-gray-50 focus:relative" title="Delete Product">
							<HeroIcon name="upload-double" size="18" class="h-6 w-6" />
						</button>
					</div>
				</span>
				<span class="text-sm text-black"> Total Sekolah: {{ loadingSekolah ? "sedang dihitung" : dataSekolah?.total }} </span>
			</div>
		</div>
		<!-- Scrollable Table Area -->
		<div class="flex-grow overflow-x-auto overflow-y-auto max-h-[calc(100vh-300px)] custom-scrollbar">
			<table class="table table-pin-rows table-pin-cols">
				<thead>
					<tr>
						<th>Nama Sekolah</th>
						<td><FilterSelect v-model="jenjang" :options="jenjangOption!" class="w-full" placeholder="Jenjang" :customClasses="'border-0 shadow-none'" /></td>
						<td>NSS</td>
						<td>NPSN</td>
						<td>Daya Tampung</td>
						<td v-for="(jalur, index) in dataJalurPendaftaran" :key="index">{{ jalur.name }}</td>
						<td><FilterSelect v-model="kecamatan_id" :options="kecamatanOption!" class="w-full" placeholder="Kecamatan" :customClasses="'border-0 shadow-none'" /></td>
					</tr>
				</thead>
				<tbody>
					<template v-if="loadingSekolah">
						<tr v-for="n in 5" :key="n">
							<th>
								<span class="skeleton h-4 w-36 rounded block"></span>
							</th>
							<td>
								<span class="skeleton h-4 w-24 rounded block"></span>
							</td>
							<td>
								<span class="skeleton h-4 w-24 rounded block"></span>
							</td>
							<td>
								<span class="skeleton h-4 w-24 rounded block"></span>
							</td>
							<td>
								<span class="skeleton h-4 w-24 rounded block"></span>
							</td>
							<td>
								<span class="skeleton h-4 w-24 rounded block"></span>
							</td>
						</tr>
					</template>
					<template v-else-if="dataSekolah?.data.length === 0">
						<tr>
							<th colspan="5" class="text-center">
								<NoDataComponent title="Data Sekolah" message="Data Tidak Ditemukan" />
							</th>
						</tr>
					</template>
					<tr v-else v-for="(sekolah, index) in dataSekolah?.data" :key="index">
						<th>{{ sekolah.nama_sekolah }}</th>
						<td>{{ sekolah.jenjang }}</td>
						<td>{{ sekolah.nss }}</td>
						<td>{{ sekolah.npsn }}</td>
						<td>{{ sekolah.daya_tampung }}</td>
						<td v-for="(jalur, index) in dataJalurPendaftaran" :key="index">{{ sekolah.path_counts && sekolah.path_counts[jalur.name] ? sekolah.path_counts[jalur.name] : 0 }}</td>
						<td>{{ sekolah.kecamatan.nama }}</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th>Nama Sekolah</th>
						<td>Jenjang</td>
						<td>NSS</td>
						<td>NPSN</td>
						<td>Daya Tampung</td>
						<td v-for="(jalur, index) in dataJalurPendaftaran" :key="index">{{ jalur.name }}</td>
						<td>Kecamatan</td>
					</tr>
				</tfoot>
			</table>
		</div>

		<!-- Pagination Area -->
		<div class="rounded-b-lg border-t border-gray-200 px-4 py-2">
			<ol class="flex justify-end gap-1 text-xs font-medium">
				<li v-if="data?.prevPage">
					<a @click.prevent="goToPrevPage" href="#cikontot" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180">
						<span class="sr-only">Prev Page</span>
						<svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
						</svg>
					</a>
				</li>

				<li v-for="page in Array.from({ length: dataSekolah?.lastPage || 1 }, (_, index) => index + 1)" :key="page">
					<a
						href="#"
						class="block size-8 rounded border text-center leading-8"
						:class="paginationStore.currentPage === page ? 'bg-primary text-white border-primary hover:bg-blue-500' : 'text-gray-900 border-gray-100 bg-white hover:bg-gray-100'"
						@click.prevent="goToPage(page)">
						{{ page }}
					</a>
				</li>

				<li v-if="data?.nextPage">
					<a @click.prevent="goToNextPage" href="#cikontot" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180">
						<span class="sr-only">Next Page</span>
						<svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
						</svg>
					</a>
				</li>
			</ol>
		</div>
	</div>
</template>
<script setup lang="ts">
import NoDataComponent from "@/components/UI/NoDataComponent.vue"
import { usePendaftaran } from "@/composable/usePendaftaran"
import { useSekolah } from "@/composable/useSekolah"
import { usePaginationStore } from "@/stores/paginationStore"
import { onMounted, computed, ref, watch, type PropType } from "vue"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"
import { useKecamatan } from "@/composable/useKecamatan"
import { buatOption } from "@/helpers/buatOption"
import type { DataSekolah, Option } from "@/types"
//import IconButton from "@/components/UI/Buttons/IconButton.vue"
import { ENDPOINTS } from "@/config/endpoint"
const { kecamatanList, fetchKecamatan } = useKecamatan()
import jenjangData from "@/config/jenjang"
import FilterSelect from "@/components/Forms/FilterSelect.vue"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
const kecamatan_id = ref("")
const jenjang = ref("")
const per_page = ref()
const kecamatanOption = computed<Option[]>(() => {
	const options = buatOption(kecamatanList.value, "nama", "id")
	return [{ value: null, label: "Semua Kecamatan" }, ...options]
})
const jenjangOption = ref<Option[]>([{ label: "Semua Jenjang", value: null }, ...jenjangData])

const perPageOption = ref<Option[]>([
	{ label: "10", value: 10 },
	{ label: "25", value: 25 },
	{ label: "50", value: 50 },
	{ label: "100", value: 100 },
	{ label: "Semua", value: "all" },
])
const paginationStore = usePaginationStore()
const { fetchAllSekolah, loadingSekolah, dataSekolah } = useSekolah()

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

const exportSekolah = () => {
	const base_export_api = ENDPOINTS.DOWNLOAD_EXCEL_SEKOLAH_WITH_DATA
	const params = new URLSearchParams()
	if (paginationStore.jenjang !== null) params.append("jenjang", paginationStore.jenjang)
	if (paginationStore.kecamatan_id !== null) params.append("kecamatan_id", paginationStore.kecamatan_id)
	if (paginationStore.per_page !== null) params.append("per_page", paginationStore.per_page as unknown as string)
	if (paginationStore.page !== null) params.append("page", paginationStore.page as unknown as string)
	const export_api = `${base_export_api}?${params.toString()}`
	window.open(export_api, "_blank")
}

defineProps({
	data: {
		type: Object as PropType<DataSekolah>,
		required: false,
	},
	loading: {
		type: Boolean,
		default: false,
	},
	needimportbutton: {
		type: Boolean,
		default: false,
	}
})
const { fetchJalurPendaftaran, dataJalurPendaftaran } = usePendaftaran()

onMounted(async () => {
	await paginationStore.resetTodefault()
	fetchKecamatan()
	fetchAllSekolah(paginationStore.per_page as number, paginationStore.page as number, paginationStore.jenjang as string, paginationStore.kecamatan_id as string)
	fetchJalurPendaftaran()
})
</script>
