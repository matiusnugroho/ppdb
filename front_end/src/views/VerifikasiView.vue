<script setup lang="ts">
import { onMounted, ref } from "vue"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { usePendaftaran } from "@/composable/usePendaftaran"
import HeroIcon from "@/components/Icon/HeroIcon.vue"

const pageTitle = ref("Verifikasi")
const { dataPendaftar, loadingVerifikasi, totalPendaftar, getVerifiedByMe } = usePendaftaran()
const verifikasi = (id: string) => {
	console.log(`Verifikasi ID : ${id}`)
}

onMounted(() => {
	getVerifiedByMe()
})
</script>

<template>
	<DefaultLayout>
		<div class="mx-auto">
			<BreadcrumbDefault :pageTitle="pageTitle" />
			<div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
				<div class="flex justify-between items-center mb-6">
					<h2 class="text-xl font-semibold text-black dark:text-white">Daftar Siswa Pendaftar</h2>
					<p v-if="totalPendaftar" class="text-black dark:text-white">Total {{ totalPendaftar }} Calon Siswa</p>
				</div>
				<div class="overflow-x-auto">
					<table class="table">
						<thead>
							<tr>
								<th class="text-left">Name</th>
								<th class="text-center">NISN</th>
								<th class="text-center">Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<!-- Skeleton Rows (show while loading) -->
							<template v-if="loadingVerifikasi">
								<tr v-for="n in 2" :key="n">
									<td>
										<div class="flex items-center gap-3">
											<div class="avatar">
												<div class="skeleton rounded-full h-12 w-12"></div>
											</div>
											<div>
												<div class="skeleton h-4 w-24 rounded"></div>
												<div class="skeleton h-4 w-24 rounded mt-2"></div>
											</div>
										</div>
									</td>
									<td>
										<span class="skeleton h-4 w-36 rounded block"></span>
									</td>
									<td class="text-center">
										<button class="btn btn-ghost btn-xs">Status</button>
									</td>
									<td></td>
								</tr>
							</template>

							<!-- Actual Data Rows (show when data is ready) -->
							<template v-else>
								<tr v-for="(pendaftar, index) in dataPendaftar" :key="index">
									<td>
										<div class="flex items-center gap-3">
											<div class="avatar">
												<div class="mask mask-squircle h-12 w-12">
													<img :src="pendaftar?.student?.thumbnail_url" :alt="`Foto ${pendaftar?.student?.nama}`" class="rounded-full h-12 w-12" />
												</div>
											</div>
											<div>
												<div class="text-black dark:text-white font-medium font-semibold">{{ pendaftar?.student?.nama }}</div>
												<div>{{ pendaftar.registration_number }}</div>
											</div>
										</div>
									</td>
									<td class="text-center">
										{{ pendaftar?.student?.nisn }}
									</td>
									<td class="flex flex-col items-center justify-center text-center align-middle py-5 px-4">
										<div>{{ pendaftar?.status }}</div>
										<div v-if="pendaftar?.status === 'diverifikasi'" class="badge badge-warning">
											{{ pendaftar.verified_by?.username }}
										</div>
									</td>
									<td class="py-5 px-4">
										<div class="flex items-center space-x-3.5">
											<div class="tooltip" data-tip="Lihat">
												<a
													:href="'/pendaftaran/verifikasi/' + pendaftar.id"
													class="flex items-center hover:text-primary"
													v-if="pendaftar.id"
													target="_blank"
													rel="noopener noreferrer">
													<HeroIcon name="view-finder" size="18" class="h-5 w-5" />
												</a>
												<span v-else class="flex items-center cursor-not-allowed text-gray-400">
													<HeroIcon name="view-finder" size="18" class="h-5 w-5" />
												</span>
											</div>
											<div class="tooltip" data-tip="Verifikasi">
												<button class="flex items-center hover:text-primary" @click="verifikasi(pendaftar.id)" :disabled="pendaftar?.status === 'diverifikasi'">
													<HeroIcon name="document-check" size="18" class="h-5 w-5" />
												</button>
											</div>
										</div>
									</td>
								</tr>
							</template>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</DefaultLayout>
</template>
