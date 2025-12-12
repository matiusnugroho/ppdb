<script setup lang="ts">
import { computed, onMounted, reactive, watch } from "vue"
import { useRouter } from "vue-router"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { useAuthStore } from "@/stores/auth"
import { useKecamatan } from "@/composable/useKecamatan"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { field_error_html } from "@/helpers/fieldErrorHtml"
import { useUpdateSekolahProfile } from "@/composable/useUpdateSekolahProfile"
import { showToast } from "@/utils/ui/toast"
import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import InputGroup from "@/components/Forms/InputGroup.vue"
import type { ProfileSekolahRequest, School, User } from "@/types"

const authStore = useAuthStore()
const router = useRouter()
const formValidationErrors = useFormValidationErrorsStore()
const { kecamatanList, fetchKecamatan } = useKecamatan()
const { loadingUpdateSekolah, updateSekolahProfile } = useUpdateSekolahProfile()

const allowedRoles = ["sekolah", "verifikator_sekolah"]

const sekolahData = computed<School | null>(() => {
	const data = authStore.biodata as unknown as School | null
	return data ?? null
})

const accountInfo = computed<User | null>(() => authStore.user as User | null)

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
})

const hasError = (field: string) => Boolean(formValidationErrors.errors[field]?.length)

const syncForm = (data: School | null) => {
	if (!data) return
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
}

const fetchMySchool = async () => {
	try {
		const { data } = await requestor.get(ENDPOINTS.ME_SEKOLAH)
		if (data.success) {
			authStore.biodata = data.data as any
			syncForm(data.data as School)
		}
	} catch (error) {
		console.error("Gagal memuat data sekolah", error)
	}
}

const submitForm = async () => {
	const payload: ProfileSekolahRequest = {
		nama_sekolah: form.nama_sekolah,
		nss: form.nss,
		npsn: form.npsn,
		jenjang: form.jenjang,
		alamat: form.alamat,
		no_telp: form.no_telp,
		email: form.email,
		nama_kepsek: form.nama_kepsek,
		kecamatan_id: form.kecamatan_id,
	}

	if (form.daya_tampung !== "") {
		payload.daya_tampung = Number(form.daya_tampung)
	}

	const sukses = await updateSekolahProfile(payload)
	if (sukses) {
		showToast({ message: "Data sekolah berhasil diperbarui" })
		await fetchMySchool()
	} else {
		showToast({ message: "Gagal memperbarui data sekolah", type: "error" })
	}
}

watch(
	() => sekolahData.value,
	(newVal) => {
		syncForm(newVal)
	},
	{ immediate: true },
)

onMounted(async () => {
	if (!authStore.isLoggedIn()) {
		router.replace({ name: "login" })
		return
	}

	if (!allowedRoles.includes(authStore.role ?? "")) {
		router.replace({ name: "ppdbDashboard" })
		return
	}

	formValidationErrors.clearErrors()
	await fetchKecamatan()
	await fetchMySchool()
})

const formatValue = (value: string | number | null | undefined) => {
	if (value === null || value === undefined || value === "") return "-"
	return value
}
</script>

