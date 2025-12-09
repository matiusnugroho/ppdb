<script setup lang="ts">
import { onMounted, computed, ref, watch } from "vue"
import { useSekolah } from "@/composable/useSekolah"
import { usePaginationStore } from "@/stores/paginationStore"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"
import FilterSelect from "@/components/Forms/FilterSelect.vue"
import { useKecamatan } from "@/composable/useKecamatan"
import { buatOption } from "@/helpers/buatOption"
import type { DataSekolah, Option } from "@/types"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import LoadingInfoComponent from "@/components/UI/LoadingInfoComponent.vue"
import NoDataComponent from "@/components/UI/NoDataComponent.vue"

const { kecamatanList, fetchKecamatan } = useKecamatan()
const kecamatan_id = ref("")
const jenjang = ref("")
const per_page = ref("10") // Default to string "10" to match SearchableSelect expectations
const kecamatanOption = computed<Option[]>(() => {
	const options = buatOption(kecamatanList.value, "nama", "id")
	return [{ value: "", label: "Semua Kecamatan" }, ...options]
})
const jenjangOption = ref<Option[]>([
	{ label: "Semua Jenjang", value: "" },
	{ label: "SD", value: "sd" },
	{ label: "SMP", value: "smp" },
])
const paginationStore = usePaginationStore()
const { fetchAllSekolah, loadingSekolah, dataSekolah } = useSekolah()

const perPageOption = ref<Option[]>([
	{ label: "10 Sekolah", value: "10" },
	{ label: "25 Sekolah", value: "25" },
	{ label: "50 Sekolah", value: "50" },
	{ label: "100 Sekolah", value: "100" },
])

watch(kecamatan_id, (newVal) => {
	paginationStore.kecamatan_id = newVal
	fetchAllSekolah(Number(per_page.value), 1, jenjang.value, newVal)
})

watch(jenjang, (newVal) => {
	paginationStore.jenjang = newVal
	fetchAllSekolah(Number(per_page.value), 1, newVal, kecamatan_id.value)
})

watch(per_page, (newVal) => {
	paginationStore.per_page = Number(newVal)
	fetchAllSekolah(Number(newVal), 1, jenjang.value, kecamatan_id.value)
})

const goToPage = (page: number) => {
	paginationStore.page = page
	paginationStore.currentPage = page
	fetchAllSekolah(Number(per_page.value), page, jenjang.value, kecamatan_id.value)
}

const goToNextPage = () => {
    if (dataSekolah.value?.nextPage) {
        goToPage(dataSekolah.value.currentPage + 1)
    }
}

const goToPrevPage = () => {
    if (dataSekolah.value?.prevPage) {
        goToPage(dataSekolah.value.currentPage - 1)
    }
}

onMounted(async () => {
	await paginationStore.resetTodefault()
	fetchKecamatan()
    // Initialize default values
    per_page.value = "10"
	fetchAllSekolah(10, 1, "", "")
})
</script>

