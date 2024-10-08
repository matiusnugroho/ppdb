<template>
	<input type="file" ref="fileInput" class="file-input file-input-bordered file-input-sm w-full max-w-xs" />
</template>
<script setup lang="ts">
import { ref } from "vue"

const fileInput = ref<HTMLInputElement | null>(null)

defineExpose({ fileInput })
</script>
