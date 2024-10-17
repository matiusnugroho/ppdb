<script setup lang="ts">
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import { useRoute } from "vue-router"
import { onMounted, ref } from "vue"
import { usePendaftaran } from "@/composable/usePendaftaran"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import ConfirmationComponent from "@/components/UI/ConfirmationComponent.vue"
import { getDataById } from "@/helpers/getDataById"
import { showToast } from "@/utils/ui/toast"
import statusColorMap from "@/config/statusColorMap"

const router = useRoute()
const id_registrasi = router.params.id as string
const { getDetailVerifikasi, dataDetailVerifikasi, loadingVerifikasi, verifikasiDokumen } = usePendaftaran()
const verifikasiModal = ref<null | HTMLDialogElement>(null)
const id_dokumen = ref<string>("")

const verifikasi = (id: string) => {
	id_dokumen.value = ""
	id_dokumen.value = id
	verifikasiModal.value?.show()
}
const verifikasiConfirm = async () => {
	const response = await verifikasiDokumen(id_dokumen.value)
	if (response.success) {
		verifikasiModal.value?.close()
		let data = getDataById(dataDetailVerifikasi.value!.documents, id_dokumen.value)
		console.log({ data })
		if (data) {
			// Check if data is not null
			data.status = response.data.status
		}
		showToast({
			type: "success",
			message: "Verifikasi pendaftaran berhasil",
		})
	} else {
		showToast({
			type: "error",
			message: "Verifikasi document gagal, " + response.message,
		})
	}
}
const verifikasiCancel = () => {
	id_dokumen.value = ""
	verifikasiModal.value?.close()
}
onMounted(async () => {
	await getDetailVerifikasi(id_registrasi)
})
</script>

<template>
	<DefaultLayout>
		<BreadcrumbDefault :pageTitle="'Data Pendaftaran'" />
		<div class="container mx-auto">
			<!-- Flex container for side-by-side layout -->
			<div class="flex flex-wrap -mx-4">
				<!-- Registration and Student Info -->
				<div class="w-full md:w-1/2 px-4 mb-6 md:mb-0">
					<div class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-4">
						<!-- Header for the section -->
						<h2 class="text-xl font-semibold mb-4">Registration & Student Info</h2>

						<!-- Content Layout -->
						<div class="flex flex-col md:flex-row items-start">
							<!-- Student Photo -->
							<div class="mb-4 md:mb-0 md:mr-6">
								<!-- Added margin-bottom for small devices -->
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

				<div class="w-full md:w-1/2 px-2">
					<!-- Reduced padding on the parent container -->
					<div class="overflow-hidden rounded-sm p-2 border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
						<!-- Reduced padding -->
						<h2 class="text-xl font-semibold mb-2">Documents</h2>
						<!-- Reduced margin-bottom -->
						<div class="space-y-1">
							<!-- Reduced spacing between items -->
							<!-- Document Cards -->
							<div v-for="document in dataDetailVerifikasi?.documents" :key="document.id" class="bg-white shadow-lg rounded-lg overflow-hidden w-full p-2">
								<!-- Added padding for inner card -->
								<div class="flex items-center">
									<!-- Icon -->
									<div class="flex-shrink-0">
										<HeroIcon name="document" size="32" class="text-blue-500" />
									</div>
									<!-- File Name and Status -->
									<div class="ml-2 flex-1">
										<!-- Reduced left margin -->
										<h2 class="text-lg font-semibold text-gray-900">{{ document.document_type.label }}</h2>
										<span class="mt-1 inline-block px-2 py-1 text-sm font-medium rounded-full" :class="statusColorMap[document.status]">
											<!-- Reduced padding -->
											{{ document.status }}
										</span>
									</div>
								</div>
								<!-- Footer with Buttons -->
								<div class="px-2 flex md:justify-end xsm:justify-center xsm:my-4 items-center">
									<!-- Reduced padding -->
									<div class="tooltip" :data-tip="document.url_path ? 'Lihat' : 'Tidak ada file'">
										<a
											:href="document.url_path!"
											class="flex items-center justify-center px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-200 rounded hover:bg-blue-300 hover:text-blue-700 mr-2"
											v-if="document.url_path"
											target="_blank"
											rel="noopener noreferrer">
											<HeroIcon name="view-finder" size="18" class="h-5 w-5" />
											<span class="ml-2">Lihat</span>
										</a>
										<span v-else class="flex items-center cursor-not-allowed text-gray-400 bg-gray-100 px-3 py-1 text-sm font-semibold rounded mr-2">
											<HeroIcon name="view-finder" size="18" class="h-5 w-5" />
											<span class="ml-2">Lihat</span>
										</span>
									</div>
									<button
										:disabled="!document.url_path || document.status === 'diverifikasi'"
										class="px-3 py-1 text-sm font-semibold rounded flex items-center mr-2"
										@click="verifikasi(document.id)"
										:class="
											document.url_path && document.status !== 'diverifikasi' ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-400 cursor-not-allowed'
										">
										<HeroIcon name="circle-check" size="18" class="h-5 w-5" />
										<span class="ml-2">Verifikasi</span>
									</button>
									<button
										:disabled="!document.url_path"
										class="px-3 py-1 text-sm font-semibold rounded hover:bg-red-200 flex items-center"
										@click="verifikasi(document.id)"
										:class="{
											'bg-red-100 text-red-700': document.url_path,
											'bg-gray-100 text-red-500 cursor-not-allowed': !document.url_path,
										}">
										<HeroIcon name="close" size="18" class="h-5 w-5" />
										<span class="ml-2">Tolak</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<ConfirmationComponent
			ref="verifikasiModal"
			title="Verifikasi pendaftaran"
			message="Apakah anda yakin ingin verifikasi dokumen ini?"
			confirmLabel="Ya"
			cancelLabel="Batal"
			:loading="loadingVerifikasi"
			:confirmHandler="verifikasiConfirm"
			:cancelHandler="verifikasiCancel" />
	</DefaultLayout>
</template>
