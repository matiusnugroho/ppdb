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
import ModalComponent from "@/components/UI/ModalComponent.vue"
import TextAreaGroup from "@/components/Forms/TextAreaGroup.vue"
import { hasError } from "@/helpers/hasError"
import nopp from "@/assets/images/nopp.png"

const router = useRoute()
const id_registrasi = router.params.id as string
const { getDetailVerifikasi, dataDetailVerifikasi, loadingVerifikasi, verifikasiDokumen, rejectDokumen } = usePendaftaran()
const verifikasiModal = ref<null | HTMLDialogElement>(null)
const rejectModal = ref<null | HTMLDialogElement>(null)
const id_dokumen = ref<string>("")
const rejectMessage = ref<string>("")
const verifikasi = (id: string) => {
	id_dokumen.value = ""
	id_dokumen.value = id
	if (verifikasiModal.value) {
		verifikasiModal.value?.show()
	} else {
		console.error("verifikasiModal is not defined")
	}
}
const reject = (id: string) => {
	id_dokumen.value = ""
	rejectMessage.value = ""
	id_dokumen.value = id
	console.log("reject")
	rejectModal.value?.show()
}
const verifikasiConfirm = async () => {
	const response = await verifikasiDokumen(id_dokumen.value)
	if (response.success) {
		verifikasiModal.value?.close()
		let data = getDataById(dataDetailVerifikasi.value!.documents, id_dokumen.value)
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
const rejectConfirm = async () => {
	const alasan = rejectMessage.value
	const response = await rejectDokumen(id_dokumen.value, alasan)
	if (response.success) {
		verifikasiModal.value?.close()
		let data = getDataById(dataDetailVerifikasi.value!.documents, id_dokumen.value)
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
const rejectCancel = () => {}
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
					<div class="overflow-hidden rounded-xl border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark pt-10">
						<!-- Profile Section -->
						<div class="flex flex-col items-center relative px-4">
							<div class="relative">
								<img
									class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-md bg-white hover:scale-105 transition-transform duration-300"
									:src="dataDetailVerifikasi?.student.thumbnail_url || nopp"
									alt="Student Photo" />
								<!-- Verified Checkmark Icon -->
								<div class="absolute bottom-1 right-2 bg-white rounded-full p-1 shadow-sm" v-if="dataDetailVerifikasi?.status === 'Terverifikasi'">
									<HeroIcon name="check-circle" size="20" class="text-green-500" />
								</div>
							</div>

							<!-- Status Pill -->
							<div
								class="mt-4 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide border flex items-center gap-1"
								:class="{
									'bg-green-100 text-green-600 border-green-200': dataDetailVerifikasi?.status === 'Terverifikasi',
									'bg-yellow-100 text-yellow-600 border-yellow-200': dataDetailVerifikasi?.status === 'Proses Verifikasi',
									'bg-red-100 text-red-600 border-red-200': dataDetailVerifikasi?.status === 'Ditolak',
									'bg-gray-100 text-gray-600 border-gray-200': !dataDetailVerifikasi?.status,
								}">
								<HeroIcon
									name="check-circle"
									size="16"
									v-if="dataDetailVerifikasi?.status === 'Terverifikasi'" />
								{{ dataDetailVerifikasi?.status || "Belum Ada Status" }}
							</div>

							<!-- Name and NISN -->
							<h2 class="mt-4 text-xl font-bold text-gray-800 dark:text-white">{{ dataDetailVerifikasi?.student.nama }}</h2>
							<p class="text-gray-500 text-sm font-medium mt-1">NISN: {{ dataDetailVerifikasi?.student.nisn }}</p>
						</div>

						<!-- Info Sections -->
						<div class="p-6">
							<hr class="border-gray-100 my-4" />

							<!-- Info Pendaftaran -->
							<h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Info Pendaftaran</h3>
							<div class="space-y-5">
								<!-- Nomor Pendaftaran -->
								<div class="flex items-start">
									<div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center mr-4 flex-shrink-0">
										<span class="text-gray-400 font-bold text-lg">#</span>
									</div>
									<div>
										<p class="text-xs text-gray-400 font-bold uppercase">Nomor Pendaftaran</p>
										<p class="font-bold text-gray-700 dark:text-gray-300">{{ dataDetailVerifikasi?.registration_number }}</p>
									</div>
								</div>

								<!-- Diverifikasi Oleh -->
								<div class="flex items-start">
									<div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center mr-4 flex-shrink-0">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
										</svg>
									</div>
									<div>
										<p class="text-xs text-gray-400 font-bold uppercase">Diverifikasi Oleh</p>
										<p class="font-bold text-gray-700 dark:text-gray-300">{{ dataDetailVerifikasi?.verified_by?.username || "-" }}</p>
									</div>
								</div>
							</div>

							<!-- Biodata Siswa -->
							<h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-8 mb-4">Biodata Siswa</h3>
							<div class="space-y-5">
								<!-- Tempat Lahir -->
								<div class="flex items-start">
									<div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center mr-4 flex-shrink-0">
										<HeroIcon name="map-pin" size="20" class="text-gray-400" />
									</div>
									<div>
										<p class="text-xs text-gray-400 font-bold uppercase">Tempat Lahir</p>
										<p class="font-bold text-gray-700 dark:text-gray-300">{{ dataDetailVerifikasi?.student.tempat_lahir }}</p>
									</div>
								</div>

								<!-- Tanggal Lahir -->
								<div class="flex items-start">
									<div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center mr-4 flex-shrink-0">
										<HeroIcon name="calendar" size="20" class="text-gray-400" />
									</div>
									<div>
										<p class="text-xs text-gray-400 font-bold uppercase">Tanggal Lahir</p>
										<p class="font-bold text-gray-700 dark:text-gray-300">{{ dataDetailVerifikasi?.student.tanggal_lahir }}</p>
									</div>
								</div>

								<!-- Nama Ayah -->
								<div class="flex items-start">
									<div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center mr-4 flex-shrink-0">
										<HeroIcon name="user-circle" size="20" class="text-gray-400" />
									</div>
									<div>
										<p class="text-xs text-gray-400 font-bold uppercase">Nama Ayah</p>
										<p class="font-bold text-gray-700 dark:text-gray-300">{{ dataDetailVerifikasi?.student.nama_bapak }}</p>
									</div>
								</div>

								<!-- Nama Ibu -->
								<div class="flex items-start">
									<div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center mr-4 flex-shrink-0">
										<HeroIcon name="user-circle" size="20" class="text-gray-400" />
									</div>
									<div>
										<p class="text-xs text-gray-400 font-bold uppercase">Nama Ibu</p>
										<p class="font-bold text-gray-700 dark:text-gray-300">{{ dataDetailVerifikasi?.student.nama_ibu }}</p>
									</div>
								</div>

								<!-- No Handphone -->
								<div class="flex items-start">
									<div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center mr-4 flex-shrink-0">
										<HeroIcon name="phone" size="20" class="text-gray-400" />
									</div>
									<div>
										<p class="text-xs text-gray-400 font-bold uppercase">No. Handphone</p>
										<p class="font-bold text-gray-700 dark:text-gray-300">{{ dataDetailVerifikasi?.student.no_hp_ortu }}</p>
									</div>
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
							<div v-for="document in dataDetailVerifikasi?.documents" :key="document.id" class="bg-white shadow-sm rounded-xl border border-gray-100 w-full p-4 flex flex-col md:flex-row items-center justify-between gap-4 transition hover:shadow-md">
								<!-- Left Side: Icon & Info -->
								<div class="flex items-center w-full md:w-auto">
									<!-- Icon -->
									<div class="flex-shrink-0 bg-blue-50 rounded-lg p-2 mr-4">
										<HeroIcon name="document-text" size="24" class="text-blue-600" />
									</div>
									<!-- File Name and Status -->
									<div class="flex-1">
										<h2 class="text-sm font-bold text-gray-800">{{ document.path_requirement?.document_type?.label }}</h2>
										<div class="mt-1">
											<span class="inline-block px-2 py-1 text-sm font-medium rounded-full" :class="statusColorMap[document.status]">
												{{ document.status }}
											</span>
										</div>
									</div>
								</div>

								<!-- Right Side: Buttons -->
								<div class="flex items-center gap-2 w-full md:w-auto justify-end">
									<!-- View Button -->
									<div class="tooltip" :data-tip="document.url_path ? 'Lihat' : 'Tidak ada file'">
										<a
											:href="document.url_path!"
											class="flex items-center justify-center w-9 h-9 rounded-lg transition-colors"
											:class="document.url_path ? 'bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700' : 'bg-gray-100 text-gray-400 cursor-not-allowed'"
											v-if="document.url_path"
											target="_blank"
											rel="noopener noreferrer">
											<HeroIcon name="eye" size="18" />
										</a>
										<span v-else class="flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
											<HeroIcon name="eye" size="18" />
										</span>
									</div>

									<!-- Verify Button -->
									<button
										:disabled="!document.url_path || document.status === 'diverifikasi'"
										class="flex items-center justify-center w-9 h-9 rounded-lg transition-colors"
										@click="verifikasi(document.id)"
										:class="
											document.url_path && document.status !== 'diverifikasi'
												? 'bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700'
												: 'bg-gray-100 text-gray-400 cursor-not-allowed'
										">
										<HeroIcon name="check" size="18" />
									</button>

									<!-- Reject Button -->
									<button
										:disabled="!document.url_path"
										class="flex items-center justify-center w-9 h-9 rounded-lg transition-colors"
										@click="reject(document.id)"
										:class="{
											'bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700': document.url_path,
											'bg-gray-100 text-gray-400 cursor-not-allowed': !document.url_path,
										}">
										<HeroIcon name="x-mark" size="18" />
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</DefaultLayout>
	<ConfirmationComponent
		ref="verifikasiModal"
		title="Verifikasi dokumen"
		message="Apakah anda yakin ingin verifikasi dokumen ini?"
		confirmLabel="Ya"
		:close-on-click-outside="true"
		cancelLabel="Batal"
		:loading="loadingVerifikasi"
		:confirmHandler="verifikasiConfirm"
		:cancelHandler="verifikasiCancel" />
	<ModalComponent
		ref="rejectModal"
		title="Tolak dokumen"
		message="Apakah anda yakin ingin menolak dokumen ini?"
		confirmLabel="Reject"
		:close-on-click-outside="true"
		cancelLabel="Batal"
		:loading="loadingVerifikasi"
		:confirmHandler="rejectConfirm"
		:cancelHandler="rejectCancel">
		<TextAreaGroup v-model="rejectMessage" :error="hasError('rejectMessage')" name="rejectMessage" label="Alasan ditolak" /> </ModalComponent
	>>
</template>
