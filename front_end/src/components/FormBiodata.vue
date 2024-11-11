<script setup lang="ts">
import { reactive, ref, onMounted, computed } from "vue"

import { showToast } from "@/utils/ui/toast"
import { useAuthStore } from "@/stores/auth"
import { useUpdateProfile } from "@/composable/useUpdateProfile"
import type { ProfileSiswaRequest, Option } from "@/types"
import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import flatPickr from "vue-flatpickr-component"
import { useSmoothScrollToTop } from "@/composable/useSmoothScrollToTop"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import { field_error_html } from "@/helpers/fieldErrorHtml"
import SpinnerLoading from "@/components/UI/SpinnerLoading.vue"
import { hasError } from "@/helpers/hasError"
import InputGroup from "@/components/Forms/InputGroup.vue"
import SelectGroup from "@/components/Forms/SelectGroup.vue"
import PasswordInput from "./Forms/PasswordInput.vue"
import { useAkun } from "@/composable/useAkun"

const authstore = useAuthStore()
const { smoothScrollToTop } = useSmoothScrollToTop()
const formValidationErrors = useFormValidationErrorsStore()
const passwordLama = ref("")
const passwordBaru = ref("")
let localState = reactive({
	user: authstore.user ? { ...authstore.user } : null,
	biodata: authstore.biodata ? { ...authstore.biodata } : null,
})
const imagePreview = ref<string>("")
const fileFoto = ref<File | null>(null)
const displayPreview = ref<boolean>(false)

const { uploadPhoto, loadingUpdatePhoto, uploadProgress, updateProfile, uploadError, loadingUpdateProfile } = useUpdateProfile()
const {loadingGantiPassword, gantiPassword} = useAkun()
const jenisKelaminOption = computed<Option[]>(() => {
	return [
		{ label: "Laki-laki", value: "L" },
		{ label: "Perempuan", value: "P" },
	]
})
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

