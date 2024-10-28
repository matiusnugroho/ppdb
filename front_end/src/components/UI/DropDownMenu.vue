<template>
	<li class="relative w-full" @mouseover="openDropdown" @mouseleave="closeDropdown">
		<a class="flex items-center justify-between md:px-4 py-2 text-sm bg-transparent rounded-lg text-[#666666] hover:text-gray-900 focus:outline-none focus:shadow-outline">
			{{ title }}
			<svg class="w-2.5 h-2.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
			</svg>
		</a>

		<!-- Dropdown menu -->
		<div v-if="isOpen" class="z-10 font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute">
			<ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
				<li v-for="(item, index) in items" :key="index">
					<a :href="item.url" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
						{{ item.label }}
					</a>
				</li>
			</ul>
		</div>
	</li>
</template>

<script setup lang="ts">
import { ref, defineProps } from "vue"

// Define props for the component
defineProps<{
	title: string
	items: Array<{ label: string; url: string }>
}>()

// State to manage the dropdown's open/closed state
const isOpen = ref(false)

// Open and close the dropdown
const openDropdown = () => {
	isOpen.value = true
}

const closeDropdown = () => {
	isOpen.value = false
}
</script>

<style scoped>
/* Additional styles if needed */
</style>
