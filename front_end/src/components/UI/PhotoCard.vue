<template>
	<article class="flex overflow-hidden rounded-2xl shadow-md transition hover:shadow-lg">
		<!-- Content on the left -->
		<div class="flex-1 p-4 bg-white sm:p-6">
			<p class="mb-2 text-lg font-medium text-gray-800">
				{{ nameText }}
			</p>
			<p class="mb-2 text-sm font-medium text-gray-600">
				{{ role }}
			</p>
			<p class="text-xs text-gray-400">
				{{ username }}
			</p>
		</div>

		<!-- Image on the right -->
		<img alt="" :src="photo_url || nopp" class="h-48 w-48 object-cover" />
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
