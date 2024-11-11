<script setup lang="ts">
import { onMounted, computed, ref } from "vue"
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
import jenjangData from "@/config/jenjang"
import type { Option } from "@/types"
import SelectGroup from "@/components/Forms/SelectGroup.vue"
import { useKecamatan } from "@/composable/useKecamatan"
import { buatOption } from "@/helpers/buatOption"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"
import TextAreaGroup from "@/components/Forms/TextAreaGroup.vue"
// Define individual refs for each form field
const jenjang = ref("")
const kecamatan_id = ref("")
const alamat = ref("")
const nisn = ref("")
const nik = ref("")
const no_kk = ref("")
const nama = ref("")
const jenis_kelamin = ref("")
const email = ref("")
const username = ref("")
const tempat_lahir = ref("")
const tanggal_lahir = ref("")
const nama_bapak = ref("")
const nama_ibu = ref("")
const no_hp_ortu = ref("")
const password = ref("")
const jenjangOption = ref<Option[]>([...jenjangData])
const formValidationErrors = useFormValidationErrorsStore()
const { registerSiswa, loadingRegister } = useRegisterSiswa()
const { kecamatanList, fetchKecamatan, loadingKecamatan } = useKecamatan()
const messagesStore = useMessagesStore()
const handleSubmit = async () => {
	const data = {
		jenjang: jenjang.value,
		kecamatan_id: kecamatan_id.value,
		alamat: alamat.value,
		nisn: nisn.value,
		nik: nik.value,
		no_kk: no_kk.value,
		nama: nama.value,
		jenis_kelamin: jenis_kelamin.value,
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
const kecamatanOption = computed<Option[]>(() => {
	return buatOption(kecamatanList.value, "nama", "id")
})
const jenisKelaminOption = computed<Option[]>(() => {
	return [
		{ label: "Laki-laki", value: "L" },
		{ label: "Perempuan", value: "P" },
	]
})
onMounted(() => {
	formValidationErrors.clearErrors()
	fetchKecamatan()
})
</script>

<template>
	<PlainLayout>
		<DefaultAuthCard subtitle="PPDB Online Kabupaten Kuantan singingi" title="Daftarkan Siswa">
			<form @submit.prevent="handleSubmit">
				<div class="mb-1">
					<SelectGroup v-model="jenjang" :error="hasError('jenjang')" name="jenjang" label="Jenjang" :options="jenjangOption" />
					<div v-html="field_error_html('jenjang')"></div>
				</div>

				<div class="mb-1">
					<InputGroup label="Nomor Induk Siswa Nasional" v-model="nisn" :error="hasError('nisn')" name="nisn" inputmode="numeric" />
					<div v-html="field_error_html('nisn')"></div>
				</div>
				<div class="mb-1">
					<InputGroup label="Nomor Induk Kependudukan" v-model="nik" :error="hasError('nik')" name="nik" inputmode="numeric" required />
					<div v-html="field_error_html('nik')"></div>
				</div>
				<div class="mb-1">
					<InputGroup label="Nomor Kartu Keluarga" v-model="no_kk" :error="hasError('no_kk')" name="no_kk" inputmode="numeric" required />
					<div v-html="field_error_html('no_kk')"></div>
				</div>
				<!-- Full Name Section -->
				<div class="mb-1">
					<InputGroup label="Nama" v-model="nama" :error="hasError('nama')" name="nama" inputmode="text" required />
					<div v-html="field_error_html('nama')"></div>
				</div>
				<div class="mb-1">
					<SelectGroup v-model="jenis_kelamin" :error="hasError('jenis_kelamin')" name="jenis_kelamin" label="Jenis Kelamin" :options="jenisKelaminOption" />
					<div v-html="field_error_html('jenis_kelamin')"></div>
				</div>

				<!-- Email Address Section -->
				<div class="mb-1">
					<InputGroup label="Email" v-model="email" :error="hasError('email')" name="email" type="email" inputmode="email" required />
					<div v-html="field_error_html('email')"></div>
				</div>

				<!-- Username Section -->
				<div class="mb-1">
					<InputGroup label="Username" v-model="username" :error="hasError('username')" name="username" inputmode="text" required />
					<div v-html="field_error_html('username')"></div>
				</div>
				<!-- Password Section -->
				<div class="mb-1">
					<PasswordInput label="Password" name="password" v-model="password" :error="hasError('password')" required />
					<div v-html="field_error_html('password')"></div>
				</div>
				<div class="mb-1">
					<SearchableSelect required label="Pilih Kecamatan" placeholder="Pilih Kecmatan" :options="kecamatanOption" v-model="kecamatan_id" :loading="loadingKecamatan" />
					<div v-html="field_error_html('kecamatan_id')"></div>
				</div>
				<div class="mb-1">
					<TextAreaGroup :error="hasError('alamat')" name="alamat" label="Alamat" v-model="alamat" />
					<div v-html="field_error_html('alamat')"></div>
				</div>
				<div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-1">
					<!-- Tempat Lahir (3/4 of the width on medium and larger screens) -->
					<div class="md:col-span-3 flex flex-col">
						<InputGroup label="Tempat Lahir" v-model="tempat_lahir" :error="hasError('tempat_lahir')" name="tempat_lahir" inputmode="text" required class="h-full" />
						<div v-html="field_error_html('tempat_lahir')"></div>
					</div>
					<!-- Tanggal Lahir (1/4 of the width on medium and larger screens) -->
					<div class="md:col-span-2 flex flex-col">
						<label class="mb-1 block text-black dark:text-white" for="tanggal-lahir"> Tanggal Lahir </label>
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

				<div class="mb-1">
					<InputGroup label="Nama Ayah" v-model="nama_bapak" :error="hasError('nama_bapak')" name="nama_bapak" inputmode="text" required />
					<div v-html="field_error_html('nama_bapak')"></div>
				</div>
				<div class="mb-1">
					<InputGroup label="Nama Ibu" v-model="nama_ibu" :error="hasError('nama_ibu')" name="nama_ibu" inputmode="text" required />
					<div v-html="field_error_html('nama_ibu')"></div>
				</div>
				<div class="mb-1">
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
