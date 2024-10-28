<template>
	<div class="max-w-md mx-auto mt-10 p-5 bg-white rounded-lg shadow-md">
		<h1 class="text-xl font-bold mb-5 text-center">Pendaftaran</h1>
		<form @submit.prevent="handleSubmit">
			<div class="mb-4">
				<SearchableSelect required label="Pilih Kecamatan" placeholder="Pilih Kecmatan" :options="kecamatanOption" v-model="kecamatan_id" :loading="loadingKecamatan" />
				<div v-html="field_error_html('kecamatan_id')"></div>
			</div>
			<div class="mb-4">
				<SelectGroup label="Pilih Jenjang" placeholder="Pilih Jenjang" :options="jenjangOption" v-model="jenjang" />
				<div v-html="field_error_html('jenjang')"></div>
			</div>
			<div class="mb-4">
				<SearchableSelect label="Pilih Sekolah" placeholder="Pilih Sekolah" :options="sekolahOption" v-model="sekolah_id" :loading="loadingSekolah" />
				<div v-html="field_error_html('sekolah_id')"></div>
			</div>

			<button class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-white hover:bg-opacity-90" type="submit" :disabled="loadingRegister">
				<span class="flex items-center gap-2">
					<fwb-spinner
						v-if="loadingRegister"
						size="4"
						color="white"
						class="transition-all duration-500 ease-out"
						:class="{ 'opacity-0 -translate-x-5': !loadingRegister, 'opacity-100 translate-x-0': loadingRegister }" />Daftar
				</span>
			</button>
		</form>
	</div>
</template>
<script lang="ts" setup>
import { useKecamatan } from "@/composable/useKecamatan"
import { useSekolah } from "@/composable/useSekolah"
import { onMounted, ref, computed, watch } from "vue"
import type { Option } from "@/types"
import { buatOption } from "@/helpers/buatOption"
import SelectGroup from "../Forms/SelectGroup.vue"
import { FwbSpinner } from "flowbite-vue"
import { useDaftarKesekolah } from "@/composable/useDaftarKesekolah"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { field_error_html } from "@/helpers/fieldErrorHtml"
import { useMessagesStore } from "@/stores/messages"
import { showToast } from "@/utils/ui/toast"
import SearchableSelect from "@/components/Forms/SearchableSelect.vue"

const { fetchKecamatan, kecamatanList, loadingKecamatan } = useKecamatan()
const { fetchSekolah, sekolahList, loadingSekolah } = useSekolah()
const { loadingRegister, registerSekolah, errorDaftar } = useDaftarKesekolah()
const formValidationError = useFormValidationErrorsStore()
const emit = defineEmits(["refreshParent"])

const kecamatan_id = ref("")
const sekolah_id = ref("")
const jenjang = ref("")
const jenjangOption = ref<Option[]>([
	{ label: "Pilih Jenjang", value: null },
	{ label: "SD", value: "sd" },
	{ label: "SMP", value: "smp" },
])
const kecamatanOption = computed<Option[]>(() => {
	return buatOption(kecamatanList.value, "nama", "id")
})
const sekolahOption = computed<Option[]>(() => {
	return buatOption(sekolahList.value, "nama_sekolah", "id")
})
const messageStore = useMessagesStore()
const handleSubmit = async () => {
	formValidationError.clearErrors()
	if (!kecamatan_id.value || !sekolah_id.value || !jenjang.value) {
		// Add error messages for missing fields
		if (!kecamatan_id.value) formValidationError.addError("kecamatan_id", "Pilih Kecamatan terlebih dahulu")
		if (!sekolah_id.value) formValidationError.addError("sekolah_id", "Pilih Sekolah terlebih dahulu")
		if (!jenjang.value) formValidationError.addError("jenjang", "Pilih Jenjang terlebih dahulu")
		return
	}
	const data = {
		school_id: sekolah_id.value,
		jenjang: jenjang.value,
	}
	const registerResponse = await registerSekolah(data)
	console.log({ registerResponse })
	if (registerResponse.data.success) {
		messageStore.addMessage("success", {
			title: "Pendaftaran Berhasil",
			detail: "Silakan Lengkapi dokumen",
		})
		emit("refreshParent", registerResponse.data.data)
	} else {
		console.log(errorDaftar.value, "errrrrrrr")
		showToast({
			message: "Pendaftaran gagal, " + errorDaftar.value,
			type: "error",
		})
	}
}
watch(kecamatan_id, (newKecamatanId) => {
	if (newKecamatanId) {
		fetchSekolah(newKecamatanId, jenjang.value)
	}
})
watch(jenjang, (newJenjang) => {
	if (newJenjang) {
		sekolah_id.value = ""
		fetchSekolah(kecamatan_id.value, newJenjang)
	}
})
onMounted(() => {
	fetchKecamatan()
})
</script>
