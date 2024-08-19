<template>
	<div v-html="iconContent" :style="{ width: size + 'px', height: size + 'px' }" :class="iconClass" />
</template>

<script setup lang="ts">
import { ref, watch, computed } from "vue"

const props = defineProps({
	size: {
		type: String,
		default: "24",
	},
	name: {
		type: String,
		required: true,
	},
	class: {
		type: String,
		default: "",
	},
})

const iconContent = ref("")

const icons = import.meta.glob("@/assets/icons/*.svg", { query: "?raw", import: "default" })

watch(
	() => props.name,
	async (newName) => {
		const iconKey = `/src/assets/icons/${newName}.svg`
		if (icons[iconKey]) {
			// Assert the type as string
			iconContent.value = (await icons[iconKey]()) as string
		} else {
			console.error(`Icon not found: ${newName}`)
			iconContent.value = "" // Clear content if icon not found
		}
	},
	{ immediate: true },
)

const iconClass = computed(() => props.class)
</script>
