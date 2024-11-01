<script setup lang="ts">
import SpinnerLoading from "@/components/UI/SpinnerLoading.vue"
</script>

<template>
	<div class="rounded border-blue-500 bg-blue-50 p-4 flex justify-center items-center">
		<span class="mr-2">
			<SpinnerLoading size="lg" :loading="true" />
		</span>
	</div>
</template>
