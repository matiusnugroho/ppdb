<template>
	<div v-if="loadingDocumentType" class="text-center mb-5">
		<div>Loading</div>
	</div>
	<AlertSuccess v-if="messagesStore.messages.success" class="mb-5" :message="messagesStore.messages.success.title as string" :detail="messagesStore.messages.success.detail as string" />
	<div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
		<div class="max-w-full overflow-x-auto">
			<table class="w-full table-auto">
				<tr>
					<td class="py-5 px-4">
						<h4 class="text-xl font-semibold text-black dark:text-white">Nama Sekolah</h4>
					</td>
					<td>:</td>
					<td class="py-5 px-4">
						<h4 class="text-xl font-semibold text-black dark:text-white">{{ registration.school.nama_sekolah }}</h4>
					</td>
				</tr>
				<tr>
					<td class="py-5 px-4">
						<h4 class="text-xl font-semibold text-black dark:text-white">Nomor Pendaftaran</h4>
					</td>
					<td>:</td>
					<td class="py-5 px-4">
						<h4 class="text-xl font-semibold text-black dark:text-white">{{ registration.registration_number }}</h4>
					</td>
				</tr>
				<tr>
					<td class="py-5 px-4 text-center" colspan="3">
						<p class="inline-flex rounded-full py-1 px-3 text-sm font-medium" :class="statusColorMap[registration.status]">{{ registration.status }}</p>
					</td>
				</tr>
			</table>
		</div>
		<div class="max-w-full overflow-x-auto">
			<table class="w-full table-auto">
				<thead>
					<tr class="bg-gray-2 text-left dark:bg-meta-4">
						<th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">Dokumen</th>
						<th class="min-w-[120px] py-4 px-4 font-medium text-black dark:text-white text-center">Status</th>
						<th class="py-4 px-4 font-medium text-black dark:text-white">Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item, index) in documentTypeList" :key="index">
						<td class="py-5 px-4 pl-9 xl:pl-11">
							<h5 class="font-medium text-black dark:text-white">{{ item.document_type!.label }}</h5>
						</td>
						<td class="text-center">
							<p class="inline-flex rounded-full py-1 px-3 text-sm font-medium" :class="statusColorMap[item.status]">{{ item.status }}</p>
						</td>
						<td class="py-5 px-4">
							<div class="flex items-center space-x-3.5">
								<div class="tooltip" data-tip="Lihat">
									<a :href="item.url_path ?? ''" class="flex items-center hover:text-primary" v-if="item.path" target="_blank" rel="noopener noreferrer">
										<HeroIcon name="view-finder" size="18" class="h-5 w-5" />
									</a>
									<span v-else class="cursor-not-allowed text-gray-400">
										<HeroIcon name="view-finder" size="18" class="h-5 w-5" />
									</span>
								</div>
								<div class="tooltip" data-tip="Upload">
									<button :disabled="item.status === 'diverifikasi'" class="flex items-center hover:text-primary" @click="openUploadModal(item.id)">
										<HeroIcon name="upload" size="18" class="h-5 w-5" />
									</button>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<dialog id="upload-modal" class="modal" ref="uploadModal">
		<div class="modal-box">
			<form method="dialog">
				<button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
			</form>
			<h3 class="text-lg font-bold">Upload {{ selectedType }}</h3>
			<InputFile ref="fileInput" />
			<button class="btn" @click="handleUploadDokumen"><span v-if="loadingUploadDokumen" class="loading loading-spinner loading-xs"></span> Upload</button>
			<div v-html="field_error_html('file')"></div>
		</div>
	</dialog>
</template>

<script setup lang="ts">
import { useDocumentType } from "@/composable/useDocumentType"
import { onMounted, ref } from "vue"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import InputFile from "@/components/Forms/InputFile.vue"
import { showToast } from "@/utils/ui/toast"
import { useUploadDokumen } from "@/composable/useUploadDokumen"
import type { Document, DokumenRequest } from "@/types"
import { field_error_html } from "@/helpers/fieldErrorHtml"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { useMessagesStore } from "@/stores/messages"
import AlertSuccess from "../Alerts/AlertSuccess.vue"
import statusColorMap from "@/config/statusColorMap"
const { fetchDocumentType, loadingDocumentType, documentTypeList } = useDocumentType()
const messagesStore = useMessagesStore()
const uploadModal = ref<null | HTMLDialogElement>(null)
const fileInput = ref<null | InstanceType<typeof InputFile>>(null)
const document_id = ref<null | string>()
const selectedType = ref<null | string>(null)
const formValidationErrors = useFormValidationErrorsStore()
function getDocumentById(documents: Document[], id: string) {
	return documents.find((doc) => doc.id === id)
}

const { uploadDokumen, loadingUploadDokumen } = useUploadDokumen()

const openUploadModal = (doc_id: string) => {
	formValidationErrors.clearErrors()
	if (fileInput.value && fileInput.value.fileInput) {
		fileInput.value.fileInput.value = "" // Reset the file input safely
	}
	document_id.value = null
	if (uploadModal.value) {
		uploadModal.value.showModal()
		document_id.value = doc_id
		let doc = getDocumentById(documentTypeList.value, doc_id)
		selectedType.value = doc!.document_type.label
	}
}

const handleUploadDokumen = async () => {
	const selectedFile = fileInput.value?.fileInput?.files?.[0]
	if (!selectedFile) {
		formValidationErrors.addError("file", "File tidak boleh kosong")
		showToast({
			message: "File tidak boleh kosong",
			type: "error",
		})
		return
	}
	const data: DokumenRequest = {
		id_dokumen: document_id.value!,
		file: selectedFile,
	}
	const response = await uploadDokumen(data)
	console.log({response})
	if (response.success) {
		let currentData = getDocumentById(documentTypeList.value, document_id.value!)
		let theData = response.data
		if (currentData) {
			currentData.status = theData.status
			currentData.path = theData.path
			currentData.url_path = theData.url_path
		}
		closeUploadModal()
		showToast({
			message: "Dokumen berhasil diupload",
			type: "success",
		})
	}
	else {
		closeUploadModal()
		showToast({
			message: "Dokumen gagal diupload, " + response.message,
			type: "error",
		})
	}
}
const closeUploadModal = () => {
	if (fileInput.value && fileInput.value.fileInput) {
		fileInput.value.fileInput.value = "" // Reset the file input safely
	}
	if (uploadModal.value) {
		uploadModal.value.close()
	}
}
onMounted(async () => {
	await fetchDocumentType()
})
defineProps({
	registration: {
		type: Object,
		required: true,
	},
})
</script>
