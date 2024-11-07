<script setup lang="ts">
import StatsCardComponent from "@/components/UI/StatsCardComponent.vue"
import LoadingInfoComponent from "@/components/UI/LoadingInfoComponent.vue"
import { useStatistik } from "@/composable/useStatistik"
import { onMounted } from "vue"
import { showToast } from "@/utils/ui/toast"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"

const { statistik, fetchStatistik, error, loadingStatistik } = useStatistik()
onMounted(() => {
	fetchStatistik()
	if (error.value) {
		showToast({
			message: error?.value ?? "An unknown error occurred",
			type: "error",
		})
	}
})
</script>

<template>
	<BreadcrumbDefault pageTitle="Dashboard" />
	<LoadingInfoComponent v-if="loadingStatistik" />
	<div v-else class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
		<StatsCardComponent icon="document-check" label="Pendaftar" :value="statistik?.pendaftar" color="blue" />
		<StatsCardComponent icon="document-check" label="Pending" :value="statistik?.pending" color="orange" />
		<StatsCardComponent icon="document-check" label="Diverifikasi" :value="statistik?.diverifikasi" color="green" />
		<StatsCardComponent icon="document-check" label="Ditolak" :value="statistik?.ditolak" color="red" />
		<StatsCardComponent icon="document-check" label="Lulus" :value="statistik?.lulus" color="blue" />
		<StatsCardComponent icon="document-check" label="Tidak Lulus" :value="statistik?.tidak_lulus" color="red" />
		<div v-for="(value, jalur) in statistik?.jumlah_per_jalur" :key="jalur">
			<StatsCardComponent icon="document-check" :label="`${jalur}`" :value="value as unknown as number" color="blue" />
		</div>
	</div>
</template>
