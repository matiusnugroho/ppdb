<script setup lang="ts">
import { ref } from "vue"
import DefaultAuthCard from "@/components/Auths/DefaultAuthCard.vue"
import PlainLayout from "@/layouts/PlainLayout.vue"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import flatPickr from "vue-flatpickr-component"
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

const formValidationErrors = useFormValidationErrorsStore()

const handleSubmit = () => {
	// Handle form submission logic
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
					<div class="relative">
						<span class="absolute left-4.5 top-4">
							<font-awesome-icon icon="fa-regular fa-user" />
						</span>
						<input
							v-model="nama"
							class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
							type="text"
							name="fullName"
							id="fullName" />
						<div v-html="field_error_html('nama')"></div>
					</div>
				</div>

				<!-- Email Address Section -->
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="emailAddress">Email Address</label>
					<div class="relative">
						<span class="absolute left-4.5 top-4">
							<font-awesome-icon icon="fa-regular fa-envelope" />
						</span>
						<input
							v-model="email"
							class="w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
							type="email"
							name="emailAddress"
							id="emailAddress"
							inputmode="email" />
						<div v-html="field_error_html('email')"></div>
					</div>
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

				<!-- Tempat Lahir Section -->
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="tempat_lahir">Tempat Lahir</label>
					<input
						v-model="tempat_lahir"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						type="text"
						name="tempat_lahir"
						id="tempat_lahir"
						placeholder="Tempat lahir anda" />
					<div v-html="field_error_html('tempat_lahir')"></div>
				</div>

				<!-- Tanggal Lahir Section -->
				<div class="mb-5.5">
					<label class="mb-3 block text-sm font-medium text-black dark:text-white" for="Username">Tanggal Lahir</label>
					<flat-pickr
						v-model="tanggal_lahir"
						class="w-full rounded border border-stroke bg-gray py-3 px-4.5 font-normal text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary"
						:config="tanggalLahirConfig"
						id="tanggal-lahir">
					</flat-pickr>
					<div v-html="field_error_html('tanggal_lahir')"></div>
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
					<button class="w-full rounded bg-primary p-3 text-white">Submit</button>
				</div>
			</form>
		</DefaultAuthCard>
	</PlainLayout>
</template>
