<template>
	<dialog ref="modalRef" class="modal" @close="handleClose">
		<div class="modal-box w-11/12 max-w-4xl">
			<form method="dialog">
				<button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click="handleClose">✕</button>
			</form>
			
			<h3 class="font-bold text-lg mb-6 border-b pb-2">Tambah Sekolah Baru</h3>

			<form @submit.prevent="handleSubmit" class="space-y-4">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
					<!-- School Info -->
					<div class="col-span-1 md:col-span-2">
						<h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Informasi Sekolah</h4>
					</div>

					<div class="mb-3">
						<InputGroup label="Nama Sekolah" name="nama_sekolah" v-model="form.nama_sekolah" :error="hasError('nama_sekolah')" placeholder="Contoh: SDN 1 Teluk Kuantan" required />
						<div v-html="field_error_html('nama_sekolah')"></div>
					</div>

					<div class="mb-3">
						<SearchableSelect label="Jenjang" :options="jenjangOptions" v-model="form.jenjang" :error="hasError('jenjang')" placeholder="Pilih Jenjang" required />
						<div v-html="field_error_html('jenjang')"></div>
					</div>

					<div class="mb-3">
						<InputGroup label="NSS" name="nss" v-model="form.nss" :error="hasError('nss')" placeholder="Nomor Statistik Sekolah" inputmode="numeric" required />
						<div v-html="field_error_html('nss')"></div>
					</div>

					<div class="mb-3">
						<InputGroup label="NPSN" name="npsn" v-model="form.npsn" :error="hasError('npsn')" placeholder="Nomor Pokok Sekolah Nasional" inputmode="numeric" required />
						<div v-html="field_error_html('npsn')"></div>
					</div>

					<div class="mb-3">
						<InputGroup label="Nama Kepala Sekolah" name="nama_kepsek" v-model="form.nama_kepsek" :error="hasError('nama_kepsek')" placeholder="Nama Lengkap dengan Gelar" required />
						<div v-html="field_error_html('nama_kepsek')"></div>
					</div>

					<div class="mb-3">
						<SearchableSelect label="Kecamatan" :options="kecamatanOptionsComputed" v-model="form.kecamatan_id" :error="hasError('kecamatan_id')" placeholder="Pilih Kecamatan" required />
						<div v-html="field_error_html('kecamatan_id')"></div>
					</div>

					<div class="mb-3">
						<InputGroup label="No. Telepon" name="no_telp" v-model="form.no_telp" :error="hasError('no_telp')" placeholder="Nomor Telepon / HP" inputmode="tel" required />
						<div v-html="field_error_html('no_telp')"></div>
					</div>

					<div class="mb-3">
						<InputGroup label="Email Sekolah" name="email" type="email" v-model="form.email" :error="hasError('email')" placeholder="email@sekolah.sch.id" required />
						<div v-html="field_error_html('email')"></div>
					</div>

					<div class="col-span-1 md:col-span-2 mb-3">
						<TextAreaGroup label="Alamat" name="alamat" v-model="form.alamat" :error="hasError('alamat')" placeholder="Alamat lengkap sekolah..." :rows="3" required />
						<div v-html="field_error_html('alamat')"></div>
					</div>

					<!-- Account Info -->
					<div class="col-span-1 md:col-span-2 mt-4 pt-4 border-t">
						<h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Akun Pengguna</h4>
					</div>

					<div class="mb-3">
						<InputGroup label="Username" name="username" v-model="form.username" :error="hasError('username')" placeholder="Username untuk login" required />
						<div v-html="field_error_html('username')"></div>
					</div>

					<div class="mb-3">
						<InputGroup label="Password" name="password" type="password" v-model="form.password" :error="hasError('password')" placeholder="Password login" required />
						<div v-html="field_error_html('password')"></div>
					</div>
				</div>

				<div class="modal-action">
					<button type="button" class="btn" @click="handleClose">Batal</button>
					<button type="submit" class="btn btn-primary" :disabled="isSubmitting">
						<span v-if="isSubmitting" class="loading loading-spinner loading-xs"></span>
						{{ isSubmitting ? "Menyimpan..." : "Simpan Sekolah" }}
					</button>
				</div>
			</form>
		</div>
	</dialog>
</template>

<script setup lang="ts">
import { ref, computed, watch, onMounted } from "vue"
import InputGroup from "@/components/Forms/InputGroup.vue"
import TextAreaGroup from "@/components/Forms/TextAreaGroup.vue"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"
import { useKecamatan } from "@/composable/useKecamatan"
import { useSekolah } from "@/composable/useSekolah"
import jenjangData from "@/config/jenjang"
import { buatOption } from "@/helpers/buatOption"
import { showToast } from "@/utils/ui/toast"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { hasError } from "@/helpers/hasError"
import { field_error_html } from "@/helpers/fieldErrorHtml"

const props = defineProps({
	isOpen: {
		type: Boolean,
		required: true,
	},
})

const emit = defineEmits(["close", "success"])

const modalRef = ref<HTMLDialogElement | null>(null)
const { kecamatanList, fetchKecamatan } = useKecamatan()
const { createSekolah } = useSekolah()
const formValidationErrors = useFormValidationErrorsStore()

const isSubmitting = ref(false)
const errors = ref<Record<string, string[]>>({})

const form = ref({
	nama_sekolah: "",
	nss: "",
	npsn: "",
	jenjang: "",
	alamat: "",
	no_telp: "",
	email: "",
	nama_kepsek: "",
	kecamatan_id: "",
	username: "",
	password: "",
})

const jenjangOptions = jenjangData
const kecamatanOptionsComputed = computed(() => {
	return buatOption(kecamatanList.value, "nama", "id")
})

const getError = (field: string) => {
	// Simple check, or map array from backend to string
	return errors.value[field]?.[0]
}

const resetForm = () => {
	form.value = {
		nama_sekolah: "",
		nss: "",
		npsn: "",
		jenjang: "",
		alamat: "",
		no_telp: "",
		email: "",
		nama_kepsek: "",
		kecamatan_id: "",
		username: "",
		password: "",
	}
	formValidationErrors.clearErrors()
    errors.value = {}
}

const handleClose = () => {
	emit("close")
}

const handleSubmit = async () => {
	isSubmitting.value = true
    formValidationErrors.clearErrors()
	errors.value = {}

	try {
        // Validation could be added here, but relying on backend primarily + HTML required
		const result = await createSekolah(form.value)

		if (result.success) {
			showToast({ message: "Sekolah berhasil ditambahkan", type: "success" })
			resetForm()
			emit("success")
			emit("close")
		} else {
            // Handle error
            const err = result.error
            if (typeof err === 'object' && err !== null) {
                showToast({ message: "Gagal menyimpan data sekolah. Periksa inputan.", type: "error" })
            } else {
			    showToast({ message: typeof err === 'string' ? err : "Gagal menyimpan data", type: "error" })
            }
		}
	} catch (error) {
		showToast({ message: "Terjadi kesalahan sistem", type: "error" })
		console.error(error)
	} finally {
		isSubmitting.value = false
	}
}

watch(
	() => props.isOpen,
	(newVal) => {
		if (newVal) {
			modalRef.value?.showModal()
            fetchKecamatan() // Ensure data is ready
		} else {
			modalRef.value?.close()
		}
	}
)

onMounted(() => {
    // If mounted with open true
    if (props.isOpen) {
        modalRef.value?.showModal()
        fetchKecamatan()
    }
})
</script>
