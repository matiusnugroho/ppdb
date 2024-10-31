<template>
	<li class="w-full">
		<router-link class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-[#666666] hover:text-gray-900 focus:outline-none focus:shadow-outline" :to="url">
			{{ name }}
		</router-link>
	</li>
</template>

<script setup lang="ts">
// Define props using defineProps from Vue
defineProps<{
	name: string
	url: string
}>()
</script>