<template>
	<DefaultLayout>
		<div class="mx-auto max-w-4xl space-y-6">
			<BreadcrumbDefault pageTitle="Data Sekolah" />

			<div v-if="sekolahData" class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
				<div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
					<p class="text-xs font-semibold uppercase text-gray-500">Data Sekolah</p>
					<h2 class="text-2xl font-bold text-gray-900">{{ sekolahData.nama_sekolah }}</h2>
					<p class="text-sm text-gray-600">
						Jenjang {{ formatValue(sekolahData.jenjang) }}
						<span class="mx-2 text-gray-300">|</span>
						NPSN {{ formatValue(sekolahData.npsn) }}
					</p>
				</div>

				<div class="grid grid-cols-1 gap-6 px-6 py-6 md:grid-cols-2">
					<div class="space-y-1 rounded-md border border-gray-100 bg-gray-50 px-4 py-3">
						<p class="text-xs font-semibold uppercase text-gray-500">Nama Sekolah</p>
						<p class="text-sm font-semibold text-gray-900">{{ formatValue(sekolahData.nama_sekolah) }}</p>
					</div>
					<div class="space-y-1 rounded-md border border-gray-100 bg-gray-50 px-4 py-3">
						<p class="text-xs font-semibold uppercase text-gray-500">NSS</p>
						<p class="text-sm font-semibold text-gray-900">{{ formatValue(sekolahData.nss) }}</p>
					</div>
					<div class="space-y-1 rounded-md border border-gray-100 bg-gray-50 px-4 py-3">
						<p class="text-xs font-semibold uppercase text-gray-500">Kecamatan</p>
						<p class="text-sm font-semibold text-gray-900">{{ formatValue(sekolahData.kecamatan?.nama) }}</p>
					</div>
					<div class="space-y-1 rounded-md border border-gray-100 bg-gray-50 px-4 py-3">
						<p class="text-xs font-semibold uppercase text-gray-500">Alamat</p>
						<p class="text-sm font-semibold text-gray-900">{{ formatValue(sekolahData.alamat) }}</p>
					</div>
					<div class="space-y-1 rounded-md border border-gray-100 bg-gray-50 px-4 py-3">
						<p class="text-xs font-semibold uppercase text-gray-500">No. Telepon</p>
						<p class="text-sm font-semibold text-gray-900">{{ formatValue(sekolahData.no_telp) }}</p>
					</div>
					<div class="space-y-1 rounded-md border border-gray-100 bg-gray-50 px-4 py-3">
						<p class="text-xs font-semibold uppercase text-gray-500">Email Sekolah</p>
						<p class="text-sm font-semibold text-gray-900 break-words">{{ formatValue(sekolahData.email) }}</p>
					</div>
					<div class="space-y-1 rounded-md border border-gray-100 bg-gray-50 px-4 py-3">
						<p class="text-xs font-semibold uppercase text-gray-500">Kepala Sekolah</p>
						<p class="text-sm font-semibold text-gray-900">{{ formatValue(sekolahData.nama_kepsek) }}</p>
					</div>
					<div class="space-y-1 rounded-md border border-gray-100 bg-gray-50 px-4 py-3">
						<p class="text-xs font-semibold uppercase text-gray-500">Daya Tampung</p>
						<p class="text-sm font-semibold text-gray-900">{{ formatValue(sekolahData.daya_tampung) }}</p>
					</div>
				</div>
			</div>

			<div v-else class="rounded-lg border border-dashed border-gray-300 bg-white px-6 py-10 text-center text-gray-600">
				Data sekolah tidak tersedia. Silakan login ulang untuk memuat data terbaru.
			</div>

			<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
				<div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
					<p class="text-xs font-semibold uppercase text-gray-500">Akun</p>
					<h2 class="text-lg font-bold text-gray-900">Informasi Akun</h2>
				</div>
				<div class="grid grid-cols-1 gap-6 px-6 py-6 md:grid-cols-2">
					<div class="space-y-1">
						<p class="text-xs font-semibold uppercase text-gray-500">Username</p>
						<p class="text-sm font-semibold text-gray-900">{{ formatValue(accountInfo?.username) }}</p>
					</div>
					<div class="space-y-1">
						<p class="text-xs font-semibold uppercase text-gray-500">Email</p>
						<p class="text-sm font-semibold text-gray-900 break-words">{{ formatValue(accountInfo?.email) }}</p>
					</div>
					<div class="space-y-1">
						<p class="text-xs font-semibold uppercase text-gray-500">Role</p>
						<p class="text-sm font-semibold text-gray-900">{{ formatValue(authStore.role) }}</p>
					</div>
				</div>
			</div>

			<div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
				<div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
					<p class="text-xs font-semibold uppercase text-gray-500">Perbarui Data</p>
					<h2 class="text-lg font-bold text-gray-900">Edit Data Sekolah</h2>
				</div>
				<form class="space-y-6 px-6 py-6" @submit.prevent="submitForm">
					<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
						<InputGroup v-model="form.nama_sekolah" label="Nama Sekolah" name="nama_sekolah" required :error="hasError('nama_sekolah')" />
						<InputGroup v-model="form.nama_kepsek" label="Kepala Sekolah" name="nama_kepsek" required :error="hasError('nama_kepsek')" />
						<InputGroup v-model="form.nss" label="NSS" name="nss" inputmode="numeric" :error="hasError('nss')" />
						<InputGroup v-model="form.npsn" label="NPSN" name="npsn" inputmode="numeric" :error="hasError('npsn')" />
						<InputGroup v-model="form.jenjang" label="Jenjang" name="jenjang" required :error="hasError('jenjang')" />
						<InputGroup v-model="form.daya_tampung" label="Daya Tampung" name="daya_tampung" inputmode="numeric" :error="hasError('daya_tampung')" />
						<InputGroup v-model="form.no_telp" label="No. Telepon" name="no_telp" inputmode="tel" :error="hasError('no_telp')" />
						<InputGroup v-model="form.email" label="Email Sekolah" name="email" type="email" required :error="hasError('email')" />
						<InputGroup v-model="form.alamat" label="Alamat" name="alamat" required :error="hasError('alamat')" />
						<div class="flex flex-col gap-1">
							<label class="mb-1 block text-black">Kecamatan</label>
							<input
								disabled
								:value="kecamatanList.find((k) => String(k.id) === String(form.kecamatan_id))?.nama || '-'"
								class="w-full rounded border-[1.5px] border-stroke bg-gray px-2 py-2 text-black outline-none disabled:cursor-not-allowed disabled:bg-gray-100"
							/>
							<p class="text-xs text-gray-500">Hubungi admin untuk mengubah kecamatan.</p>
						</div>
					</div>

					<div class="flex flex-wrap items-center justify-end gap-3">
						<button type="submit" class="inline-flex items-center rounded bg-primary px-5 py-2 text-sm font-semibold text-white transition hover:bg-opacity-90 disabled:cursor-not-allowed disabled:opacity-70" :disabled="loadingUpdateSekolah">
							<span v-if="loadingUpdateSekolah" class="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
							Simpan Perubahan
						</button>
					</div>

					<div class="grid grid-cols-2 gap-3 text-sm text-red-600">
						<div v-html="field_error_html('nama_sekolah')"></div>
						<div v-html="field_error_html('nama_kepsek')"></div>
						<div v-html="field_error_html('nss')"></div>
						<div v-html="field_error_html('npsn')"></div>
						<div v-html="field_error_html('jenjang')"></div>
						<div v-html="field_error_html('daya_tampung')"></div>
						<div v-html="field_error_html('no_telp')"></div>
						<div v-html="field_error_html('email')"></div>
						<div v-html="field_error_html('alamat')"></div>
					</div>
				</form>
			</div>
		</div>
	</DefaultLayout>
</template>
