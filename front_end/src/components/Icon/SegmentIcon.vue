<template>
	<svg :width="size" :height="size" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M4 6h16M4 12h16m-7 6h7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
	</svg>
</template>

<script setup lang="ts">
defineProps<{
	size?: number // Size prop for customization
}>()
</script>

<style scoped>
/* Optional: add any specific styles you want for your icon here */
svg {
	display: inline-block;
}
</style>
