<template>
	<div v-if="loadingDocumentType" class="text-center mb-5">
		<div>Loading</div>
	</div>
	<AlertSuccess v-if="messagesStore.messages.success" class="mb-5" :message="messagesStore.messages.success.title as string" :detail="messagesStore.messages.success.detail as string" />
	
    <!-- New Layout -->
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white font-display">Detail Pendaftaran</h2>
                <p class="text-base text-gray-500 mt-2">Informasi status dan kelengkapan berkas Anda.</p>
            </div>
            <div>
                <span 
                    class="px-5 py-2.5 rounded-full text-xs font-bold border tracking-wider uppercase flex items-center gap-2 shadow-sm"
                    :class="{
                        'bg-orange-50 text-orange-700 border-orange-100': registration.status === 'pending',
                        'bg-green-50 text-green-700 border-green-100': registration.status === 'diverifikasi',
                        'bg-red-50 text-red-700 border-red-100': registration.status === 'ditolak'
                    }"
                >
                    <HeroIcon name="clock" class="w-4 h-4" v-if="registration.status === 'pending'" />
                    <HeroIcon name="check-circle" class="w-4 h-4" v-else-if="registration.status === 'diverifikasi'" />
                    <HeroIcon name="x-circle" class="w-4 h-4" v-else />
                    STATUS: {{ registration.status?.toUpperCase() }}
                </span>
            </div>
        </div>

        <!-- Single Info Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 dark:bg-boxdark dark:border-strokedark">
            <div class="flex flex-col md:flex-row md:items-center gap-8">
                <!-- School Info (Left) -->
                <div class="flex-1 flex items-start gap-5">
                    <div class="bg-indigo-50 p-3.5 rounded-2xl text-indigo-600 shrink-0">
                         <HeroIcon name="building-office-2" class="w-8 h-8" />
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">SEKOLAH TUJUAN</p>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ registration.school?.nama_sekolah }}</h3>
                    </div>
                </div>

                <!-- Divider -->
                <div class="hidden md:block w-px h-24 border-r-2 border-dashed border-gray-200"></div>
                <div class="md:hidden w-full h-px border-b-2 border-dashed border-gray-200"></div>

                <!-- Registration No (Right) -->
                 <div class="md:w-1/3">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">NO. PENDAFTARAN</p>
                    <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-200 dark:bg-meta-4 dark:border-strokedark">
                         <span class="text-xl font-mono font-bold text-gray-900 tracking-wide dark:text-white flex-1 text-center">
                            {{ registration.registration_number }}
                         </span>
                         <button 
                            @click="copyRegistrationNumber"
                            class="p-2 hover:bg-white rounded-lg text-gray-400 hover:text-indigo-600 transition-all shadow-sm"
                            title="Salin Nomor"
                         >
                            <HeroIcon name="document-duplicate" class="w-5 h-5" />
                         </button>
                    </div>
                 </div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Berkas Persyaratan</h3>
                <span class="px-4 py-1.5 bg-gray-100 text-gray-600 rounded-full text-xs font-bold">{{ documentTypeList.length }} Dokumen</span>
            </div>

            <!-- List Header (Desktop) -->
            <div class="hidden md:grid grid-cols-12 gap-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">
                <div class="col-span-5">NAMA DOKUMEN</div>
                <div class="col-span-4 text-center">STATUS</div>
                <div class="col-span-3 text-right">AKSI</div>
            </div>

            <div class="space-y-3">
                <div 
                    v-for="(item, index) in documentTypeList" 
                    :key="index"
                    class="group bg-white rounded-xl border border-transparent shadow-sm hover:shadow-md hover:border-indigo-100 transition-all duration-200 dark:bg-boxdark dark:border-strokedark"
                >
                    <div class="p-4 md:px-6 md:py-5 grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <!-- Document Name -->
                        <div class="md:col-span-5">
                             <h4 class="font-semibold text-gray-900 dark:text-white text-base">{{ item.path_requirement?.document_type?.label }}</h4>
                             <p v-if="item.status === 'ditolak'" class="text-sm text-red-500 mt-1 flex items-center gap-1">
                                <HeroIcon name="exclamation-circle" class="w-4 h-4" />
                                {{ item.alasan }}
                             </p>
                        </div>

                        <!-- Status -->
                        <div class="md:col-span-4 flex justify-start md:justify-center">
                            <span 
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap capitalize"
                                :class="{
                                    'bg-yellow-50 text-yellow-600': item.status === 'menunggu verifikasi' || item.status === 'belum upload',
                                    'bg-green-50 text-green-600': item.status === 'diverifikasi',
                                    'bg-red-50 text-red-600': item.status === 'ditolak'
                                }"
                            >
                                <span class="w-1.5 h-1.5 rounded-full" 
                                    :class="{
                                        'bg-yellow-400': item.status === 'menunggu verifikasi' || item.status === 'belum upload',
                                        'bg-green-500': item.status === 'diverifikasi',
                                        'bg-red-500': item.status === 'ditolak'
                                    }"
                                ></span>
                                {{ item.status === 'belum upload' ? 'Belum Upload' : item.status }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="md:col-span-3 flex items-center justify-end gap-3">
                             <!-- View Button -->
                            <a 
                                v-if="item.path"
                                :href="item.url_path ?? ''" 
                                target="_blank" 
                                class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                title="Lihat Dokumen"
                            >
                                <HeroIcon name="eye" class="w-5 h-5" />
                            </a>
                            <span v-else class="p-2 text-gray-300 cursor-not-allowed">
                                <HeroIcon name="eye" class="w-5 h-5" />
                            </span>

                            <!-- Upload Button -->
                            <button
                                v-if="item.status !== 'diverifikasi'"
                                @click="openUploadModal(item.id, item.status === 'ditolak' ? 'revisi' : 'upload')"
                                class="flex items-center gap-2 px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all shadow-indigo-200 hover:shadow-indigo-300 shadow-sm text-sm font-bold min-w-[100px] justify-center"
                            > 
                                <HeroIcon name="arrow-up-tray" class="w-4 h-4" />
                                {{ item.status === 'ditolak' ? 'Revisi' : 'Upload' }}
                            </button>
                            <div v-else class="min-w-[100px] flex justify-center items-center gap-2 text-green-600 font-bold text-sm bg-green-50 px-3 py-2 rounded-lg border border-green-100">
                                <HeroIcon name="check-circle" class="w-5 h-5" />
                                <span>Verified</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<UploadModal
		:show="showModal"
		:title="modeDokumen === 'upload' ? 'Upload Dokumen' : 'Revisi Dokumen'"
		:subtitle="`Lampirkan file untuk ${selectedType}`"
		:loading="loadingUploadDokumen"
		@close="closeUploadModal"
		@upload="handleUploadFile"
	/>
</template>

<script setup lang="ts">
import { useDocumentType } from "@/composable/useDocumentType"
import { onMounted, ref } from "vue"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import { showToast } from "@/utils/ui/toast"
import { useUploadDokumen } from "@/composable/useUploadDokumen"
import type { Document, DokumenRequest } from "@/types"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { useMessagesStore } from "@/stores/messages"
import AlertSuccess from "../Alerts/AlertSuccess.vue"
import UploadModal from "@/components/UI/UploadModal.vue"

const props = defineProps({
	registration: {
		type: Object,
		required: true,
	},
})

const { fetchDocumentType, loadingDocumentType, documentTypeList } = useDocumentType()
const messagesStore = useMessagesStore()

const showModal = ref(false)
const document_id = ref<null | string>()
const selectedType = ref<null | string>(null)
const formValidationErrors = useFormValidationErrorsStore()
const modeDokumen = ref<"upload" | "revisi">("upload")

function getDocumentById(documents: Document[], id: string) {
	return documents.find((doc) => doc.id === id)
}

const { uploadDokumen, loadingUploadDokumen } = useUploadDokumen()

const openUploadModal = (doc_id: string, mode: "upload" | "revisi" = "upload") => {
	formValidationErrors.clearErrors()
	modeDokumen.value = mode
	document_id.value = null
	
    // Show the modal
    showModal.value = true
    
    document_id.value = doc_id
    let doc = getDocumentById(documentTypeList.value, doc_id)
    selectedType.value = doc!.path_requirement?.document_type?.label!
}

const copyRegistrationNumber = () => {
    if (props.registration.registration_number) {
        navigator.clipboard.writeText(props.registration.registration_number)
        showToast({
            message: "Nomor pendaftaran telah dicopy",
            type: "success"
        })
    }
}

const handleUploadFile = async (file: File) => {
	if (!file) {
		showToast({
			message: "File tidak boleh kosong",
			type: "error",
		})
		return
	}
	const data: DokumenRequest = {
		id_dokumen: document_id.value!,
		file: file,
	}
	const response = await uploadDokumen(data, modeDokumen.value)
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
	} else {
        // Do not close on error, usually
		// closeUploadModal()
		showToast({
			message: "Dokumen gagal diupload, " + response.message,
			type: "error",
		})
	}
}

const closeUploadModal = () => {
    showModal.value = false
}
onMounted(async () => {
	await fetchDocumentType()
})

</script>
