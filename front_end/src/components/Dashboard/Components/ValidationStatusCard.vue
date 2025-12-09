<template>
	<div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-100 h-full flex flex-col">
		<div class="flex items-center gap-3 mb-6">
			<HeroIcon name="document-text" class="text-gray-400 w-6 h-6" />
			<h3 class="font-bold text-gray-800 text-lg">Status Validasi</h3>
		</div>

		<div class="space-y-4 flex-grow">
			<!-- Pending -->
			<div class="flex items-center justify-between p-4 rounded-xl bg-orange-50 border border-orange-100">
				<div class="flex items-center gap-3">
					<div class="p-2 bg-white rounded-full text-orange-500 shadow-sm">
						<HeroIcon name="clock" class="w-5 h-5" />
					</div>
					<div>
						<div class="font-bold text-gray-800">Pending</div>
						<div class="text-xs text-gray-500">Menunggu cek</div>
					</div>
				</div>
				<div class="text-xl font-bold text-gray-800">{{ pending }}</div>
			</div>

			<!-- Valid -->
			<div class="flex items-center justify-between p-4 rounded-xl bg-blue-50 border border-blue-100">
				<div class="flex items-center gap-3">
					<div class="p-2 bg-white rounded-full text-blue-600 shadow-sm">
						<HeroIcon name="document-check" class="w-5 h-5" />
					</div>
					<div>
						<div class="font-bold text-gray-800">Valid</div>
						<div class="text-xs text-gray-500">Terverifikasi</div>
					</div>
				</div>
				<div class="text-xl font-bold text-gray-800">{{ valid }}</div>
			</div>

			<!-- Ditolak -->
			<div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 border border-gray-100">
				<div class="flex items-center gap-3">
					<div class="p-2 bg-white rounded-full text-gray-400 shadow-sm">
						<HeroIcon name="x-circle" class="w-5 h-5" />
					</div>
					<div>
						<div class="font-bold text-gray-500">Ditolak</div>
						<div class="text-xs text-gray-400">Data invalid</div>
					</div>
				</div>
				<div class="text-xl font-bold text-gray-500">{{ ditolak }}</div>
			</div>
		</div>

		<div class="mt-6">
			<RouterLink to="/pendaftaran" class="block w-full text-center py-3 rounded-xl border border-gray-200 font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-800 transition-colors">
				Kelola Data
			</RouterLink>
		</div>
	</div>
</template>

<script setup lang="ts">
import HeroIcon from '@/components/Icon/HeroIcon.vue';

defineProps<{
	pending: number;
	valid: number;
	ditolak: number;
}>();
</script>