const handleGantiPassword = async () => {
	const data= {
		password_lama: passwordLama.value,
		password_baru: passwordBaru.value
	}
	const result = await gantiPassword(data)
	if(result.success){
		showToast({
			message: "Password berhasil diganti",
		})
		passwordLama.value = ""
		passwordBaru.value = ""
	}
	else{
		showToast({
			message: "Password gagal diganti " + result.message,
			type: "error",
		})
	}
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
						<div class="mb-3">
							<InputGroup label="Nomor Induk Siswa Nasional" v-model="localState.biodata!.nisn" :error="hasError('nisn')" name="nisn" inputmode="numeric" required />
							<div v-html="field_error_html('nisn')"></div>
						</div>
						<div class="mb-3">
							<InputGroup label="Nomor Induk Kependudukan" v-model="localState.biodata!.nik" :error="hasError('nik')" name="nik" inputmode="numeric" required />
							<div v-html="field_error_html('nik')"></div>
						</div>
						<div class="mb-3">
							<InputGroup label="Nomor Kartu Keluarga" v-model="localState.biodata!.no_kk" :error="hasError('no_kk')" name="no_kk" inputmode="numeric" required />
							<div v-html="field_error_html('no_kk')"></div>
						</div>
						<!-- Full Name Section -->
						<div class="mb-3">
							<InputGroup label="Nama" v-model="localState.biodata!.nama" :error="hasError('nama')" name="nama" inputmode="text" required />
							<div v-html="field_error_html('nama')"></div>
						</div>
						<div class="mb-3">
							<SelectGroup v-model="localState.biodata.jenis_kelamin" :error="hasError('jenis_kelamin')" name="jenis_kelamin" label="Jenis Kelamin" :options="jenisKelaminOption" />
							<div v-html="field_error_html('jenis_kelamin')"></div>
						</div>
						<!-- Email Address Section -->
						<div class="mb-3">
							<InputGroup label="Email" v-model="localState.user!.email" :error="hasError('email')" name="email" type="email" inputmode="email" required />
							<div v-html="field_error_html('email')"></div>
						</div>

						<!-- Username Section -->
						<div class="mb-3">
							<InputGroup label="Username" v-model="localState.user!.username" :error="hasError('username')" name="username" inputmode="text" required />
							<div v-html="field_error_html('username')"></div>
						</div>

						<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-3">
							<!-- Tempat Lahir (3/4 of the width on medium and larger screens) -->
							<div class="md:col-span-3 flex flex-col">
								<InputGroup
									class="h-full"
									label="Tempat Lahir"
									v-model="localState.biodata!.tempat_lahir"
									:error="hasError('tempat_lahir')"
									name="tempat_lahir"
									inputmode="text"
									required />
								<div v-html="field_error_html('tempat_lahir')"></div>
							</div>
							<!-- Tanggal Lahir (1/4 of the width on medium and larger screens) -->
							<div class="md:col-span-2 flex flex-col">
								<label class="mb-1 block text-black dark:text-white" for="tanggal-lahir"> Tanggal Lahir </label>
								<div class="relative flex-grow">
									<flat-pickr
										v-model="localState.biodata!.tanggal_lahir"
										class="w-full rounded border border-stroke bg-gray py-1 px-2.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary h-full"
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

						<div class="mb-3">
							<InputGroup label="Nama Ayah" v-model="localState.biodata!.nama_bapak" :error="hasError('nama_bapak')" name="nama_bapak" inputmode="text" required />
							<div v-html="field_error_html('nama_bapak')"></div>
						</div>
						<div class="mb-3">
							<InputGroup label="Nama Ibu" v-model="localState.biodata!.nama_ibu" :error="hasError('nama_ibu')" name="nama_ibu" inputmode="text" required />
							<div v-html="field_error_html('nama_ibu')"></div>
						</div>
						<div class="mb-3">
							<InputGroup label="No. HP Orang Tua" v-model="localState.biodata!.no_hp_ortu" :error="hasError('no_hp_ortu')" name="no_hp_ortu" inputmode="text" required />
							<div v-html="field_error_html('no_hp_ortu')"></div>
						</div>

						<!-- Save and Cancel Buttons -->
						<div class="flex justify-end gap-4.5">
							<button
								class="flex justify-center rounded border border-stroke py-2 px-6 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white"
								type="button"
								@click="handleCancel">
								Batal
							</button>
							<button class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90" type="submit" :disabled="loadingUpdateProfile">
								<span class="flex items-center gap-2">
									<SpinnerLoading
										:loading="loadingUpdateProfile"
										size="xs"
										class="transition-transform duration-300 ease-in-out"
										:class="loadingUpdateProfile ? 'translate-x-[-10px]' : 'translate-x-0'" />
									Simpan
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
					<h3 class="font-medium text-black dark:text-white">Perbarui Foto</h3>
				</div>
				<div class="p-7">
					<form @submit.prevent="handlePhotoSubmit">
						<!-- File Upload Section -->
						<div
							id="FileUpload"
							:class="{
								'border-green-500': isDragging,
								'border-primary': !isDragging,
							}"
							class="relative mb-3 block w-full cursor-pointer appearance-none rounded border-2 border-dashed bg-gray py-4 px-4 dark:bg-meta-4 sm:py-7.5"
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
						<div class="mb-3" v-html="field_error_html('foto')"></div>
						<div v-if="displayPreview" class="relative mt-4 flex items-center justify-center mb-3">
							<!-- Image Preview -->
							<img :src="imagePreview" alt="Image Preview" class="max-w-full h-auto rounded" />

							<!-- Progress Bar Overlay -->
							<div v-if="loadingUpdatePhoto" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded">
								<!-- Radial Progress Bar (DaisyUI) -->
								<div class="radial-progress text-primary" :style="{ '--value': uploadProgress }" role="progressbar">{{ uploadProgress }}%</div>
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
									<SpinnerLoading :loading="loadingUpdatePhoto" size="xs" />
									Simpan Foto
								</span>
							</button>
						</div>
					</form>
				</div>
			</div>
			<div class="mt-5 rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
				<div class="border-b border-stroke py-4 px-7 dark:border-strokedark">
					<h3 class="font-medium text-black dark:text-white">Perbarui Password</h3>
				</div>
				<div class="p-7">
					<div class="mb-3">
						<PasswordInput label="Password Lama" v-model="passwordLama" />
						<div v-html="field_error_html('password_lama')"></div>
					</div>
					<div class="mb-3">
						<PasswordInput label="Password Baru" v-model="passwordBaru" />
						<div v-html="field_error_html('password_baru')"></div>
					</div>
					<div class="flex justify-end gap-4.5 m-2">
						<button
							class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90"
							@click="handleGantiPassword"
							type="button"
							:disabled="loadingGantiPassword">
							<span class="flex items-center gap-2">
								<SpinnerLoading :loading="loadingGantiPassword" size="xs" />
								Ganti Password
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
