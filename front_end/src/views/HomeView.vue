<template>
	<HomeLayout>
		<section class="mb-8">
			<div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
				<!-- Image container - shown at top on mobile, right side on desktop -->
				<div class="mb-8 order-1 lg:order-2 lg:mb-0 lg:mt-0 lg:col-span-5 flex justify-center lg:justify-end">
					<GradeIllustration class="w-full h-auto text-blue-700" />
				</div>

				<!-- Content container - below image on mobile, left side on desktop -->
				<div class="order-2 lg:order-1 place-self-center lg:col-span-7">
					<h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">Selamat Datang di web PPDB Kuantan Singingi</h1>
					<p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
						Dengan PPDB, proses pendaftaran sekolah kini lebih mudah dan cepat. Ayo daftarkan sekolah Anda atau daftar sebagai calon siswa.
					</p>
					<div class="flex flex-wrap gap-3">
						<router-link
							to="/sekolah/daftar"
							class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
							Daftarkan sekolah
							<svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
								<path
									fill-rule="evenodd"
									d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
									clip-rule="evenodd"></path>
							</svg>
						</router-link>
						<router-link
							to="/daftar"
							class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
							Daftar
						</router-link>
					</div>
				</div>
			</div>
		</section>
		<section class="bg-gray-50 dark:bg-gray-800 py-8 w-full">
			<div class="flex justify-center w-full">
				<div class="rounded-lg shadow-lg bg-white w-full max-w-screen-xl mx-auto">
					<a href="https://youtu.be/YE7VzlLtp-4" target="_blank">
						<iframe
							class="w-full rounded-t-lg h-60 sm:h-80 md:h-96"
							src="https://www.youtube.com/embed/YE7VzlLtp-4"
							title="YouTube video player"
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
	</HomeLayout>
</template>


<script setup lang="ts">
import GradeIllustration from "@/components/Illustration/GradeIllustration.vue"
import HomeLayout from "@/layouts/HomeLayout.vue"

</script>
