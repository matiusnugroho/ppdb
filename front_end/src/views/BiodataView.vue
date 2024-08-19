<script setup lang="ts">
import { onMounted, ref } from "vue"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import FormBiodata from "@/components/FormBiodata.vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"

const pageTitle = ref("Biodata")
const formValidationErrors = useFormValidationErrorsStore()
onMounted(() => {
	formValidationErrors.clearErrors()
})
</script>

<template>
	<DefaultLayout>
		<div class="mx-auto max-w-270">
			<!-- Breadcrumb Start -->
			<BreadcrumbDefault :pageTitle="pageTitle" />
			<!-- Breadcrumb End -->
			<FormBiodata />
		</div>
	</DefaultLayout>
</template>
