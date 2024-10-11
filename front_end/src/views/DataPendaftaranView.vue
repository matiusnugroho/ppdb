<script setup lang="ts">
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import { useRoute } from "vue-router"
import { onMounted } from "vue"
import { usePendaftaran } from "@/composable/usePendaftaran"

const router = useRoute()
const param = router.params.id as string
const { getDetailVerifikasi, dataDetailVerifikasi } = usePendaftaran()
onMounted(async () => {
	await getDetailVerifikasi(param)
})
</script>

<template>
	<DefaultLayout>
		<BreadcrumbDefault :pageTitle="'Data Pendaftaran'" />
		{{ dataDetailVerifikasi }}
    <div class="container mx-auto p-4">
			<div class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-4">
				<!-- Header for the section -->
				<h2 class="text-xl font-semibold mb-4">Registration & Student Info</h2>

				<!-- Registration Info -->
				<div class="mb-4">
					<p><strong>Registration Number:</strong> {{ dataDetailVerifikasi?.registration_number}}</p>
					<p><strong>Status:</strong> {{ dataDetailVerifikasi?.status }}</p>
					<p><strong>Verified By:</strong> {{ dataDetailVerifikasi?.verified_by }}</p>
				</div>

				<!-- Student Info -->
				<h2 class="text-xl font-semibold mb-4">Student Info</h2>
				<div>
					<p><strong>Name:</strong> {{ dataDetailVerifikasi?.student.nama }}</p>
					<p><strong>NISN:</strong> {{ dataDetailVerifikasi?.student.nisn }}</p>
					<p><strong>Birth Place:</strong> {{ dataDetailVerifikasi?.student.tempat_lahir }}</p>
					<p><strong>Birth Date:</strong> {{ dataDetailVerifikasi?.student.tanggal_lahir }}</p>
					<p><strong>Father's Name:</strong> {{ dataDetailVerifikasi?.student.nama_bapak }}</p>
					<p><strong>Mother's Name:</strong> {{ dataDetailVerifikasi?.student.nama_ibu }}</p>
					<p><strong>Parent's Phone:</strong> {{ dataDetailVerifikasi?.student.no_hp_ortu }}</p>
					<img class="mt-4 rounded-md" :src="dataDetailVerifikasi?.student.foto_url" alt="Student Photo" />
				</div>
			</div>

			<!-- Document Section -->
			<div class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-4 mt-6">
				<h2 class="text-xl font-semibold mb-4">Documents</h2>

				<div class="space-y-4">
					<!-- Document Cards -->
					<div v-for="document in dataDetailVerifikasi?.documents" :key="document.id" class="border border-gray-200 p-4 rounded-md shadow-md dark:bg-boxdark dark:border-strokedark">
						<h3 class="font-semibold mb-2">{{ document.document_type_id }}</h3>
						<p><strong>Status:</strong> {{ document.status }}</p>
						<a :href="document.url_path!" class="text-blue-500" target="_blank">Download</a>
					</div>
				</div>
			</div>
		</div>
	</DefaultLayout>
</template>
