<script setup lang="ts">
import HomeLayout from "@/layouts/HomeLayout.vue"
import StatsCardComponent from "@/components/UI/StatsCardComponent.vue"
import LoadingInfoComponent from "@/components/UI/LoadingInfoComponent.vue"
import { useStatistik } from "@/composable/useStatistik"
import { onMounted } from "vue"
import { showToast } from "@/utils/ui/toast"

const { statistik, fetchPublicStatistik, error, loadingStatistik } = useStatistik()
onMounted(() => {
	fetchPublicStatistik()
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
	<HomeLayout>
		<LoadingInfoComponent v-if="loadingStatistik" />
		<div v-else class="flex flex-col items-center w-full mt-4 space-y-4 md:flex-row md:justify-center md:space-x-4 md:space-y-0">
			<StatsCardComponent icon="document-check" label="Sekolah" :value="statistik?.sekolah" color="blue" />
			<StatsCardComponent icon="document-check" label="SD" :value="statistik?.sd" color="orange" />
			<StatsCardComponent icon="document-check" label="SMP" :value="statistik?.smp" color="orange" />
			<StatsCardComponent icon="calendar" :label="statistik?.periode as string" :value="statistik?.tahun_ajaran" color="orange" />
		</div>
	</HomeLayout>
</template>
