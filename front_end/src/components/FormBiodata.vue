<script setup lang="ts">
import { reactive, ref, onMounted } from "vue"

import { showToast } from "@/utils/ui/toast"
import { useAuthStore } from "@/stores/auth"
import { useUpdateProfile } from "@/composable/useUpdateProfile"
import type { ProfileSiswaRequest } from "@/types"
import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import flatPickr from "vue-flatpickr-component"
import { useSmoothScrollToTop } from "@/composable/useSmoothScrollToTop"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import { FwbSpinner } from "flowbite-vue"
import { field_error_html } from "@/helpers/fieldErrorHtml"
//import { formatDateToStandar } from "@/utils/formatDateToStandar"

const authstore = useAuthStore()
const { smoothScrollToTop } = useSmoothScrollToTop()
const formValidationErrors = useFormValidationErrorsStore()
let localState = reactive({
	user: authstore.user ? { ...authstore.user } : null,
	biodata: authstore.biodata ? { ...authstore.biodata } : null,
})
const imagePreview = ref<string>("")
const fileFoto = ref<File | null>(null)
const displayPreview = ref<boolean>(false)

const { uploadPhoto, loadingUpdatePhoto, uploadProgress, updateProfile, uploadError, loadingUpdateProfile } = useUpdateProfile()

const handleSubmit = async () => {
	formValidationErrors.clearErrors()
	const { foto, ...tanpaFoto } = localState.biodata!
	void foto
	const data = {
		...tanpaFoto,
		username: localState.user?.username,
		email: localState.user?.email,
	} as ProfileSiswaRequest

	loadingUpdateProfile.value = true
	const sukses = await updateProfile(data)
		.catch((error) => {
			showToast({
				message: "Profile update failed " + error.message,
				type: "error",
			})
		})
		.finally(() => {
			loadingUpdateProfile.value = false
		})
	if (sukses) {
		showToast({
			message: "Profile updated",
		})
	} else {
		showToast({
			message: "Profile update failed",
			type: "error",
		})
	}

	smoothScrollToTop("#sangkonten")
}

const resetForm = () => {
	localState.user = authstore.user ? { ...authstore.user } : null
	localState.biodata = authstore.biodata ? { ...authstore.biodata } : null
}

const handleCancel = () => {
	resetForm()
}

const handlePhotoSubmit = async () => {
	const result = await uploadPhoto(fileFoto.value!)
	if (result) {
		showToast({
			message: "Foto berhasil diperbarui",
		})
	} else {
		showToast({
			message: "Gagal update foto, " + uploadError.value,
			type: "error",
		})
	}
	displayPreview.value = false
	fileFoto.value = null
	smoothScrollToTop("#sangkonten")
}

const handleFileChange = (event: Event) => {
	const target = event.target as HTMLInputElement
	const file = target.files?.[0]

	if (file) {
		processFile(file)
	} else {
		imagePreview.value = "kosong" // Clear the preview if no file is selected
	}

	target.value = "" // Clear the input after processing
}

const handlePhotoCancel = () => {
	fileFoto.value = null
	displayPreview.value = false
	localState.biodata!.thumbnail_url = authstore.biodata!.thumbnail_url
}

const tanggalLahirConfig = ref({
	allowInput: true,
	format: "d-m-Y",
})

//urusin drag and drop foto
const isDragging = ref(false)

const handleDragOver = () => {
	isDragging.value = true // Set dragging state to true when dragging over
}

const handleDragLeave = () => {
	isDragging.value = false // Reset dragging state when leaving the drop area
}

const handleDrop = (event: DragEvent) => {
	isDragging.value = false
	const file = event.dataTransfer?.files?.[0]

	if (file) {
		// Directly pass the file to a new method that handles file processing
		processFile(file)
	}
}

const processFile = (file: File) => {
	// Check if the file is an image
	if (!file.type.startsWith("image/")) {
		showToast({
			message: "File harus berupa gambar",
			type: "error",
		})
		return
	}

	const reader = new FileReader()
	reader.onload = (e) => {
		imagePreview.value = e.target?.result as string
		localState.biodata!.thumbnail_url = e.target?.result as string
	}
	reader.readAsDataURL(file)
	fileFoto.value = file
	displayPreview.value = true
}

