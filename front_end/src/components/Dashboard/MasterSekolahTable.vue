<template>
	<div class="flex flex-col h-full rounded-xl bg-white shadow-sm border border-gray-100 overflow-hidden">
		<div class="p-6 border-b border-gray-100">
			<div class="flex flex-wrap justify-between gap-4 items-center">
				<h3 class="text-lg font-bold text-gray-800">Master Data Sekolah</h3>
				<div class="flex flex-wrap justify-end gap-2 items-center">
                    <div class="relative w-full sm:w-64">
                        <input 
                            v-model="searchTerm" 
                            type="text" 
                            placeholder="Cari Sekolah..." 
                            class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-10 pr-4 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" 
                        />
                        <HeroIcon name="view-finder" class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" />
                    </div>
					<div class="w-full sm:w-auto">
						<SearchableSelect v-model="per_page" name="per_page" :options="perPageOption" class="w-full sm:w-auto" />
					</div>
					<span class="text-sm font-medium text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100"> Total: {{ loading ? "..." : data?.total }} </span>
				</div>
			</div>
		</div>

		<!-- Scrollable Table Area -->
		<div class="flex-grow overflow-x-auto overflow-y-auto max-h-[calc(100vh-300px)] custom-scrollbar">
			<table class="table table-zebra table-pin-rows">
				<thead>
					<tr>
                        <th>No</th>
						<th>Nama Sekolah</th>
						<td><FilterSelect v-model="jenjang" :options="jenjangOption!" class="w-full" placeholder="Jenjang" :customClasses="'border-0 shadow-none'" /></td>
						<td>NSS</td>
						<td>NPSN</td>
                        <td>Username</td>
                        <td>Kecamatan <FilterSelect v-model="kecamatan_id" :options="kecamatanOption!" class="w-full mt-1" placeholder="Filter Kecamatan" :customClasses="'border-0 shadow-none'" /></td>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<template v-if="loading">
						<tr v-for="n in 5" :key="n">
							<td colspan="7">
								<div class="flex gap-4">
                                    <span class="skeleton h-4 w-8 rounded block"></span>
                                    <span class="skeleton h-4 w-36 rounded block"></span>
                                    <span class="skeleton h-4 w-24 rounded block"></span>
                                    <span class="skeleton h-4 w-24 rounded block"></span>
                                    <span class="skeleton h-4 w-24 rounded block"></span>
                                    <span class="skeleton h-4 w-36 rounded block"></span>
                                    <span class="skeleton h-4 w-12 rounded block"></span>
                                </div>
							</td>
						</tr>
					</template>
					<template v-else-if="data?.data.length === 0">
						<tr>
							<th colspan="7" class="text-center">
								<NoDataComponent title="Data Sekolah" message="Data Tidak Ditemukan" />
							</th>
						</tr>
					</template>
					<tr v-else v-for="(sekolah, index) in data?.data" :key="index">
                        <td>{{ (paginationStore.currentPage - 1) * (paginationStore.per_page as number) + index + 1 }}</td>
						<th>{{ sekolah.nama_sekolah }}</th>
						<td>
                            <span class="px-2 py-1 rounded text-xs font-semibold" 
                                :class="{'bg-blue-100 text-blue-700': sekolah.jenjang === 'sd', 'bg-orange-100 text-orange-700': sekolah.jenjang === 'smp'}">
                                {{ sekolah.jenjang.toUpperCase() }}
                            </span>
                        </td>
						<td>{{ sekolah.nss || '-' }}</td>
						<td>{{ sekolah.npsn || '-' }}</td>
                        <td class="font-mono text-sm">{{ sekolah.user?.username || '-' }}</td>
						<td>{{ sekolah.kecamatan?.nama || '-' }}</td>
                        <td>
                            <div class="flex gap-2">
                                <router-link 
                                    :to="{ name: 'sekolahDetail', params: { id: sekolah.id }, query: { mode: 'view' } }" 
                                    custom 
                                    v-slot="{ href, navigate }">
                                    <a :href="href" @click="handleAction($event, navigate, sekolah, 'view')" class="btn btn-sm btn-square btn-ghost text-blue-600 hover:bg-blue-50" title="Lihat Detail">
                                        <HeroIcon name="eye" class="w-5 h-5" />
                                    </a>
                                </router-link>

                                <router-link 
                                    :to="{ name: 'sekolahDetail', params: { id: sekolah.id }, query: { mode: 'edit' } }" 
                                    custom 
                                    v-slot="{ href, navigate }">
                                    <a :href="href" @click="handleAction($event, navigate, sekolah, 'edit')" class="btn btn-sm btn-square btn-ghost text-orange-600 hover:bg-orange-50" title="Edit Data">
                                        <HeroIcon name="document-text" class="w-5 h-5" />
                                    </a>
                                </router-link>
                            </div>
                        </td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- Pagination Area -->
		<div class="rounded-b-lg border-t border-gray-200 px-4 py-2">
            <!-- Reuse pagination logic from TabelSekolahWithDataComponent or create a shared component later. For now, duplication is safer for speed without breaking existing logic -->
			<ol class="flex justify-end gap-1 text-xs font-medium">
				<li v-if="data?.prevPage">
					<a @click.prevent="$emit('prev-page')" href="#" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180 hover:bg-gray-50">
						<span class="sr-only">Prev Page</span>
						<HeroIcon name="chevron-left" class="size-3" />
					</a>
				</li>

				<li v-for="page in Array.from({ length: data?.lastPage || 1 }, (_, index) => index + 1)" :key="page">
					<a
						href="#"
						class="block size-8 rounded border text-center leading-8"
						:class="paginationStore.currentPage === page ? 'bg-primary text-white border-primary' : 'text-gray-900 border-gray-100 bg-white hover:bg-gray-100'"
						@click.prevent="$emit('page-change', page)">
						{{ page }}
					</a>
				</li>

				<li v-if="data?.nextPage">
					<a @click.prevent="$emit('next-page')" href="#" class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900 rtl:rotate-180 hover:bg-gray-50">
						<span class="sr-only">Next Page</span>
                        <HeroIcon name="chevron-right" class="size-3" />
					</a>
				</li>
			</ol>
		</div>

        <!-- Modal for View/Edit -->
        <SekolahFormModal 
            :is-open="modalOpen"
            :is-edit-mode="modalMode === 'edit'"
            :school-data="selectedSekolah"
            :loading="loadingAction"
            @close="closeModal"
            @submit="handleModalSubmit"
        />
	</div>
