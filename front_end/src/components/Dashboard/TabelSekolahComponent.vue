<template>
	<div class="flex flex-col h-full">
		<!-- Scrollable Table Area -->
		<div class="flex-grow overflow-x-auto overflow-y-auto max-h-[calc(100vh-300px)] custom-scrollbar">
			<table class="table table-pin-rows table-pin-cols">
				<thead>
					<tr>
						<th>Nama Sekolah</th>
						<td class="align-top">
							<div class="flex flex-col items-start gap-2">
								<FilterSelect v-model="jenjang" :options="jenjangOptions!" class="w-full" placeholder="Jenjang" :customClasses="'border-0 shadow-none'" />
							</div>
						</td>
						<td>NSS</td>
						<td>NPSN</td>
						<td>Daya Tampung</td>
						<td class="align-top">
							<div class="flex flex-col items-start gap-2">
								<FilterSelect v-model="kecamatan" :options="kecamatanOptions!" class="w-full" placeholder="Kecamatan" :customClasses="'border-0 shadow-none'" />
							</div>
						</td>
					</tr>
				</thead>
				<tbody>
					<template v-if="loading">
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
					<template v-else-if="data?.data.length === 0">
						<tr>
							<th colspan="5" class="text-center">
								<NoDataComponent title="Data Sekolah" message="Data Tidak Ditemukan" />
							</th>
						</tr>
					</template>
					<tr v-else v-for="(sekolah, index) in data?.data" :key="index">
						<th>{{ sekolah.nama_sekolah }}</th>
						<td>{{ sekolah.jenjang }}</td>
						<td>{{ sekolah.nss }}</td>
						<td>{{ sekolah.npsn }}</td>
						<td>{{ sekolah.daya_tampung }}</td>
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
						<td>Kecamatan</td>
					</tr>
				</tfoot>
			</table>
		</div>

		<!-- Pagination Area -->
		<div class="rounded-b-lg border-t border-gray-200 px-4 py-2">
			<ol class="flex justify-end gap-1 text-xs font-medium">
				<li v-if="data?.prevPage">
					<a @click.prevent="emitPrevPage" href="#cikontot" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180">
						<span class="sr-only">Prev Page</span>
						<svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
						</svg>
					</a>
				</li>

				<li v-for="page in Array.from({ length: data?.lastPage || 1 }, (_, index) => index + 1)" :key="page">
					<a
						href="#"
						class="block size-8 rounded border text-center leading-8"
						:class="paginationStore.currentPage === page ? 'bg-primary text-white border-primary hover:bg-blue-500' : 'text-gray-900 border-gray-100 bg-white hover:bg-gray-100'"
						@click.prevent="emitPageChange(page)">
						{{ page }}
					</a>
				</li>

				<li v-if="data?.nextPage">
					<a @click.prevent="emitNextPage" href="#cikontot" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180">
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
import { usePaginationStore } from "@/stores/paginationStore"
import type { DataSekolah, Option } from "@/types"
import { type PropType, ref, watch } from "vue"
import NoDataComponent from "@/components/UI/NoDataComponent.vue"
import FilterSelect from "@/components/Forms/FilterSelect.vue"

const kecamatan = ref("")
const jenjang = ref("")

const emit = defineEmits<{
	(event: "prev-page"): void
	(event: "next-page"): void
	(event: "page-change", page: number): void
	(event: "filter", kecamatan: string, jenjang: string): void
}>()
const emitPrevPage = () => {
	emit("prev-page")
}

const emitNextPage = () => {
	emit("next-page")
}

const emitPageChange = (page: number) => {
	emit("page-change", page)
}

const emitFilter = (kecamatan: string, jenjang: string) => {
	emit("filter", kecamatan, jenjang)
}
watch([kecamatan, jenjang], ([newKecamatan, newJenjang]) => {
  emitFilter(newKecamatan, newJenjang)
})

defineProps({
	data: {
		type: Object as PropType<DataSekolah>,
		required: false,
	},
	kecamatanOptions: {
		type: Array as PropType<Option[]>,
	},
	jenjangOptions: {
		type: Array as PropType<Option[]>,
	},
	loading: {
		type: Boolean,
		default: false,
	},
})

const paginationStore = usePaginationStore()
</script>
