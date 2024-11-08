<template>
	<section class="flex max-h-[calc(100vh-4rem)] min-h-[calc(100vh-4rem)] lg:min-h-0 mb-2">
		<div class="grid max-w-screen-xl px-4 py-4 sm:py-6 lg:py-8 mx-auto mb-4 lg:mb-8 lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
			<!-- Image container - reduced padding/margin on mobile -->
			<div class="mb-4 sm:mb-6 lg:mb-0 order-1 lg:order-2 lg:mt-0 lg:col-span-5 flex justify-center lg:justify-end">
				<GradeIllustration class="w-full h-auto text-blue-700" />
			</div>

			<!-- Content container - adjusted spacing -->
			<div class="order-2 lg:order-1 place-self-center lg:col-span-7">
				<h1 class="max-w-2xl mb-2 sm:mb-4 text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-800 leading-none md:text-5xl xl:text-6xl dark:text-white">
					Selamat Datang di web PPDB Kuantan Singingi
				</h1>
				<p class="max-w-2xl mb-4 sm:mb-6 font-light text-gray-600 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
					Dengan PPDB, proses pendaftaran sekolah kini lebih mudah dan cepat. Ayo daftarkan sekolah Anda atau daftar sebagai calon siswa.
				</p>
				<div class="flex flex-wrap gap-3">
					<router-link
						to="/daftar"
						class="inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-3 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
						Daftar
						<svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<path
								fill-rule="evenodd"
								d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
								clip-rule="evenodd"></path>
						</svg>
					</router-link>
				</div>
			</div>
		</div>
	</section>
	<section class="bg-gray-50 dark:bg-gray-800 py-8 w-full">
		<div class="flex justify-center w-full">
			<div class="rounded-lg shadow-lg bg-white w-full max-w-screen-xl mx-auto">
				<a :href="ytURL as string" target="_blank">
					<iframe
						class="w-full rounded-t-lg h-60 sm:h-80 md:h-96"
						:src="ytURL as string"
						title="Tutorial PPDB Kuantan Singingi"
						frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
						allowfullscreen>
					</iframe>
				</a>
				<div class="p-6">
					<h5 class="text-gray-900 text-xl font-medium mb-2">Video Tutorial Penggunaan web PPDB</h5>
				</div>
			</div>
		</div>
	</section>
</template>

<script setup lang="ts">
import GradeIllustration from "@/components/Illustration/GradeIllustration.vue"
import { useSetting } from "@/composable/useSetting"
import { onMounted } from "vue"

const { settingData, fetchSetting, ytURL } = useSetting()

onMounted(async () => {
	await fetchSetting()
})
</script>
