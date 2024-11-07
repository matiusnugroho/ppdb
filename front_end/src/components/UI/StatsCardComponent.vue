<template>
	<article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-1 md:p-6">
		<span class="rounded-full p-3" :class="`text-${color}-600 bg-${color}-100`">
			<HeroIcon :name="icon!" size="18" class="h-6 w-6" />
		</span>

		<div>
			<p class="text-xl md:text-2xl font-medium text-gray-900">{{ value }}</p>
			<p class="text-xs md:text-sm text-gray-500">{{ label }}</p>
		</div>
	</article>
</template>

<script setup lang="ts">
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import { type PropType } from "vue"

defineProps({
	icon: {
		type: String,
		default: "user-circle",
	},
	label: {
		type: String,
		default: "Info Label di sini",
	},
	value: {
		type: [String, Number, Object] as PropType<string | number | { [key: string]: number }>,
		default: "Info Value di sini",
	},
	color: {
		type: String,
		default: "red",
	},
})
</script>
