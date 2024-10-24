<script setup lang="ts">
import StatsCardComponent from "@/components/UI/StatsCardComponent.vue"
import LoadingInfoComponent from "@/components/UI/LoadingInfoComponent.vue"
import { useStatistik } from "@/composable/useStatistik"
import { onMounted } from "vue"
import { showToast } from "@/utils/ui/toast"

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
	<LoadingInfoComponent v-if="loadingStatistik" />
	<div v-else class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
		<StatsCardComponent icon="document-check" label="Pendaftar" :value="statistik?.pendaftar" color="blue" />
		<StatsCardComponent icon="document-check" label="Pending" :value="statistik?.pending" color="orange" />
		<StatsCardComponent icon="document-check" label="Diverifikasi" :value="statistik?.diverifikasi" color="green" />
		<StatsCardComponent icon="document-check" label="Ditolak" :value="statistik?.ditolak" color="red" />
		<StatsCardComponent icon="document-check" label="Lulus" :value="statistik?.lulus" color="blue" />
		<StatsCardComponent icon="document-check" label="Tidak Lulus" :value="statistik?.tidak_lulus" color="blue" />
	</div>
</template>
