<template>
	<dialog ref="modal" class="modal">
		<div class="modal-box" v-on-click-outside="handleClickOutside">
			<form method="dialog">
				<button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click="closeModal">✕</button>
			</form>

			<div class="flex flex-col items-center">
				<!-- Centering container -->
				<p class="py-4 text-warning text-3xl font-bold">
					<HeroIcon name="circle-exclamation" size="48" class="text-warning" />
				</p>
				<h3 class="text-lg font-bold text-center">{{ title }}</h3>
				<p class="py-4 text-center">{{ message }}</p>
			</div>

			<!-- Buttons: Confirm and Cancel -->
			<div class="modal-action justify-center">
				<button class="btn" @click="handleCancel">{{ cancelLabel }}</button>
				<!-- Confirm Button with Loading State -->
				<button class="btn btn-primary" :disabled="loading" @click="handleConfirm">
					<SpinnerLoading :loading="loading" size="xs" />
					<span>{{ confirmLabel }}</span>
				</button>
			</div>
		</div>
	</dialog>
</template>

<script setup lang="ts">
import { ref } from "vue"
import SpinnerLoading from "@/components/UI/SpinnerLoading.vue"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import { vOnClickOutside } from "@vueuse/components"
const modal = ref<HTMLDialogElement | null>(null)

// Props for dynamic content and actions
const props = defineProps({
	title: {
		type: String,
		default: "Hello!",
	},
	message: {
		type: String,
		default: "Press ESC key or click on ✕ button to close.",
	},
	confirmLabel: {
		type: String,
		default: "Confirm",
	},
	cancelLabel: {
		type: String,
		default: "Cancel",
	},
	confirmHandler: {
		type: Function,
		default: () => {
			alert("Confirmed")
		},
	},
	cancelHandler: {
		type: Function,
		default: () => {
			alert("Cancelled")
		},
	},
	loading: {
		type: Boolean,
		default: false,
	},
	closeOnClickOutside: {
		type: Boolean,
		default: false,
	},
})
const show = () => {
	modal.value?.showModal()
}

const close = () => {
	modal.value?.close()
}

defineExpose({ show, close })
const closeModal = () => {
	modal.value!.close()
}

// Call the confirm handler passed via props
const handleConfirm = () => {
	if (!props.loading) {
		props.confirmHandler()
		closeModal() // Optionally close the modal after confirmation
	}
}
const handleCancel = () => {
	props.cancelHandler()
	closeModal()
}

const handleClickOutside = (event: Event) => {
	console.log("Clicked outside")
	const target = event.target as HTMLElement
	console.log(target)
	if (props.closeOnClickOutside && modal.value?.open && !target.closest(".modal-box")) {
		closeModal()
	}
}
</script>
