<template>
	<div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 transition-opacity">
		<div class="w-full max-w-lg bg-white rounded-xl shadow-lg transform transition-all p-6">
			<!-- Header -->
			<div class="flex justify-between items-start mb-4">
				<div>
					<h3 class="text-xl font-bold text-gray-900">{{ title }}</h3>
					<p class="text-sm text-gray-500 mt-1">{{ subtitle }}</p>
				</div>
				<button @click="close" class="text-gray-400 hover:text-gray-600 transition-colors">
					<HeroIcon name="x-mark" class="w-6 h-6" />
				</button>
			</div>

			<!-- Dropzone -->
			<div
				class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:bg-gray-50 transition-colors"
				:class="{ 'border-primary bg-blue-50': isDragging }"
				@dragenter.prevent="isDragging = true"
				@dragleave.prevent="isDragging = false"
				@dragover.prevent
				@drop.prevent="handleDrop"
			>
				<input
					type="file"
					ref="fileInputRef"
					class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
					@change="handleFileSelect"
					accept=".pdf,.jpg,.jpeg,.png"
				/>
				
				<div class="flex flex-col items-center justify-center pointer-events-none">
					<div class="bg-blue-100 p-3 rounded-full mb-3 text-blue-600">
						<HeroIcon name="cloud-arrow-up" class="w-8 h-8" />
					</div>
					
					<div v-if="selectedFile" class="text-center">
						<p class="text-gray-900 font-medium break-all">{{ selectedFile.name }}</p>
						<p class="text-xs text-gray-500 mt-1">{{ formatFileSize(selectedFile.size) }}</p>
						<button @click.stop="removeFile" class="text-red-500 text-sm mt-2 hover:underline pointer-events-auto">Ganti File</button>
					</div>
					
					<div v-else class="text-center">
						<p class="text-gray-900 font-medium">
							<span class="text-gray-900">Klik untuk upload</span> 
							<span class="text-gray-500"> atau drag file</span>
						</p>
						<p class="text-xs text-gray-400 mt-2">PDF, JPG, atau PNG (Maks. 2MB)</p>
					</div>
				</div>
			</div>

			<!-- Footer -->
			<div class="flex justify-end items-center gap-3 mt-6">
				<button @click="close" class="px-4 py-2 text-gray-700 font-medium hover:bg-gray-100 rounded-lg transition-colors">
					Batal
				</button>
				<button 
					@click="upload" 
					:disabled="!selectedFile || loading"
					class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
				>
					<span v-if="loading" class="loading loading-spinner loading-xs"></span>
					Upload Sekarang
				</button>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import HeroIcon from '../Icon/HeroIcon.vue'

const props = defineProps({
	show: {
		type: Boolean,
		default: false
	},
	title: {
		type: String,
		default: 'Upload Dokumen'
	},
	subtitle: {
		type: String,
		default: 'Lampirkan file pendukung'
	},
	loading: {
		type: Boolean,
		default: false
	}
})

const emit = defineEmits(['close', 'upload'])

const isDragging = ref(false)
const selectedFile = ref<File | null>(null)
const fileInputRef = ref<HTMLInputElement | null>(null)

const close = () => {
	selectedFile.value = null
	if (fileInputRef.value) fileInputRef.value.value = ''
	emit('close')
}

const handleFileSelect = (event: Event) => {
	const input = event.target as HTMLInputElement
	if (input.files && input.files[0]) {
		selectedFile.value = input.files[0]
	}
}

const handleDrop = (event: DragEvent) => {
	isDragging.value = false
	if (event.dataTransfer?.files && event.dataTransfer.files[0]) {
		selectedFile.value = event.dataTransfer.files[0]
        // Sync with input if needed, though usually we just use the state
        // Manually setting files to input is tricky programmatically for security reasons,
        // so we stick to using the `selectedFile` state for the upload.
	}
}

const removeFile = () => {
	selectedFile.value = null
	if (fileInputRef.value) fileInputRef.value.value = ''
}

const upload = () => {
	if (selectedFile.value) {
		emit('upload', selectedFile.value)
	}
}

const formatFileSize = (bytes: number) => {
	if (bytes === 0) return '0 Bytes'
	const k = 1024
	const sizes = ['Bytes', 'KB', 'MB', 'GB']
	const i = Math.floor(Math.log(bytes) / Math.log(k))
	return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

watch(() => props.show, (newVal) => {
    if (!newVal) {
        selectedFile.value = null
        if (fileInputRef.value) fileInputRef.value.value = ''
    }
})
</script>
