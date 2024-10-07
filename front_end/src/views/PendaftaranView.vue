<script setup lang="ts">
import { onMounted, ref } from "vue"
import type { Component } from "vue"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { useCekPendaftaran } from "@/composable/useCekPendaftaran"
import BelumDaftar from "@/components/Pendaftaran/BelumDaftar.vue"
import SudahDaftar from "@/components/Pendaftaran/SudahDaftar.vue"

const pageTitle = ref("Pendaftaran")
const formValidationErrors = useFormValidationErrorsStore()
const { fetchRegistration, loadingRegistration, registrationData } = useCekPendaftaran()

const currentComponent = ref<Component | null>(null)

onMounted(async () => {
	formValidationErrors.clearErrors()
	await fetchRegistration()
	currentComponent.value = registrationData.value !== null ? SudahDaftar : BelumDaftar
})
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
				<component :is="currentComponent" />
			</div>
		</div>
	</DefaultLayout>
</template>
