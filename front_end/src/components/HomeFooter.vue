<template>
	<footer class="bg-gradient-to-r from-blue-300 to-blue-200">
		<div class="relative mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8 lg:pt-24">
			<div class="absolute end-4 top-4 sm:end-6 sm:top-6 lg:end-8 lg:top-8">
				<a
					class="inline-block rounded-full bg-blue-600 p-2 text-white shadow-lg transition-transform transform hover:bg-blue-500 hover:scale-110 sm:p-3 lg:p-4 cursor-pointer"
					@click.prevent="scrollToTop">
					<span class="sr-only">Ke atas</span>
					<svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
						<path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
					</svg>
				</a>
			</div>

			<div class="lg:flex lg:items-center lg:justify-between">
				<div class="flex items-center">
					<img :src="logoppdb" class="w-24 xl:w-28 mr-4" alt="Logo PPDB" />
					<p class="text-sm text-gray-600">&copy; 2024. Dinas Pendidikan Kabupaten Kuantan Singingi.</p>
				</div>
			</div>
		</div>
	</footer>
</template>

<script setup lang="ts">
import { useSmoothScrollToTop } from "@/composable/useSmoothScrollToTop"
import logoppdb from "@/assets/images/logo/logo-ppdb.png"

const { smoothScrollToTop } = useSmoothScrollToTop()

const scrollToTop = () => {
	console.log("Scrolling to top")
	smoothScrollToTop("#main-home")
}
</script>

<style scoped>
/* Additional styles for enhancement */
footer {
	border-top: 2px solid rgba(255, 255, 255, 0.2);
}
</style>
