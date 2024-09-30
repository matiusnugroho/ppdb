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
const field_error_html = (field: string) => {
	const errors = formValidationErrors.errors[field]

	if (errors && errors.length > 0) {
		return `
      <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
        ${errors.join(", ")}
      </span>
    `
	}
	return ""
}

onMounted(() => {
	formValidationErrors.clearErrors()
})
</script>

<template>
	<PlainLayout>
		<DefaultAuthCard subtitle="Start for free" title="Sign Up to TailAdmin">
			<form @submit.prevent="handleSubmit">
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="nisn">NISN</label>
					<input
						v-model="nisn"
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
						v-model="nik"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="nik"
						id="nik"
						inputmode="numeric" />
					<div v-html="field_error_html('nik')"></div>
				</div>

				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="no_kk">No. Kartu Keluarga</label>
					<input
						v-model="no_kk"
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
						v-model="nama"
						class="w-full rounded border border-stroke bg-gray py-3 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="fullName"
						id="fullName" />
					<div v-html="field_error_html('nama')"></div>
				</div>

				<!-- Email Address Section -->
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="emailAddress">Email Address</label>
					<input
						v-model="email"
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
						v-model="username"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="Username"
						id="Username"
						placeholder="devidjhon24" />
					<div v-html="field_error_html('username')"></div>
				</div>

				<!-- Password Section -->
				<div class="mb-5.5">
					<PasswordInput label="Password" v-model="password" />
					<div v-html="field_error_html('password')"></div>
				</div>

				<!-- Tempat Lahir Section -->
				<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-5.5">
					<!-- Tempat Lahir (3/4 of the width on medium and larger screens) -->
					<div class="md:col-span-3">
						<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="tempat_lahir"> Tempat Lahir </label>
						<input
							v-model="tempat_lahir"
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
								v-model="tanggal_lahir"
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

				<!-- Nama Bapak Section -->
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="nama_bapak">Nama Bapak</label>
					<input
						v-model="nama_bapak"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="nama_bapak"
						id="nama_bapak" />
					<div v-html="field_error_html('nama_bapak')"></div>
				</div>

				<!-- Nama Ibu Section -->
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="nama_ibu">Nama Ibu</label>
					<input
						v-model="nama_ibu"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="nama_ibu"
						id="nama_ibu" />
					<div v-html="field_error_html('nama_ibu')"></div>
				</div>

				<!-- No. Hp Orang Tua Section -->
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="no_hp_ortu">No. Hp Orang Tua</label>
					<input
						v-model="no_hp_ortu"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="no_hp_ortu"
						id="no_hp_ortu"
						inputmode="numeric" />
					<div v-html="field_error_html('no_hp_ortu')"></div>
				</div>

				<div class="mb-5.5">
					<button :disabled="loadingRegister" class="w-full rounded bg-primary p-3 text-white">Submit</button>
				</div>
			</form>
		</DefaultAuthCard>
	</PlainLayout>
</template>
