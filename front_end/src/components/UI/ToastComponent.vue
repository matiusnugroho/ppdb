<template>
	<div class="xl:w-1/6 md:w-1/4 sm:w-1/4 fixed top-3 left-1/2 -translate-x-1/2 flex flex-col gap-2 z-50 toast-container shadow-[rgba(13,_38,_76,_0.19)_0px_9px_20px]">
		<div class="flex w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg dark:text-gray-400 dark:bg-gray-800 items-center" role="alert">
			<div :class="iconContainerClasses">
				<FontAwesomeIcon :icon="icon" />
			</div>
			<div class="text-sm font-normal ml-3">{{ props.message }}</div>
			<button
				@click="close"
				aria-label="Close"
				class="border-none ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 justify-center items-center"
				type="button">
				<span class="sr-only">Close</span>
				<FontAwesomeIcon :icon="faXmark" />
			</button>
		</div>
	</div>
</template>

<script setup lang="ts">
import { defineProps, computed } from "vue"
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome"
import { faXmark } from "@fortawesome/free-solid-svg-icons"
import { faCheckCircle } from "@fortawesome/free-regular-svg-icons"
import { faCircleExclamation, faExclamationTriangle } from "@fortawesome/free-solid-svg-icons"

const props = defineProps<{
	message: string
	type: "success" | "error" | "warning"
}>()

const icon = computed(() => {
	switch (props.type) {
		case "success":
			return faCheckCircle
		case "error":
			return faCircleExclamation
		case "warning":
			return faExclamationTriangle
		default:
			return faCheckCircle
	}
})

const iconContainerClasses = computed(() => {
	switch (props.type) {
		case "success":
			return "inline-flex flex-shrink-0 justify-center items-center w-8 h-8 rounded-lg text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200"
		case "error":
			return "inline-flex flex-shrink-0 justify-center items-center w-8 h-8 rounded-lg text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200"
		case "warning":
			return "inline-flex flex-shrink-0 justify-center items-center w-8 h-8 rounded-lg text-yellow-500 bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-200"
		default:
			return "inline-flex flex-shrink-0 justify-center items-center w-8 h-8 rounded-lg text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200"
	}
})

const close = () => {
	const container = document.getElementById("toast-container")
	if (container) {
		document.body.removeChild(container)
	}
}
</script>

<style scoped>
.toast-container {
	z-index: 99999;
}
</style>
