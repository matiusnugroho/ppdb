<template>
	<div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
		<div class="w-full max-w-4xl rounded-lg bg-white shadow-xl max-h-[90vh] overflow-y-auto">
			<div class="flex items-center justify-between border-b px-6 py-4">
				<h3 class="text-xl font-bold text-gray-900">{{ isEditMode ? "Edit Data Sekolah" : "Detail Sekolah" }}</h3>
				<button @click="close" class="text-gray-500 hover:text-gray-700">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>

			<form @submit.prevent="submitForm">
				<div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
					<InputGroup v-model="form.nama_sekolah" label="Nama Sekolah" name="nama_sekolah" required :disabled="!isEditMode" />
					<InputGroup v-model="form.nama_kepsek" label="Kepala Sekolah" name="nama_kepsek" required :disabled="!isEditMode" />
					<InputGroup v-model="form.nss" label="NSS" name="nss" inputmode="numeric" :disabled="!isEditMode" />
					<InputGroup v-model="form.npsn" label="NPSN" name="npsn" inputmode="numeric" :disabled="!isEditMode" />
					<InputGroup v-model="form.jenjang" label="Jenjang" name="jenjang" required :disabled="!isEditMode" />
					<InputGroup v-model="form.daya_tampung" label="Daya Tampung" name="daya_tampung" inputmode="numeric" :disabled="!isEditMode" />
					<InputGroup v-model="form.no_telp" label="No. Telepon" name="no_telp" inputmode="tel" :disabled="!isEditMode" />
					<InputGroup v-model="form.alamat" label="Alamat" name="alamat" required :disabled="!isEditMode" />
					<InputGroup v-model="form.email" label="Email Sekolah" name="email" type="email" required :disabled="!isEditMode" />
					<InputGroup v-model="form.username" label="Username Akun" name="username" :disabled="!isEditMode" />
					<InputGroup v-model="form.password" label="Password Akun (Isi jika ingin mengubah)" name="password" type="password" :disabled="!isEditMode" placeholder="Kosongkan jika tidak ingin mengubah" />

					<div class="flex flex-col gap-1">
						<label class="mb-1 block text-black">Kecamatan</label>
						<select
							v-model="form.kecamatan_id"
							class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 text-black outline-none transition focus:border-primary active:border-primary disabled:bg-gray-100 disabled:cursor-not-allowed"
							:disabled="!isEditMode">
							<option value="" disabled>Pilih Kecamatan</option>
							<option v-for="kec in kecamatanInfos" :key="kec.id" :value="kec.id">{{ kec.nama }}</option>
						</select>
					</div>
				</div>

				<div class="flex justify-end gap-3 border-t bg-gray-50 px-6 py-4">
					<button type="button" @click="close" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
						{{ isEditMode ? "Batal" : "Tutup" }}
					</button>
					<button v-if="isEditMode" type="submit" class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-opacity-90 disabled:opacity-50" :disabled="loading">
						<span v-if="loading" class="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
						Simpan Perubahan
					</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script setup lang="ts">
import { reactive, watch, ref, onMounted } from "vue"
import InputGroup from "@/components/Forms/InputGroup.vue"
import { useKecamatan } from "@/composable/useKecamatan"
import type { School } from "@/types"

const props = defineProps<{
	isOpen: boolean
	isEditMode: boolean
	schoolData: School | null
	loading?: boolean
}>()

const emit = defineEmits(["close", "submit"])
const { kecamatanList, fetchKecamatan: loadKecamatan } = useKecamatan()
const kecamatanInfos = ref<any[]>([])

const form = reactive({
	nama_sekolah: "",
	nss: "",
	npsn: "",
	jenjang: "",
	alamat: "",
	no_telp: "",
	email: "",
	nama_kepsek: "",
	kecamatan_id: "",
	daya_tampung: "",
    username: "",
    password: "",
})

watch(
	() => props.schoolData,
	(data) => {
		if (data) {
			form.nama_sekolah = data.nama_sekolah || ""
			form.nss = data.nss || ""
			form.npsn = data.npsn || ""
			form.jenjang = data.jenjang || ""
			form.alamat = data.alamat || ""
			form.no_telp = data.no_telp || ""
			form.email = data.email || ""
			form.nama_kepsek = data.nama_kepsek || ""
			form.kecamatan_id = (data.kecamatan_id || (data.kecamatan as any)?.id || "").toString()
			form.daya_tampung = data.daya_tampung?.toString() || ""
            form.username = data.user?.username || ""
            form.password = "" // Always reset password
		}
	},
	{ immediate: true },
)

onMounted(async () => {
    await loadKecamatan()
    kecamatanInfos.value = kecamatanList.value
})

const submitForm = () => {
	emit("submit", { ...form })
}

const close = () => {
	emit("close")
}
</script>
