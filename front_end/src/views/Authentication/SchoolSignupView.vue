<script setup lang="ts">
import { onMounted, ref } from "vue"
import DefaultAuthCard from "@/components/Auths/DefaultAuthCard.vue"
import PlainLayout from "@/layouts/PlainLayout.vue"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { useRegisterSekolah } from "@/composable/useRegisterSekolah"
import PasswordInput from "@/components/Forms/PasswordInput.vue"
import { useMessagesStore } from "@/stores/messages"
import router from "@/router"
import { showToast } from "@/utils/ui/toast"
import { useKecamatan } from "@/composable/useKecamatan"
// Define individual refs for each form field
const nama_sekolah = ref("")
const nss = ref("")
const npsn = ref("")
const alamat = ref("")
const no_telp = ref("")
const email = ref("")
const username = ref("")
const nama_kepsek = ref("")
const kecamatan_id = ref("")
const password = ref("")

const formValidationErrors = useFormValidationErrorsStore()
const { registerSekolah, loadingRegister } = useRegisterSekolah()
const messagesStore = useMessagesStore()
const { loadingKecamatan, kecamatanList, fetchKecamatan, error } = useKecamatan()
const handleSubmit = async () => {
	const data = {
		nama_sekolah: nama_sekolah.value,
		nss: nss.value,
		npsn: npsn.value,
		alamat: alamat.value,
		no_telp: no_telp.value,
		email: email.value,
		username: username.value,
		nama_kepsek: nama_kepsek.value,
		kecamatan_id: kecamatan_id.value,
		password: password.value,
	}
	const sukses = await registerSekolah(data)
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
	fetchKecamatan()
	formValidationErrors.clearErrors()
})
</script>

<template>
	<PlainLayout>
		<DefaultAuthCard subtitle="Start for free" title="Sign Up to TailAdmin">
			<form @submit.prevent="handleSubmit">
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="fullName">Nama Sekolah</label>
					<input
						v-model="nama_sekolah"
						class="w-full rounded border border-stroke bg-gray py-3 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="fullName"
						id="fullName" />
					<div v-html="field_error_html('nama_sekolah')"></div>
				</div>
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="npsn">NPSN</label>
					<input
						v-model="npsn"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="npsn"
						id="npsn"
						inputmode="numeric" />
					<div v-html="field_error_html('npsn')"></div>
				</div>

				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="nss">NSS</label>
					<input
						v-model="nss"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="nss"
						id="nss"
						inputmode="numeric" />
					<div v-html="field_error_html('nss')"></div>
				</div>
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="nama_kepsek">Nama Kepsek</label>
					<input
						v-model="nama_kepsek"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="nama_kepsek"
						id="nama_kepsek" />
					<div v-html="field_error_html('nama_kepsek')"></div>
				</div>
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="no_telp">No. Telp</label>
					<input
						v-model="no_telp"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="no_telp"
						id="no_telp"
						inputmode="numeric" />
					<div v-html="field_error_html('no_telp')"></div>
				</div>
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="kecamatan_id">Kecamatan</label>

					<select
						v-model="kecamatan_id"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						name="kecamatan_id"
						id="kecamatan_id">
						<!-- Show 'Loading...' option when loading -->
						<option v-if="loadingKecamatan" disabled value="">Sedang mengambil data kecamatan</option>

						<!-- Default disabled option when not loading -->
						<option v-else disabled value="">Pilih Kecamatan</option>

						<!-- Populate kecamatan list once data is loaded -->
						<option v-for="kecamatan in kecamatanList" :key="kecamatan.id" :value="kecamatan.id">{{ kecamatan.nama }}</option>
					</select>

					<div v-html="field_error_html('kecamatan_id')"></div>
					<p v-if="error" class="text-red-500">{{ error }}</p>
				</div>
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="alamat">Alamat</label>
					<textarea
						v-model="alamat"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						name="alamat"
						id="alamat"
						rows="4"></textarea>
					<div v-html="field_error_html('alamat')"></div>
				</div>

				<!-- Full Name Section -->

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
						id="Username" />
					<div v-html="field_error_html('username')"></div>
				</div>

				<!-- Password Section -->
				<div class="mb-5.5">
					<PasswordInput label="Password" v-model="password" />
					<div v-html="field_error_html('password')"></div>
				</div>

				<div class="mb-5.5">
					<button :disabled="loadingRegister" class="w-full rounded bg-primary p-3 text-white">Submit</button>
				</div>
			</form>
		</DefaultAuthCard>
	</PlainLayout>
</template>
