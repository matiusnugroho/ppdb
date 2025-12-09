<template>
	<div class="bg-gray-50 text-gray-700">
		<section class="relative bg-white min-h-screen flex items-center snap-start overflow-hidden pt-20">
			<!-- Background Decor -->
			<div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100/50 blur-3xl"></div>
			<div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-100/50 blur-3xl"></div>
			
			<div class="max-w-screen-xl mx-auto px-6 relative z-10 w-full">
				<div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
					<!-- Text Content -->
					<div class="lg:w-1/2 text-center lg:text-left space-y-8">
						<div class="space-y-4">
							<h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight tracking-tight">
								{{ heroTitle }}
							</h1>
							<p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
								Selamat datang di portal resmi penerimaan siswa baru untuk jenjang <span class="text-blue-600 font-bold">SD</span> dan <span class="text-blue-600 font-bold">SMP</span> di Kabupaten Kuantan Singingi.
							</p>
						</div>

						<div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
							<router-link
								to="/daftar"
								class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition duration-300 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transform hover:-translate-y-0.5"
							>
								Daftar Sekarang
							</router-link>
							<a
								href="#video-tutorial"
								class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-bold rounded-full border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition duration-300 transform hover:-translate-y-0.5"
							>
								<svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
								</svg>
								Lihat Tutorial
							</a>
						</div>
					</div>

					<!-- Illustration -->
					<div class="lg:w-1/2 relative">
						<div class="relative z-10 transform hover:scale-[1.02] transition-transform duration-500">
							<GradeIllustration class="w-full h-auto drop-shadow-2xl" />
						</div>
						<!-- Decorative blob behind image -->
						<div class="absolute inset-0 bg-gradient-to-tr from-blue-100 to-transparent rounded-full blur-2xl opacity-60 -z-10 transform scale-110"></div>
					</div>
				</div>
			</div>

			<!-- Bottom Wave -->
			<div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-20">
				<svg viewBox="0 0 1440 100" class="relative block w-full h-16 md:h-24 text-gray-50" fill="currentColor">
					<path d="M1440 100H0V0c.07 22 3.8 44 11 65 14 43 45 80 92 92 50 13 106 3 158-12 115-32 231-77 353-85 137-9 278 18 409 53 118 32 235 69 317 77z"></path>
				</svg>
			</div>
		</section>

		<section class="min-h-screen flex items-center snap-start py-20 bg-gray-50/50">
			<div class="max-w-screen-xl mx-auto px-6 w-full">
				<div class="text-center mb-16">
					<h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 tracking-tight">Kenapa Memilih Kami?</h2>
					<p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Platform PPDB yang dirancang khusus untuk kemudahan, kecepatan, dan kenyamanan Anda.</p>
				</div>
				
				<div ref="featuresGrid" class="grid gap-8 md:grid-cols-3">
					<!-- Card 1 -->
					<div 
						class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100"
						:class="[featuresVisible ? 'animate-tuing opacity-100' : 'opacity-0 translate-y-10']"
					>
						<div class="bg-blue-600/10 text-blue-600 rounded-2xl w-14 h-14 flex items-center justify-center mb-6 transform transition-transform group-hover:scale-110">
							<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
							</svg>
						</div>
						<h3 class="text-xl font-bold mb-3 text-gray-900">Pendaftaran Mudah</h3>
						<p class="text-gray-600 leading-relaxed">Proses pendaftaran yang simpel, intuitif, dan bisa dilakukan kapan saja, di mana saja tanpa antri.</p>
					</div>

					<!-- Card 2 -->
					<div 
						class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100 delay-150"
						:class="[featuresVisible ? 'animate-tuing opacity-100' : 'opacity-0 translate-y-10']"
					>
						<div class="bg-emerald-600/10 text-emerald-600 rounded-2xl w-14 h-14 flex items-center justify-center mb-6">
							<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
							</svg>
						</div>
						<h3 class="text-xl font-bold mb-3 text-gray-900">Proses Transparan</h3>
						<p class="text-gray-600 leading-relaxed">Pantau status seleksi dan pengumuman secara real-time langsung dari dashboard akun Anda.</p>
					</div>

					<!-- Card 3 -->
					<div 
						class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100 delay-300"
						:class="[featuresVisible ? 'animate-tuing opacity-100' : 'opacity-0 translate-y-10']"
					>
						<div class="bg-indigo-600/10 text-indigo-600 rounded-2xl w-14 h-14 flex items-center justify-center mb-6">
							<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
							</svg>
						</div>
						<h3 class="text-xl font-bold mb-3 text-gray-900">Dukungan Penuh</h3>
						<p class="text-gray-600 leading-relaxed">Tim support kami siap membantu menjawab pertanyaan dan kendala teknis Anda setiap saat.</p>
					</div>
				</div>
			</div>
		</section>

		<section id="video-tutorial" class="bg-white min-h-screen flex items-center snap-start py-24">
			<div class="max-w-screen-xl mx-auto px-6 text-center w-full">
				<h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Video Tutorial</h2>
				<p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Ikuti langkah mudah pendaftaran melalui panduan video berikut.</p>
				<div class="mt-12 max-w-5xl mx-auto shadow-2xl rounded-2xl overflow-hidden ring-4 ring-gray-100">
					<div class="relative" style="padding-top: 56.25%;">
						<iframe
							class="absolute top-0 left-0 w-full h-full"
							:src="ytURL as string"
							title="Tutorial PPDB Kuantan Singingi"
							frameborder="0"
							allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
							allowfullscreen
						></iframe>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>

<script setup lang="ts">
import GradeIllustration from "@/components/Illustration/GradeIllustration.vue"
import { useSetting } from "@/composable/useSetting"
import { computed, onMounted, onUnmounted, ref } from "vue"
import { useIntersectionObserver } from '@vueuse/core'

const { settingData, fetchSetting, ytURL } = useSetting()
const featuresGrid = ref(null)
const featuresVisible = ref(false)

useIntersectionObserver(
  featuresGrid,
  ([{ isIntersecting }]) => {
	featuresVisible.value = isIntersecting
  },
  { threshold: 0.2 } // Trigger when 20% visible
)

const heroTitle = computed(() => {
	const title = settingData.value?.header
	if (typeof title === "string" && title.trim().length > 0) {
		return title
	}
	return "Pendaftaran Sekolah Lebih Mudah & Cepat"
})

onMounted(async () => {
	await fetchSetting()
	
	// Force scroll to top
	if ('scrollRestoration' in history) {
		history.scrollRestoration = 'manual';
	}
	window.scrollTo(0, 0);

	// Enable scroll snap logic globally for this page
	document.documentElement.style.scrollSnapType = 'y mandatory'
})

onUnmounted(() => {
	// Clean up global styles when leaving
	document.documentElement.style.scrollSnapType = ''
	document.documentElement.style.scrollBehavior = ''
	
	// Restore default scroll behavior
	if ('scrollRestoration' in history) {
		history.scrollRestoration = 'auto';
	}
})
</script>

<style scoped>
@keyframes tuing {
	0% {
		opacity: 0;
		transform: translateY(50px) scale(0.8);
	}
	50% {
		opacity: 1;
		transform: translateY(-10px) scale(1.05); /* Overshoot for spring effect */
	}
	100% {
		opacity: 1;
		transform: translateY(0) scale(1);
	}
}

.animate-tuing {
	animation: tuing 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; /* Elastic bezier */
}
</style>