<template>
	<div class="min-h-screen bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-7xl mx-auto space-y-8">
			
            <!-- Hero Header -->
			<div class="text-center space-y-4">
				<h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl tracking-tight">
					Direktori <span class="text-indigo-600 bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">Sekolah</span>
				</h1>
				<p class="max-w-2xl mx-auto text-lg text-gray-600">
					Temukan informasi lengkap mengenai sekolah-sekolah di Kabupaten Kuantan Singingi.
				</p>
			</div>

            <!-- Filters & Controls -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-center justify-between sticky top-20 z-10 backdrop-blur-xl bg-white/90">
                <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto flex-1">
                    <div class="w-full md:max-w-xs">
                         <FilterSelect 
                            v-model="kecamatan_id" 
                            :options="kecamatanOption" 
                            placeholder="Pilih Kecamatan"
                            class="w-full"
                        />
                    </div>
                    <div class="w-full md:max-w-[200px]">
                         <FilterSelect 
                            v-model="jenjang" 
                            :options="jenjangOption" 
                            placeholder="Jenjang"
                            class="w-full"
                        />
                    </div>
                </div>
                
                <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                    <SearchableSelect 
                        v-model="per_page" 
                        name="per_page" 
                        :options="perPageOption" 
                        class="min-w-[140px]"
                    />
                    <div class="text-sm font-medium text-gray-500 whitespace-nowrap bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">
                        Total: <span class="text-indigo-600 font-bold">{{ loadingSekolah ? "..." : dataSekolah?.total ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div v-if="loadingSekolah" class="flex justify-center py-12">
                <LoadingInfoComponent />
            </div>

            <div v-else-if="!dataSekolah?.data || dataSekolah.data.length === 0" class="py-12">
                 <NoDataComponent title="Tidak Ditemukan" message="Maaf, tidak ada data sekolah yang sesuai dengan filter Anda." />
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- School Card -->
                <div 
                    v-for="(sekolah, index) in dataSekolah.data" 
                    :key="sekolah.id || index"
                    class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:border-indigo-100 transition-all duration-300 flex flex-col"
                >
                    <!-- Card Header -->
                    <div class="p-6 pb-4 relative">
                        <div class="absolute top-0 left-0 w-1.5 h-full" :class="sekolah.jenjang?.toLowerCase() === 'sd' ? 'bg-blue-500' : 'bg-orange-500'"></div>
                        <div class="flex justify-between items-start gap-4 mb-2 pl-3">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                {{ sekolah.nama_sekolah }}
                            </h3>
                            <span 
                                class="px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wide shrink-0"
                                :class="sekolah.jenjang?.toLowerCase() === 'sd' 
                                    ? 'bg-blue-50 text-blue-700 border border-blue-100' 
                                    : 'bg-orange-50 text-orange-700 border border-orange-100'"
                            >
                                {{ sekolah.jenjang }}
                            </span>
                        </div>
                        <div class="pl-3 flex flex-col gap-1 text-sm text-gray-500">
                             <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-400 text-xs uppercase">NPSN:</span>
                                <span class="font-mono text-gray-700">{{ sekolah.npsn }}</span>
                             </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="px-6 py-4 bg-gray-50/50 border-t border-b border-gray-100 flex-1 pl-9 space-y-4">
                        <!-- Location & Address -->
                        <div class="flex items-start gap-3">
                            <HeroIcon name="map-pin" class="w-5 h-5 text-gray-400 mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase mb-1">Lokasi</p>
                                <p class="text-sm font-medium text-gray-700">{{ sekolah.kecamatan?.nama }}</p>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ sekolah.alamat }}</p>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="flex items-start gap-3">
                            <HeroIcon name="phone" class="w-5 h-5 text-gray-400 mt-0.5 shrink-0" />
                            <div class="w-full">
                                <p class="text-xs font-bold text-gray-400 uppercase mb-1">Kontak</p>
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-700 flex items-center gap-2">
                                        {{ sekolah.no_telp || '-' }}
                                    </p>
                                    <div v-if="sekolah.email" class="flex items-center gap-1.5 min-w-0">
                                        <p class="text-xs text-indigo-600 truncate break-all">{{ sekolah.email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Headmaster -->
                        <div class="flex items-start gap-3">
                            <HeroIcon name="user-circle" class="w-5 h-5 text-gray-400 mt-0.5 shrink-0" />
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase mb-1">Kepala Sekolah</p>
                                <p class="text-sm font-medium text-gray-700 capitalize">{{ sekolah.nama_kepsek }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-4 pl-9 flex items-center justify-between bg-white">
                        <div class="text-xs font-medium text-gray-500">
                            Daya Tampung
                        </div>
                        <div class="flex items-center gap-2">
                            <HeroIcon name="user-group" class="w-4 h-4 text-indigo-500" />
                            <span class="text-lg font-bold text-gray-900">{{ sekolah.daya_tampung }}</span>
                            <span class="text-xs text-gray-400">Siswa</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="!loadingSekolah && dataSekolah?.data && dataSekolah.data.length > 0" class="flex justify-center mt-12">
                 <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <!-- Prev -->
                    <button 
                        @click="goToPrevPage"
                        :disabled="!dataSekolah.prevPage"
                        class="relative inline-flex items-center rounded-l-md px-3 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span class="sr-only">Previous</span>
                        <HeroIcon name="chevron-left" class="h-5 w-5" aria-hidden="true" />
                    </button>
                    
                    <!-- Pages (Simple Logic for now) -->
                    <template v-for="page in dataSekolah.lastPage" :key="page">
                        <button 
                             v-if="Math.abs(page - dataSekolah.currentPage) < 3 || page === 1 || page === dataSekolah.lastPage"
                            @click="goToPage(page)"
                            :class="[
                                page === dataSekolah.currentPage 
                                    ? 'relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' 
                                    : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0'
                            ]"
                        >
                            {{ page }}
                        </button>
                        <span v-else-if="Math.abs(page - dataSekolah.currentPage) === 3" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">
                            ...
                        </span>
                    </template>

                    <!-- Next -->
                    <button 
                        @click="goToNextPage"
                        :disabled="!dataSekolah.nextPage"
                        class="relative inline-flex items-center rounded-r-md px-3 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span class="sr-only">Next</span>
                        <HeroIcon name="chevron-right" class="h-5 w-5" aria-hidden="true" />
                    </button>
                </nav>
            </div>

		</div>
	</div>
</template>
