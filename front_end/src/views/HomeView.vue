<template>
        <div class="bg-gray-50 text-gray-700">
                <section class="relative bg-white pt-16 pb-24 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-100 opacity-60"></div>
                        <div class="container mx-auto px-6 relative z-10 flex flex-col lg:flex-row items-center">
                                <div class="lg:w-1/2 text-center lg:text-left">
                                        <span class="text-blue-600 font-semibold uppercase tracking-wider">PPDB Online 2025/2026</span>
                                        <h1 class="text-4xl md:text-6xl font-extrabold text-gray-800 mt-2 leading-tight tracking-tight">
                                                {{ heroTitle }}
                                        </h1>
                                        <p class="mt-6 text-lg text-gray-600 max-w-xl mx-auto lg:mx-0">
                                                Selamat datang di portal resmi penerimaan siswa baru. Mulai langkah pertama pendidikan terbaik untuk masa depan.
                                        </p>
                                        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                                <router-link
                                                        to="/daftar"
                                                        class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition duration-300 shadow-xl shadow-blue-500/30 transform hover:scale-[1.02]"
                                                >
                                                        Daftar Sekarang
                                                </router-link>
                                                <a
                                                        href="#video-tutorial"
                                                        class="inline-flex items-center justify-center px-8 py-4 text-gray-700 font-bold rounded-full hover:bg-gray-200 transition duration-300"
                                                >
                                                        Lihat Tutorial ▸
                                                </a>
                                        </div>
                                </div>
                                <div class="lg:w-1/2 mt-12 lg:mt-0">
                                        <GradeIllustration class="w-full h-auto" />
                                </div>
                        </div>
                        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none" style="transform: translateY(1px);">
                                <svg viewBox="0 0 1440 100" class="relative block w-full h-20 text-gray-50" fill="currentColor">
                                        <path d="M1440 100H0V0c.07 22 3.8 44 11 65 14 43 45 80 92 92 50 13 106 3 158-12 115-32 231-77 353-85 137-9 278 18 409 53 118 32 235 69 317 77z"></path>
                                </svg>
                        </div>
                </section>

                <section class="py-20">
                        <div class="container mx-auto px-6">
                                <div class="text-center mb-12">
                                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Kenapa Memilih Kami?</h2>
                                        <p class="mt-2 text-gray-600">Platform PPDB yang dirancang untuk kemudahan Anda.</p>
                                </div>
                                <div class="grid gap-8 md:grid-cols-3">
                                        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                                                <div class="bg-blue-100 text-blue-600 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                </div>
                                                <h3 class="text-xl font-bold mb-2">Pendaftaran Mudah</h3>
                                                <p class="text-gray-600">Proses pendaftaran yang simpel dan bisa dilakukan kapan saja, di mana saja.</p>
                                        </div>
                                        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                                                <div class="bg-green-100 text-green-600 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                </div>
                                                <h3 class="text-xl font-bold mb-2">Proses Transparan</h3>
                                                <p class="text-gray-600">Pantau status pendaftaran Anda secara real-time dari dashboard.</p>
                                        </div>
                                        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">
                                                <div class="bg-indigo-100 text-indigo-600 rounded-full w-16 h-16 flex items-center justify-center mb-6">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                        </svg>
                                                </div>
                                                <h3 class="text-xl font-bold mb-2">Dukungan Penuh</h3>
                                                <p class="text-gray-600">Tim kami siap membantu jika Anda mengalami kendala saat proses pendaftaran.</p>
                                        </div>
                                </div>
                        </div>
                </section>

                <section id="video-tutorial" class="bg-white py-20">
                        <div class="container mx-auto px-6 text-center">
                                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Video Tutorial Pendaftaran</h2>
                                <p class="mt-2 text-gray-600 max-w-2xl mx-auto">Ikuti langkah-langkah pendaftaran dengan mudah melalui panduan video di bawah ini.</p>
                                <div class="mt-10 max-w-4xl mx-auto shadow-2xl rounded-xl overflow-hidden">
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
import { computed, onMounted } from "vue"

const { settingData, fetchSetting, ytURL } = useSetting()

const heroTitle = computed(() => {
        const title = settingData.value?.header
        if (typeof title === "string" && title.trim().length > 0) {
                return title
        }
        return "Pendaftaran Sekolah Lebih Mudah & Cepat"
})

onMounted(async () => {
        await fetchSetting()
})
</script>
