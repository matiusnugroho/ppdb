<template>
	<span v-if="loading" :class="['loading', 'loading-spinner', spinnerSize]"></span>
</template>

<script setup lang="ts">
import { computed } from "vue"

const props = defineProps({
	loading: {
		type: Boolean,
		default: false,
	},
	size: {
		type: String,
		default: "md",
		validator: (value: string) => ["xs", "sm", "md", "lg"].includes(value),
	},
})

const spinnerSize = computed(() => `loading-${props.size}`)
</script>