</template>

<script setup lang="ts">
import { ref, computed, watch, type PropType } from "vue"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"
import FilterSelect from "@/components/Forms/FilterSelect.vue"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import NoDataComponent from "@/components/UI/NoDataComponent.vue"
import SekolahFormModal from "@/components/Dashboard/SekolahFormModal.vue"
import { usePaginationStore } from "@/stores/paginationStore"
import { useKecamatan } from "@/composable/useKecamatan"
// import logger from "@/utils/logger" // Removed due to missing module
import { buatOption } from "@/helpers/buatOption"
import type { DataSekolah, Option, School } from "@/types"
import jenjangData from "@/config/jenjang"
import { useSekolah } from "@/composable/useSekolah"
import { showToast } from "@/utils/ui/toast"

const props = defineProps({
	data: {
		type: Object as PropType<DataSekolah>,
		required: false,
	},
	loading: {
		type: Boolean,
		default: false,
	},
})

const emit = defineEmits(["filter", "page-change", "prev-page", "next-page", "refresh"])

const paginationStore = usePaginationStore()
const { kecamatanList } = useKecamatan()
const { updateSekolah } = useSekolah()

const kecamatan_id = ref("")
const jenjang = ref("")
const per_page = ref("20")
const searchTerm = ref("")
let searchTimeout: ReturnType<typeof setTimeout> | null = null

const modalOpen = ref(false)
const modalMode = ref<'view' | 'edit'>('view')
const selectedSekolah = ref<School | null>(null)
const loadingAction = ref(false)

const kecamatanOption = computed<Option[]>(() => {
	const options = buatOption(kecamatanList.value, "nama", "id")
	return [{ value: null, label: "Semua Kecamatan" }, ...options]
})
const jenjangOption = ref<Option[]>([{ label: "Semua Jenjang", value: null }, ...jenjangData])

const perPageOption = ref<Option[]>([
	{ label: "10", value: 10 },
	{ label: "20", value: 20 },
	{ label: "50", value: 50 },
	{ label: "100", value: 100 },
])

// Watchers for filters
watch([kecamatan_id, jenjang], () => {
    emit('filter', kecamatan_id.value, jenjang.value, searchTerm.value)
})

watch(per_page, (newVal) => {
    paginationStore.per_page = Number(newVal)
    emit('filter', kecamatan_id.value, jenjang.value, searchTerm.value)
})

watch(searchTerm, (newVal) => {
    if (searchTimeout) clearTimeout(searchTimeout)
    searchTimeout = setTimeout(() => {
        paginationStore.search = newVal
        emit('filter', kecamatan_id.value, jenjang.value, newVal)
    }, 500)
})

// Handle Actions
const handleAction = (event: MouseEvent, navigate: () => void, sekolah: School, mode: 'view' | 'edit') => {
    // If ctrl or cmd key pressed, or middle click, let default behavior (open in new tab) happen
    if (event.ctrlKey || event.metaKey || event.button === 1) {
        return; 
    }
    
    // Otherwise prevent navigation and open modal
    event.preventDefault();
    selectedSekolah.value = sekolah
    modalMode.value = mode
    modalOpen.value = true
}

const closeModal = () => {
    modalOpen.value = false
    selectedSekolah.value = null
}

const handleModalSubmit = async (formData: any) => {
    if (!selectedSekolah.value) return

    loadingAction.value = true
    const success = await updateSekolah(selectedSekolah.value.id, formData)
    loadingAction.value = false

    if (success) {
        showToast({ message: "Data sekolah berhasil diperbarui" })
        closeModal()
        emit('refresh')
    } else {
        showToast({ message: "Gagal memperbarui data sekolah", type: 'error' })
    }
}
</script>
