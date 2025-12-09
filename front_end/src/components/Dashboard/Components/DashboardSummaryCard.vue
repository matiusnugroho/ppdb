<template>
	<div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 flex flex-col justify-between h-full relative overflow-hidden">
		<!-- Decorative Circle -->
		<div class="absolute -top-6 -right-6 h-24 w-24 rounded-full opacity-30" :class="bgClass"></div>

		<div>
			<div class="flex items-center gap-3 mb-4">
				<span class="rounded-lg p-2" :class="iconClass">
					<slot name="icon"></slot>
				</span>
				<h3 class="font-bold text-gray-500 uppercase tracking-wider text-xs">{{ title }}</h3>
			</div>
			
			<div class="text-4xl font-extrabold text-gray-800 mb-4">
				{{ value }}
			</div>
		</div>

		<div v-if="tagLabel" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium w-fit" :class="tagClass">
			<slot name="tag-icon"></slot>
			{{ tagLabel }}
		</div>
	</div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
	title: string;
	value: number | string;
	variant: 'blue' | 'green' | 'red';
	tagLabel?: string;
}>();

const bgClass = computed(() => {
	switch (props.variant) {
		case 'blue': return 'bg-blue-100 text-blue-600';
		case 'green': return 'bg-green-100 text-green-600';
		case 'red': return 'bg-red-100 text-red-600';
		default: return 'bg-gray-100 text-gray-600';
	}
});

const iconClass = computed(() => {
	switch (props.variant) {
		case 'blue': return 'bg-blue-50 text-blue-600 border border-blue-100';
		case 'green': return 'bg-green-50 text-green-600 border border-green-100';
		case 'red': return 'bg-red-50 text-red-600 border border-red-100';
		default: return 'bg-gray-50 text-gray-600';
	}
});

const tagClass = computed(() => {
	switch (props.variant) {
		case 'blue': return 'bg-blue-50 text-blue-600';
		case 'green': return 'bg-green-50 text-green-700';
		case 'red': return 'bg-red-50 text-red-600';
		default: return 'bg-gray-50 text-gray-600';
	}
});
</script>
