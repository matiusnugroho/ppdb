<script setup lang="ts">
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
	<div class="min-h-screen bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-7xl mx-auto">
			<!-- Hero Header -->
			<div class="text-center mb-16 space-y-4">
				<h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl tracking-tight">
					Statistik <span class="text-indigo-600 bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">PPDB</span>
				</h1>
				<p class="max-w-2xl mx-auto text-lg text-gray-600">
					Pantau perkembangan data pendaftaran peserta didik baru di Kabupaten Kuantan Singingi secara <span class="font-semibold text-indigo-600">real-time</span>.
				</p>
			</div>

			<!-- Dynamic Content -->
			<Transition name="fade" mode="out-in">
				<LoadingInfoComponent v-if="loadingStatistik" />
				
				<div v-else class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
					<div class="transform transition-all duration-500 hover:-translate-y-2">
						<StatsCardComponent 
							icon="building-office-2" 
							label="Total Sekolah" 
							:value="statistik?.sekolah + ''" 
							color="indigo"
							class="h-full border-l-4 border-indigo-500" 
						/>
					</div>
					
					<div class="transform transition-all duration-500 hover:-translate-y-2 delay-100">
						<StatsCardComponent 
							icon="user-group" 
							label="Jenjang SD" 
							:value="statistik?.sd + ''" 
							color="blue"
							class="h-full border-l-4 border-blue-500"
						/>
					</div>

					<div class="transform transition-all duration-500 hover:-translate-y-2 delay-200">
						<StatsCardComponent 
							icon="toga" 
							label="Jenjang SMP" 
							:value="statistik?.smp + ''" 
							color="orange"
							class="h-full border-l-4 border-orange-500"
						/>
					</div>

					<div class="transform transition-all duration-500 hover:-translate-y-2 delay-300">
						<StatsCardComponent 
							icon="calendar" 
							:label="statistik?.periode ? (statistik.periode as string) : 'Tahun Ajaran'" 
							:value="statistik?.tahun_ajaran + ''" 
							color="emerald"
							class="h-full border-l-4 border-emerald-500"
						/>
					</div>
				</div>
			</Transition>

            <!-- Footer decoration or additional info could go here -->
		</div>
	</div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
