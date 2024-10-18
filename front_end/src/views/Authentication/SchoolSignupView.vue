<script setup lang="ts">
import { computed, onMounted, ref } from "vue"
import DefaultAuthCard from "@/components/Auths/DefaultAuthCard.vue"
import PlainLayout from "@/layouts/PlainLayout.vue"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { useRegisterSekolah } from "@/composable/useRegisterSekolah"
import PasswordInput from "@/components/Forms/PasswordInput.vue"
import { useMessagesStore } from "@/stores/messages"
import router from "@/router"
import { showToast } from "@/utils/ui/toast"
import { useKecamatan } from "@/composable/useKecamatan"
import { field_error_html } from "@/helpers/fieldErrorHtml"
import InputGroup from "@/components/Forms/InputGroup.vue"
import { hasError } from "@/helpers/hasError"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"
import { buatOption } from "@/helpers/buatOption"
import type { Option } from "@/types"
import SpinnerLoading from "@/components/UI/SpinnerLoading.vue"
import TextAreaGroup from "@/components/Forms/TextAreaGroup.vue"
// Define individual refs for each form field
const nama_sekolah = ref("")
const nss = ref("")
const npsn = ref("")
const jenjang = ref("")
const alamat = ref("")
const no_telp = ref("")
const email = ref("")
const username = ref("")
const nama_kepsek = ref("")
const kecamatan_id = ref("")
const password = ref("")

const jenjangOption = [
	{ label: "SD", value: "sd" },
	{ label: "SMP", value: "smp" }
]

const formValidationErrors = useFormValidationErrorsStore()
const { registerSekolah, loadingRegister } = useRegisterSekolah()
const messagesStore = useMessagesStore()
const { loadingKecamatan, kecamatanList, fetchKecamatan, error } = useKecamatan()
const handleSubmit = async () => {
	const data = {
		nama_sekolah: nama_sekolah.value,
		nss: nss.value,
		npsn: npsn.value,
		jenjang: jenjang.value,
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

const kecamatanOption = computed<Option[]>(() => {
	return buatOption(kecamatanList.value, "nama", "id")
})
onMounted(() => {
	fetchKecamatan()
	formValidationErrors.clearErrors()
})
</script>

<template>
	<PlainLayout>
		<DefaultAuthCard subtitle="Daftarkan Sekolah Anda" title="PPDB Kuantan Singingi">
			<form @submit.prevent="handleSubmit">
				<div class="mb-1">
					<InputGroup label="Nama Sekolah" v-model="nama_sekolah" :error="hasError('nama_sekolah')" name="nama_sekolah" inputmode="text" required />
					<div v-html="field_error_html('nama_sekolah')"></div>
				</div>
				<div class="mb-1">
					<InputGroup label="Nomor Pokok Sekolah Nasional (NPSN)" v-model="npsn" :error="hasError('npsn')" name="npsn" inputmode="numeric" required />
					<div v-html="field_error_html('npsn')"></div>
				</div>
				<div class="mb-1">
					<InputGroup label="Nomor Statistik Sekolah (NSS)" v-model="nss" :error="hasError('nss')" name="nss" inputmode="numeric" required />
					<div v-html="field_error_html('nss')"></div>
				</div>
				<div class="mb-1">
					<SearchableSelect label="Jenjang" v-model="jenjang" :error="hasError('jenjang')" name="jenjang" :options="jenjangOption" />
					<div v-html="field_error_html('jenjang')"></div>
				</div>
				<div class="mb-1">
					<InputGroup label="Nama Kepala Sekolah" v-model="nama_kepsek" :error="hasError('nama_kepsek')" name="nama_kepsek" inputmode="text" required />
					<div v-html="field_error_html('nama_kepsek')"></div>
				</div>
				<div class="mb-1">
					<InputGroup label="No. Telp" v-model="no_telp" :error="hasError('no_telp')" name="no_telp" inputmode="numeric" required />
					<div v-html="field_error_html('no_telp')"></div>
				</div>
				<div class="mb-1">
					<SearchableSelect :loading="loadingKecamatan" label="Kecamatan" v-model="kecamatan_id" :error="hasError('kecamatan_id')" name="kecamatan_id" :options="kecamatanOption" />

					<div v-html="field_error_html('kecamatan_id')"></div>
					<p v-if="error" class="text-red-500">{{ error }}</p>
				</div>
				<div class="mb-1">
					<TextAreaGroup :error="hasError('alamat')" name="alamat" label="Alamat" v-model="alamat" />
					<div v-html="field_error_html('alamat')"></div>
				</div>

				<!-- Full Name Section -->

				<!-- Email Address Section -->
				<div class="mb-1">
					<InputGroup label="Email" v-model="email" :error="hasError('email')" name="email" inputmode="email" required />
					<div v-html="field_error_html('email')"></div>
				</div>

				<!-- Username Section -->
				<div class="mb-1">
					<InputGroup label="Username" v-model="username" :error="hasError('username')" name="username" inputmode="text" required />
					<div v-html="field_error_html('username')"></div>
				</div>

				<!-- Password Section -->
				<div class="mb-1">
					<PasswordInput name="password" label="Password" v-model="password" :error="hasError('password')" />
					<div v-html="field_error_html('password')"></div>
				</div>

				<div class="mb-1 mt-3">
					<button :disabled="loadingRegister" class="w-full rounded bg-primary p-3 text-white flex justify-center rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90">
						<span class="flex items-center gap-2">
							<SpinnerLoading
								:loading="loadingRegister"
								size="xs"
								class="transition-transform duration-300 ease-in-out"
								:class="loadingRegister ? 'translate-x-[-10px]' : 'translate-x-0'" />
							Daftar
						</span>
					</button>
				</div>
			</form>
		</DefaultAuthCard>
	</PlainLayout>
</template>
