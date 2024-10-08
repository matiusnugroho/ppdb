<template>
	<div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
		<h2 class="mb-6 text-xl font-semibold text-black dark:text-white">Daftar Siswa Pendaftar</h2>
		<div class="overflow-x-auto">
			<table class="table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Registration Number</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<!-- Skeleton Rows (show while loading) -->
					<template v-if="loadingPendaftar">
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
							<td>
								<button class="btn btn-ghost btn-xs">details</button>
							</td>
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
										<div>{{ pendaftar?.student?.nama }}</div>
										<div>{{ pendaftar?.student?.nisn }}</div>
									</div>
								</div>
							</td>
							<td>
								{{ pendaftar.registration_number }}
							</td>
							<td>
								<button class="btn btn-ghost btn-xs">details</button>
							</td>
						</tr>
					</template>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script setup lang="ts">
import { usePendaftaran } from "@/composable/usePendaftaran"
import { onMounted } from "vue"

const { loadingPendaftar, dataPendaftar, fetchPendaftar } = usePendaftaran()

onMounted(() => {
	fetchPendaftar()
})
</script>
