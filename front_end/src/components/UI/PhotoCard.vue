<template>
	<article class="flex overflow-hidden rounded-xl bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg border border-gray-100">
		<!-- Content on the left -->
		<div class="flex-1 p-6">
			<p class="mb-2 text-xl font-bold text-gray-800">
				{{ nameText }}
			</p>
			<span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-600 mb-2">
				{{ role }}
			</span>
			<p class="text-xs font-medium text-gray-500 uppercase tracking-wide">
				{{ username }}
			</p>
		</div>

		<!-- Image on the right -->
		<div class="h-48 w-48 shrink-0">
			<img alt="" :src="photo_url || nopp" class="h-full w-full object-cover" />
		</div>
	</article>
</template>

<script lang="ts" setup>
import nopp from "@/assets/images/nopp.png"
defineProps({
	nameText: String,
	username: String,
	tanggal_lahir: String,
	photo_url: String,
	role: String,
})
</script>
