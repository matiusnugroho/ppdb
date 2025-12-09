<template>
	<article class="flex items-center gap-4 rounded-xl border border-gray-100 bg-white p-4 md:p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
		<span class="rounded-full p-3" :class="`text-${color}-600 bg-${color}-50`">
			<HeroIcon :name="icon!" size="18" class="h-6 w-6" />
		</span>

		<div>
			<p class="text-2xl md:text-3xl font-bold text-gray-800">{{ value }}</p>
			<p class="text-sm font-medium text-gray-500">{{ label }}</p>
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