onMounted(async () => {
	console.log("Mounted")
	if (!authstore.biodata) {
		console.log("Fetching data from me")
		await requestor.get(ENDPOINTS.ME_SISWA).then((response) => {
			const data = response.data.data
			authstore.biodata = data.biodata
			authstore.user = data.user
			localState = reactive({
				user: authstore.user ? { ...authstore.user } : null,
				biodata: authstore.biodata ? { ...authstore.biodata } : null,
			})
		})
	}
})
</script>

<template>
	<div class="grid grid-cols-5 gap-8">
		<!-- Personal Information Section -->
		<div class="col-span-5 xl:col-span-3">
			<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
				<div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
					<h3 class="font-medium text-black dark:text-white">Personal Information</h3>
				</div>
				<div class="p-7" v-if="localState.biodata">
					<form @submit.prevent="handleSubmit">
						<div class="mb-5.5">
							<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="nisn">NISN</label>
							<input
								v-model="localState.biodata!.nisn"
								class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
								type="text"
								name="nisn"
								id="nisn"
								inputmode="numeric" />
							<div v-html="field_error_html('nisn')"></div>
						</div>
						<div class="mb-5.5">
							<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="nik">NIK</label>
							<input
								v-model="localState.biodata!.nik"
								class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
								type="text"
								name="nik"
								id="nik"
								inputmode="numeric" />
							<div v-html="field_error_html('nik')"></div>
						</div>
						<div class="mb-5.5">
							<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="nik">No. Kartu Keluarga</label>
							<input
								v-model="localState.biodata!.no_kk"
								class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
								type="text"
								name="no_kk"
								id="no_kk"
								inputmode="numeric" />
							<div v-html="field_error_html('no_kk')"></div>
						</div>
						<!-- Full Name Section -->
						<div class="mb-5.5">
							<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="fullName">Nama</label>
							<input
								v-model="localState.biodata!.nama"
								class="w-full rounded border border-stroke bg-gray py-3 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
								type="text"
								name="fullName"
								id="fullName" />
							<div v-html="field_error_html('nama')"></div>
						</div>

						<!-- Email Address Section -->
						<div class="mb-5.5">
							<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="emailAddress">Email Address</label>
							<input
								v-model="localState.user!.email"
								class="w-full rounded border border-stroke bg-gray py-3 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
								type="email"
								name="emailAddress"
								id="emailAddress"
								inputmode="email" />
							<div v-html="field_error_html('email')"></div>
						</div>

						<!-- Username Section -->
						<div class="mb-5.5">
							<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="Username">Username</label>
							<input
								v-model="localState.user!.username"
								class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
								type="text"
								name="Username"
								id="Username"
								placeholder="devidjhon24" />
							<div v-html="field_error_html('username')"></div>
						</div>

						<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-5.5">
							<!-- Tempat Lahir (3/4 of the width on medium and larger screens) -->
							<div class="md:col-span-3">
								<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="tempat_lahir"> Tempat Lahir </label>
								<input
									v-model="localState.biodata!.tempat_lahir"
									class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
									type="text"
									name="tempat_lahir"
									id="tempat_lahir"
									placeholder="Tempat lahir anda" />
								<div v-html="field_error_html('tempat_lahir')"></div>
							</div>

							<!-- Tanggal Lahir (1/4 of the width on medium and larger screens) -->
							<div class="md:col-span-2">
								<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="tanggal-lahir"> Tanggal Lahir </label>
								<div class="relative">
									<flat-pickr
										v-model="localState.biodata!.tanggal_lahir"
										class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
										:config="tanggalLahirConfig"
										id="tanggal-lahir">
									</flat-pickr>
									<span class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-primary">
										<hero-icon name="calendar-search" class="w-5 h-5"></hero-icon>
									</span>
								</div>
								<div v-html="field_error_html('tanggal_lahir')"></div>
							</div>
						</div>

						<div class="mb-5.5">
							<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="Username">Nama Bapak</label>
							<input
								v-model="localState.biodata!.nama_bapak"
								class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
								type="text"
								name="nama_bapak"
								id="nama_bapak" />
							<div v-html="field_error_html('nama_bapak')"></div>
						</div>
						<div class="mb-5.5">
							<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="Username">Nama Ibu</label>
							<input
								v-model="localState.biodata!.nama_ibu"
								class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
								type="text"
								name="nama_ibu"
								id="nama_ibu" />
							<div v-html="field_error_html('nama_ibu')"></div>
						</div>
						<div class="mb-5.5">
							<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="Username">No. Hp Orang Tua</label>
							<input
								v-model="localState.biodata!.no_hp_ortu"
								class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
								type="text"
								name="no_hp_ortu"
								id="no_hp_ortu" />
							<div v-html="field_error_html('no_hp_ortu')"></div>
						</div>

						<!-- Save and Cancel Buttons -->
						<div class="flex justify-end gap-4.5">
							<button
								class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white"
								type="button"
								@click="handleCancel">
								Cancel
							</button>
							<button class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90" type="submit" :disabled="loadingUpdateProfile">
								<span class="flex items-center gap-2">
									<fwb-spinner
										v-if="loadingUpdateProfile"
										size="4"
										color="white"
										class="transition-all duration-500 ease-out"
										:class="{ 'opacity-0 -translate-x-5': !loadingUpdateProfile, 'opacity-100 translate-x-0': loadingUpdateProfile }" />Simpan
								</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Your Photo Section -->
		<div class="col-span-5 xl:col-span-2" v-if="localState.biodata">
			<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
				<div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
					<h3 class="font-medium text-black dark:text-white">Your Photo</h3>
				</div>
				<div class="p-7">
					<form @submit.prevent="handlePhotoSubmit">
						<!-- User Photo Section -->
						<div class="mb-4 flex items-center gap-3">
							<div class="h-14 w-14 rounded-full">
								<img :src="localState.biodata!.thumbnail_url" alt="User" />
							</div>
							<div>
								<span class="mb-1.5 font-medium text-black dark:text-white">Edit Foto</span>
							</div>
						</div>

						<!-- File Upload Section -->
						<div
							id="FileUpload"
							:class="{
								'border-green-500': isDragging,
								'border-primary': !isDragging,
							}"
							class="relative mb-5.5 block w-full cursor-pointer appearance-none rounded border-2 border-dashed bg-gray py-4 px-4 dark:bg-meta-4 sm:py-7.5"
							@dragover.prevent="handleDragOver"
							@dragleave.prevent="handleDragLeave"
							@drop.prevent="handleDrop">
							<input type="file" accept="image/*" class="absolute inset-0 z-50 m-0 h-full w-full cursor-pointer p-0 opacity-0 outline-none" @change="handleFileChange" />
							<div class="flex flex-col items-center justify-center space-y-3">
								<span class="text-primary flex h-10 w-10 items-center justify-center rounded-full bg-white dark:bg-meta-4">
									<hero-icon name="add-photo" />
								</span>
								<p class="text-sm font-medium items-center justify-center"><span class="text-primary">Click untuk memilih foto</span></p>
								<p class="text-sm font-medium items-center justify-center">atau seret foto ke kotak ini</p>
								<p class="mt-1.5 text-sm font-medium">JPG atau JPEG</p>
							</div>
						</div>
						<div class="mb-5.5" v-html="field_error_html('foto')"></div>
						<div v-if="displayPreview" class="relative mt-4 flex items-center justify-center mb-3">
							<!-- Image Preview -->
							<img :src="imagePreview" alt="Image Preview" class="max-w-full h-auto rounded" />

							<!-- Progress Bar Overlay -->
							<div v-if="loadingUpdatePhoto" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded">
								<div class="w-1/2 bg-gray-300 rounded-full h-2.5">
									<div class="bg-blue-600 h-2.5 rounded-full" :style="{ width: uploadProgress + '%' }"></div>
								</div>
							</div>
						</div>

						<!-- Save and Cancel Buttons for Photo Section -->
						<div class="flex justify-end gap-4.5">
							<button
								class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white"
								type="button"
								@click="handlePhotoCancel">
								Cancel
							</button>
							<button
								class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90"
								@click="handlePhotoSubmit"
								type="button"
								:disabled="loadingUpdatePhoto || !fileFoto">
								<span class="flex items-center gap-2">
									<fwb-spinner
										v-if="loadingUpdatePhoto"
										size="4"
										color="white"
										class="transition-all duration-500 ease-out"
										:class="{ 'opacity-0 -translate-x-5': !loadingUpdatePhoto, 'opacity-100 translate-x-0': loadingUpdatePhoto }" />
									Simpan Foto
								</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>
