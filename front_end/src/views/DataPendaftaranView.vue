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
		<div class="container mx-auto p-4">
			<!-- Flex container for side-by-side layout -->
			<div class="flex flex-wrap -mx-4">
				<!-- Registration and Student Info -->
				<div class="w-full md:w-1/2 px-4 mb-6 md:mb-0">
					<div class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-4">
						<!-- Header for the section -->
						<h2 class="text-xl font-semibold mb-4">Registration & Student Info</h2>

						<!-- Content Layout -->
						<div class="flex items-start">
							<!-- Student Photo -->
							<div class="mr-6">
								<img class="w-32 h-32 rounded-md object-cover" :src="dataDetailVerifikasi?.student.foto_url" alt="Student Photo" />
							</div>
							<!-- Registration and Student Info -->
							<div class="flex-1">
								<!-- Registration Info -->
								<div class="mb-4">
									<p class="flex">
										<strong class="w-40">Registration Number</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.registration_number }}</span>
									</p>
									<p class="flex">
										<strong class="w-40">Status</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.status }}</span>
									</p>
									<p class="flex">
										<strong class="w-40">Verified By</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.verified_by?.username }}</span>
									</p>
								</div>

								<!-- Student Info -->
								<h2 class="text-xl font-semibold mb-4">Student Info</h2>
								<div>
									<p class="flex">
										<strong class="w-40">Name</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.student.nama }}</span>
									</p>
									<p class="flex">
										<strong class="w-40">NISN</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.student.nisn }}</span>
									</p>
									<p class="flex">
										<strong class="w-40">Birth Place</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.student.tempat_lahir }}</span>
									</p>
									<p class="flex">
										<strong class="w-40">Birth Date</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.student.tanggal_lahir }}</span>
									</p>
									<p class="flex">
										<strong class="w-40">Father's Name</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.student.nama_bapak }}</span>
									</p>
									<p class="flex">
										<strong class="w-40">Mother's Name</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.student.nama_ibu }}</span>
									</p>
									<p class="flex">
										<strong class="w-40">Parent's Phone</strong><span class="mx-2">:</span><span>{{ dataDetailVerifikasi?.student.no_hp_ortu }}</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Document Section -->
				<div class="w-full md:w-1/2 px-4">
					<div class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-4">
						<h2 class="text-xl font-semibold mb-4">Documents</h2>

						<div class="space-y-2">
							<!-- Document Cards -->
							<div v-for="document in dataDetailVerifikasi?.documents" :key="document.id" class="max-w-sm bg-white shadow-lg rounded-lg overflow-hidden">
								<div class="flex items-center p-4">
									<!-- Icon -->
									<div class="flex-shrink-0">
										<svg class="w-12 h-12 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
											<path d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm0 2h12v12H4V4zm2 3h8v2H6V7zm0 4h5v2H6v-2z"></path>
										</svg>
									</div>
									<!-- File Name -->
									<div class="ml-4">
										<h2 class="text-lg font-semibold text-gray-900">{{ document.document_type.label }}</h2>
									</div>
								</div>
								<!-- Footer -->
								<div class="px-4 py-3 bg-gray-50 flex justify-between items-center">
									<span class="inline-block px-3 py-1 text-sm font-medium text-yellow-700 bg-yellow-100 rounded-full">
										{{ document.status }}
									</span>
									<div>
										<button class="text-blue-500 hover:underline mr-2">View</button>
										<button class="text-green-500 hover:underline">Verify</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</DefaultLayout>
</template>
