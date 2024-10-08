<script setup lang="ts">
import { onMounted, ref } from "vue"
import type { Component } from "vue"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { useCekPendaftaran } from "@/composable/useCekPendaftaran"
import BelumDaftar from "@/components/Pendaftaran/BelumDaftar.vue"
import SudahDaftar from "@/components/Pendaftaran/SudahDaftar.vue"
import BelumBukaPendaftaran from "@/components/Pendaftaran/BelumBukaPendaftaran.vue"
import { useAuthStore } from "@/stores/auth"
import SekolahDaftar from "@/components/Pendaftaran/SekolahDaftar.vue"

const pageTitle = ref("Pendaftaran")
const formValidationErrors = useFormValidationErrorsStore()
const { fetchRegistration, loadingRegistration, registrationData } = useCekPendaftaran()
const authstore = useAuthStore()

const currentComponent = ref<Component | null>(null)
	const componentKey = ref(0)

onMounted(async () => {
	formValidationErrors.clearErrors()

	const role = authstore.role
	if (role === "siswa") {
		try {
			const cekPendaftaran = await fetchRegistration()
			console.log({cekPendaftaran})
			if(cekPendaftaran.success) {
				currentComponent.value = registrationData.value !== null ? SudahDaftar : BelumDaftar
			}
			else{
				currentComponent.value = BelumBukaPendaftaran
			}
			
		} catch (e) {
			console.log(e)
		}
	} else if (role === "sekolah" || role === "verifikator_sekolah") {
		currentComponent.value = SekolahDaftar
	}
})
function refreshComponent() {
	componentKey.value++
}
</script>

<template>
	<DefaultLayout>
		<div class="mx-auto">
			<!-- Breadcrumb Start -->
			<BreadcrumbDefault :pageTitle="pageTitle" />

			<!-- Loading Spinner -->
			<div v-if="loadingRegistration">
				<p>Loading...</p>
				<!-- You can replace this with a loading spinner component -->
				<svg class="animate-spin h-5 w-5 text-blue-500" viewBox="0 0 24 24">
					<circle class="opacity-25" cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="4"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0116 0 8 8 0 11-16 0z"></path>
				</svg>
			</div>

			<div v-else>
				<component :is="currentComponent" :registration="registrationData" :key="componentKey" @refreshParent="refreshComponent" />
			</div>
		</div>
	</DefaultLayout>
</template>
