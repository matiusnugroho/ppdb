<template>
        <footer class="bg-gray-800 text-white">
                <div class="mx-auto max-w-screen-xl px-6 py-10">
                        <div class="text-center">
                                <RouterLink to="/" class="inline-flex items-center justify-center text-2xl font-bold">
                                        <img :src="logoppdb" class="mr-3 h-10 w-10" alt="Logo PPDB" />
                                        <span>
                                                <span class="text-blue-400">PPDB</span>
                                                <span class="text-white"> Pro</span>
                                        </span>
                                </RouterLink>
                                <p class="mt-4 text-sm text-gray-400">
                                        Membantu Mewujudkan Pendidikan Generasi Terbaik Bangsa.
                                </p>
                                <nav class="mt-6 flex justify-center space-x-6 text-sm font-medium">
                                        <RouterLink
                                                to="/informasi"
                                                class="transition hover:text-blue-400"
                                        >
                                                Informasi
                                        </RouterLink>
                                        <RouterLink
                                                to="/statistik"
                                                class="transition hover:text-blue-400"
                                        >
                                                Statistik
                                        </RouterLink>
                                        <RouterLink
                                                to="/faq"
                                                class="transition hover:text-blue-400"
                                        >
                                                FAQ
                                        </RouterLink>
                                </nav>
                        </div>
                        <div class="mt-8 border-t border-gray-700 pt-6 text-center">
                                <p class="text-xs text-gray-500">&copy; 2025 Panitia PPDB Pro. Semua Hak Cipta Dilindungi.</p>
                        </div>
                        <div class="mt-8 flex justify-center">
                                <button
                                        type="button"
                                        class="inline-flex items-center rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:bg-blue-500"
                                        @click="scrollToTop"
                                >
                                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.894.553l4 8a1 1 0 01-1.788.894L10 5.618 6.894 12.447a1 1 0 01-1.788-.894l4-8A1 1 0 0110 3z" clip-rule="evenodd" />
                                        </svg>
                                        Kembali ke atas
                                </button>
                        </div>
                </div>
        </footer>
</template>

<script setup lang="ts">
import { useSmoothScrollToTop } from "@/composable/useSmoothScrollToTop"
import logoppdb from "@/assets/images/logo/logo-ppdb.png"

const { smoothScrollToTop } = useSmoothScrollToTop()

const scrollToTop = () => {
        smoothScrollToTop("#main-home")
}
</script>
