<script setup lang="ts">
import StatsCardComponent from "@/components/UI/StatsCardComponent.vue"
import LoadingInfoComponent from "@/components/UI/LoadingInfoComponent.vue"
import { useStatistik } from "@/composable/useStatistik"
import { onMounted } from "vue"
import { showToast } from "@/utils/ui/toast"
import BreadcrumbDefault from "../Breadcrumbs/BreadcrumbDefault.vue"
import TabelSekolahWithDataComponent from "./TabelSekolahWithDataComponent.vue"

const { statistik, fetchStatistik, error, loadingStatistik } = useStatistik()
onMounted(() => {
	fetchStatistik()
	if (error.value) {
		console.error(error)
		showToast({
			message: error?.toString() ?? "An unknown error occurred",
			type: "error",
		})
	}
})
</script>

<template>
	<BreadcrumbDefault pageTitle="Dashboard" />
	<LoadingInfoComponent v-if="loadingStatistik" />
	<div v-else class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
		<StatsCardComponent icon="document-check" label="Sekolah" :value="statistik?.sekolah" color="blue" />
		<StatsCardComponent icon="document-check" label="SD" :value="statistik?.sd" color="orange" />
		<StatsCardComponent icon="document-check" label="SMP" :value="statistik?.smp" color="orange" />
		<StatsCardComponent icon="calendar" :label="statistik?.periode as string" :value="statistik?.tahun_ajaran" color="orange" />
	</div>
	<div class="row mt-4">
		<TabelSekolahWithDataComponent />
	</div>
</template>
