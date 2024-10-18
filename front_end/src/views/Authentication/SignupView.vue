<script setup lang="ts">
import { onMounted, ref } from "vue"
import DefaultAuthCard from "@/components/Auths/DefaultAuthCard.vue"
import PlainLayout from "@/layouts/PlainLayout.vue"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import flatPickr from "vue-flatpickr-component"
import { useRegisterSiswa } from "@/composable/useRegisterSiswa"
import PasswordInput from "@/components/Forms/PasswordInput.vue"
import { useMessagesStore } from "@/stores/messages"
import router from "@/router"
import { showToast } from "@/utils/ui/toast"
import { hasError } from "@/helpers/hasError"
import { field_error_html } from "@/helpers/fieldErrorHtml"
import InputGroup from "@/components/Forms/InputGroup.vue"
import SpinnerLoading from "@/components/UI/SpinnerLoading.vue"
// Define individual refs for each form field
const nisn = ref("")
const nik = ref("")
const no_kk = ref("")
const nama = ref("")
const email = ref("")
const username = ref("")
const tempat_lahir = ref("")
const tanggal_lahir = ref("")
const nama_bapak = ref("")
const nama_ibu = ref("")
const no_hp_ortu = ref("")
const password = ref("")

const formValidationErrors = useFormValidationErrorsStore()
const { registerSiswa, loadingRegister } = useRegisterSiswa()
const messagesStore = useMessagesStore()
const handleSubmit = async () => {
	const data = {
		nisn: nisn.value,
		nik: nik.value,
		no_kk: no_kk.value,
		nama: nama.value,
		email: email.value,
		username: username.value,
		tempat_lahir: tempat_lahir.value,
		tanggal_lahir: tanggal_lahir.value,
		nama_bapak: nama_bapak.value,
		nama_ibu: nama_ibu.value,
		no_hp_ortu: no_hp_ortu.value,
		password: password.value,
	}
	const sukses = await registerSiswa(data)
	if (sukses) {
		messagesStore.addMessage("success", {
			title: "Pendaftaran Berhasil",
			detail: "Silakan Login dengan akun yang telah dibuat",
		})
		await router.push({ name: "login" })
	} else {
		showToast({
			message: "Gagal Mendaftar, perhatikan kesalahan pengisian data",
			type: "error",
		})
	}
}
const tanggalLahirConfig = ref({
	allowInput: true,
	format: "d-m-Y",
})

onMounted(() => {
	formValidationErrors.clearErrors()
})
</script>

<template>
	<PlainLayout>
		<DefaultAuthCard subtitle="Start for free" title="Sign Up to TailAdmin">
			<form @submit.prevent="handleSubmit">
				<div class="mb-3">
					<InputGroup label="Nomor Induk Siswa Nasional" v-model="nisn" :error="hasError('nisn')" name="nisn" inputmode="numeric" required />
					<div v-html="field_error_html('nisn')"></div>
				</div>
				<div class="mb-3">
					<InputGroup label="Nomor Induk Kependudukan" v-model="nik" :error="hasError('nik')" name="nik" inputmode="numeric" required />
					<div v-html="field_error_html('nik')"></div>
				</div>
				<div class="mb-3">
					<InputGroup label="Nomor Kartu Keluarga" v-model="no_kk" :error="hasError('no_kk')" name="no_kk" inputmode="numeric" required />
					<div v-html="field_error_html('no_kk')"></div>
				</div>
				<!-- Full Name Section -->
				<div class="mb-3">
					<InputGroup label="Nama" v-model="nama" :error="hasError('nama')" name="nama" inputmode="text" required />
					<div v-html="field_error_html('nama')"></div>
				</div>

				<!-- Email Address Section -->
				<div class="mb-3">
					<InputGroup label="Email" v-model="email" :error="hasError('email')" name="email" type="email" inputmode="email" required />
					<div v-html="field_error_html('email')"></div>
				</div>

				<!-- Username Section -->
				<div class="mb-3">
					<InputGroup label="Username" v-model="username" :error="hasError('username')" name="username" inputmode="text" required />
					<div v-html="field_error_html('username')"></div>
				</div>
				<!-- Password Section -->
				<div class="mb-3">
					<PasswordInput label="Password" name="password" v-model="password" />
					<div v-html="field_error_html('password')"></div>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-3">
					<!-- Tempat Lahir (3/4 of the width on medium and larger screens) -->
					<div class="md:col-span-3 flex flex-col">
						<InputGroup label="Tempat Lahir" v-model="tempat_lahir" :error="hasError('tempat_lahir')" name="tempat_lahir" inputmode="text" required class="h-full" />
						<div v-html="field_error_html('tempat_lahir')"></div>
					</div>
					<!-- Tanggal Lahir (1/4 of the width on medium and larger screens) -->
					<div class="md:col-span-2 flex flex-col">
						<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="tanggal-lahir"> Tanggal Lahir </label>
						<div class="relative flex-grow">
							<!-- Ensure it uses available height -->
							<flat-pickr
								v-model="tanggal_lahir"
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
					<InputGroup label="Nama Ayah" v-model="nama_bapak" :error="hasError('nama_bapak')" name="nama_bapak" inputmode="text" required />
					<div v-html="field_error_html('nama_bapak')"></div>
				</div>
				<div class="mb-3">
					<InputGroup label="Nama Ibu" v-model="nama_ibu" :error="hasError('nama_ibu')" name="nama_ibu" inputmode="text" required />
					<div v-html="field_error_html('nama_ibu')"></div>
				</div>
				<div class="mb-3">
					<InputGroup label="No. HP Orang Tua" v-model="no_hp_ortu" :error="hasError('no_hp_ortu')" name="no_hp_ortu" inputmode="text" required />
					<div v-html="field_error_html('no_hp_ortu')"></div>
				</div>
				<div class="mb-5.5">
					<button :disabled="loadingRegister" class="w-full flex justify-center rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90">
						<span class="flex items-center gap-2">
							<SpinnerLoading
								:loading="loadingRegister"
								size="xs"
								class="transition-transform duration-300 ease-in-out gap-2"
								:class="loadingRegister ? 'translate-x-[-10px]' : 'translate-x-0'" />
							Daftar
						</span>
					</button>
				</div>
			</form>
		</DefaultAuthCard>
	</PlainLayout>
</template>
