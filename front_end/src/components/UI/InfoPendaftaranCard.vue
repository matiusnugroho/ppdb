<script setup lang="ts">
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import { useCekPendaftaran } from "@/composable/useCekPendaftaran"
import { onMounted } from "vue"
import SpinnerLoading from "./SpinnerLoading.vue"
const { fetchRegistration, loadingRegistration, registrationData } = useCekPendaftaran()
onMounted(() => {
	fetchRegistration()
})
</script>

<template>
	<article class="rounded-2xl border border-gray-100 bg-white p-6 h-32 shadow-md transition hover:shadow-lg">
		<div class="flex items-center justify-between">
			<SpinnerLoading v-if="loadingRegistration" size="lg" :loading="true" />
			<div v-else>
				<div v-if="!registrationData">
					<p class="text-2xl text-gray-500">Belum melakukan pendaftaran</p>
				</div>
				<div v-else class="mr-2">
					<p class="text-sm text-gray-500">{{ registrationData?.registration_number }}</p>

					<p class="text-2xl font-medium text-gray-900">{{ registrationData?.school?.nama_sekolah }}</p>
				</div>
			</div>

			<span class="rounded-full bg-blue-100 p-3 text-blue-600">
				<HeroIcon name="document-check" size="32" class="h-6 w-6" />
			</span>
		</div>
	</article>
</template>
