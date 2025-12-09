<script setup lang="ts">
import LoadingInfoComponent from "@/components/UI/LoadingInfoComponent.vue"
import DashboardSummaryCard from "@/components/Dashboard/Components/DashboardSummaryCard.vue"
import ValidationStatusCard from "@/components/Dashboard/Components/ValidationStatusCard.vue"
import JalurMasukStatsCard from "@/components/Dashboard/Components/JalurMasukStatsCard.vue"
import HeroIcon from "../Icon/HeroIcon.vue"
import { useStatistik } from "@/composable/useStatistik"
import { onMounted, computed, ref, watch } from "vue"
import { showToast } from "@/utils/ui/toast"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import { usePendaftaran } from "@/composable/usePendaftaran"

const { statistik, fetchStatistik, error, loadingStatistik } = useStatistik()
const { fetchAllPeriods } = usePendaftaran()

const periods = ref<any[]>([])
const selectedPeriod = ref<string>("")

onMounted(async () => {
	periods.value = await fetchAllPeriods()
	// Set default to the first one (assuming sorted by latest) or handle logic to find active
    // If we want to default to "Active", we might just fetch without params first
    // But since we want the dropdown to reflect current state:
    const activeInfo = periods.value.find(p => p.is_open)
    if (activeInfo) selectedPeriod.value = activeInfo.id

	fetchStatistik({ period_id: selectedPeriod.value })
	if (error.value) {
		showToast({
			message: error?.value ?? "An unknown error occurred",
			type: "error",
		})
	}
})

watch(selectedPeriod, (newVal) => {
    fetchStatistik({ period_id: newVal })
})

const percentageText = computed(() => {
	const lulus = (statistik.value?.lulus as number) ?? 0
	// Try to get daya_tampung from statistics if available (added to API response)
	// We need to cast it since it's loosely typed in frontend currently
	const dayaTampung = (statistik.value as any)?.daya_tampung ?? 0
	
	if (!dayaTampung || dayaTampung === 0) return "Kuota belum ditentukan"
	
	const percentage = Math.round((lulus / dayaTampung) * 100)
	return `${percentage}% dari kuota terpenuhi`
})
</script>

<template>
	<div class="flex flex-col gap-4 mb-6">
		<BreadcrumbDefault pageTitle="Dashboard" />
		<div class="form-control w-full sm:w-auto">
			<select v-model="selectedPeriod" class="select select-bordered w-full max-w-xs">
				<option disabled value="">Pilih Tahun Ajaran</option>
				<option v-for="period in periods" :key="period.id" :value="period.id">
					{{ period.tahun_ajaran }} ({{ period.is_open ? 'Aktif' : 'Tutup' }})
				</option>
			</select>
		</div>
	</div>
	<LoadingInfoComponent v-if="loadingStatistik" />
	<div v-else class="space-y-6">
		<!-- Top Row: Summaries -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
			<!-- Total Pendaftar -->
			<DashboardSummaryCard title="Total Pendaftar" :value="(statistik?.pendaftar as number) ?? 0" variant="blue" tagLabel="Data masuk hari ini">
				<template #icon>
					<HeroIcon name="user-group" class="w-6 h-6" />
				</template>
				<template #tag-icon>
					<HeroIcon name="arrow-trending-up" class="w-4 h-4" />
				</template>
			</DashboardSummaryCard>

			<!-- Lulus Seleksi -->
			<DashboardSummaryCard title="Lulus Seleksi" :value="(statistik?.lulus as number) ?? 0" variant="green" :tagLabel="percentageText">
				<template #icon>
					<HeroIcon name="academic-cap" class="w-6 h-6" />
				</template>
				<template #tag-icon>
					<HeroIcon name="check-circle" class="w-4 h-4" />
				</template>
			</DashboardSummaryCard>

			<!-- Tidak Lulus -->
			<DashboardSummaryCard title="Tidak Lulus" :value="(statistik?.tidak_lulus as number) ?? 0" variant="red" tagLabel="Perlu tindak lanjut admin">
				<template #icon>
					<HeroIcon name="x-circle" class="w-6 h-6" />
				</template>
				<template #tag-icon>
					<HeroIcon name="exclamation-circle" class="w-4 h-4" />
				</template>
			</DashboardSummaryCard>
		</div>

		<!-- Bottom Row: Validation Status & Jalur Stats -->
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
			<!-- Validation Status (Left Column) -->
			<div class="lg:col-span-1">
				<ValidationStatusCard 
					:pending="(statistik?.pending as number) ?? 0"
					:valid="(statistik?.diverifikasi as number) ?? 0"
					:ditolak="(statistik?.ditolak as number) ?? 0"
				/>
			</div>

			<!-- Jalur Masuk Stats (Right 2 Columns) -->
			<div class="lg:col-span-2">
				<JalurMasukStatsCard :data="(statistik?.jumlah_per_jalur as unknown as Record<string, number>) ?? {}" />
			</div>
		</div>
	</div>
</template>
