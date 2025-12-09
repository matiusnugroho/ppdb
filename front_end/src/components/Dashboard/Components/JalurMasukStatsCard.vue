<template>
	<div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 h-full flex flex-col">
		<div class="flex items-center justify-between mb-6">
			<div class="flex items-center gap-3">
				<HeroIcon name="map-pin" class="text-gray-400 w-6 h-6" />
				<h3 class="font-bold text-gray-800 text-lg">Statistik Jalur Masuk</h3>
			</div>
			<button class="text-sm font-bold text-blue-600 hover:underline">Lihat Detail</button>
		</div>

		<!-- Grid Cards -->
		<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
			<div v-for="(count, jalur) in data" :key="jalur" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
				<div class="mb-3 text-purple-600">
					<!-- Icons based on jalur name logic could go here, simplicity for now -->
					<HeroIcon v-if="String(jalur).toLowerCase().includes('zonasi')" name="map-pin" class="w-6 h-6" />
					<HeroIcon v-else-if="String(jalur).toLowerCase().includes('afirmasi')" name="heart" class="w-6 h-6 text-pink-500" />
					<HeroIcon v-else-if="String(jalur).toLowerCase().includes('prestasi')" name="star" class="w-6 h-6 text-yellow-500" />
					<HeroIcon v-else name="user-group" class="w-6 h-6 text-blue-500" />
				</div>
				<div class="text-3xl font-extrabold text-gray-800 mb-1">{{ count }}</div>
				<div class="text-xs font-bold text-gray-400 uppercase tracking-widest text-center">{{ jalur }}</div>
			</div>
		</div>

		<!-- Progress Bar -->
		<div class="mt-auto">
			<div class="flex justify-between items-center mb-2">
				<span class="text-xs font-bold text-gray-400 uppercase tracking-wider">DISTRIBUSI</span>
				<span class="text-xs font-bold text-gray-400">TOTAL: {{ total }}</span>
			</div>
			<div class="h-3 w-full bg-gray-100 rounded-full overflow-hidden flex">
				<div v-for="(count, jalur, index) in data" :key="jalur" 
					:style="{ width: getPercentage(count as number) + '%', backgroundColor: getColor(index as number) }"
					class="h-full"
				></div>
			</div>
			<!-- Legend -->
			<div class="flex flex-wrap gap-4 mt-4">
				<div v-for="(count, jalur, index) in data" :key="jalur" class="flex items-center gap-2">
					<div class="w-2 h-2 rounded-full" :style="{ backgroundColor: getColor(index as number) }"></div>
					<span class="text-xs font-medium text-gray-500">
						{{ jalur }} ({{ Math.round(getPercentage(count as number)) }}%)
					</span>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import HeroIcon from '@/components/Icon/HeroIcon.vue';
import { computed } from 'vue';

const props = defineProps<{
	data: { [key: string]: number };
}>();

const total = computed(() => {
	return Object.values(props.data).reduce((acc, curr) => acc + (curr as number), 0);
});

const getPercentage = (val: number) => {
	if (total.value === 0) return 0;
	return (val / total.value) * 100;
};

const colors = ['#6366f1', '#ec4899', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b'];
const getColor = (index: number) => colors[index % colors.length];

</script>
