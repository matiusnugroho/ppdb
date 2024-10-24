<template>
	<div class="flex justify-end gap-4 mb-4">
		<SearchableSelect placeholder="Pilih Kecamatan" :options="kecamatanOption" v-model="kecamatan_id" :loading="loadingKecamatan" />
		<SearchableSelect placeholder="Pilih Jenjang" :options="jenjangOption" v-model="jenjang" />
		<span class="text-sm text-black">Total Sekolah: {{ data?.total }}</span>
	</div>

	<div class="overflow-x-auto max-h-[600px] overflow-y-auto">
		<table class="table table-pin-rows table-pin-cols">
			<thead>
				<tr>
					<th>Nama Sekolah</th>
					<td>Jenjang</td>
					<td>NSS</td>
					<td>NPSN</td>
					<td>Kecamatan</td>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(sekolah, index) in data?.data" :key="index">
					<th>{{ sekolah.nama_sekolah }}</th>
					<td>{{ sekolah.jenjang }}</td>
					<td>{{ sekolah.nss }}</td>
					<td>{{ sekolah.npsn }}</td>
					<td>{{ sekolah.kecamatan.nama }}</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th>Nama Sekolah</th>
					<td>Jenjang</td>
					<td>NSS</td>
					<td>NPSN</td>
					<td>Kecamatan</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="rounded-b-lg border-t border-gray-200 px-4 py-2">
		<ol class="flex justify-end gap-1 text-xs font-medium">
			<li>
				<a href="#" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180">
					<span class="sr-only">Prev Page</span>
					<svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
						<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
					</svg>
				</a>
			</li>

			<li>
				<a href="#" class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900"> 1 </a>
			</li>

			<li class="block size-8 rounded border-blue-600 bg-blue-600 text-center leading-8 text-white">2</li>

			<li>
				<a href="#" class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900"> 3 </a>
			</li>

			<li>
				<a href="#" class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900"> 4 </a>
			</li>

			<li>
				<a href="#" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180">
					<span class="sr-only">Next Page</span>
					<svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
					</svg>
				</a>
			</li>
		</ol>
	</div>
</template>
<script setup lang="ts">
import type { DataSekolah } from "@/types"
import { onMounted, computed, ref, type PropType } from "vue"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"
import { useKecamatan } from "@/composable/useKecamatan"
import { buatOption } from "@/helpers/buatOption"
import type { Option } from "@/types"
const { kecamatanList, fetchKecamatan, loadingKecamatan } = useKecamatan()
const kecamatan_id = ref("")
const jenjang = ref("")
const jenjangOption = ref<Option[]>([
	{ label: "SD", value: "sd" },
	{ label: "SMP", value: "smp" },
])
defineProps({
	data: {
		type: Object as PropType<DataSekolah>,
		required: false,
	},
})
const kecamatanOption = computed<Option[]>(() => {
	return buatOption(kecamatanList.value, "nama", "id")
})
onMounted(() => {
	fetchKecamatan()
})
</script>
