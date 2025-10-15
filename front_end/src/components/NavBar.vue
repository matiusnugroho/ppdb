<template>
        <nav
                id="navbar"
                class="fixed top-0 left-0 z-50 w-full bg-white/80 backdrop-blur-lg shadow-sm transition-all duration-300"
        >
                <div class="mx-auto flex max-w-screen-xl flex-col px-6">
                        <div class="flex items-center justify-between py-4">
                                <RouterLink
                                        to="/"
                                        class="flex items-center gap-3 text-2xl font-bold text-gray-800"
                                        aria-label="Beranda PPDB"
                                >
                                        <img :src="logoppdb" class="w-10" alt="Logo PPDB" />
                                        <span class="hidden sm:inline">
                                                <span class="text-blue-600">PPDB</span>
                                                <span class="text-gray-800"> Pro</span>
                                        </span>
                                </RouterLink>

                                <div class="hidden items-center space-x-6 md:flex">
                                        <ul class="flex items-center space-x-6 text-sm font-medium">
                                                <DropDownMenu title="Informasi" :items="dropdownAItems" />
                                                <NavLink name="Statistik" url="/statistik" />
                                        </ul>
                                        <router-link
                                                to="/login"
                                                class="flex items-center space-x-2 rounded-full bg-blue-600 px-5 py-2.5 font-semibold text-white shadow-lg shadow-blue-500/20 transition duration-300 hover:-translate-y-0.5 hover:bg-blue-700"
                                        >
                                                <svg
                                                        class="h-5 w-5"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                >
                                                        <path
                                                                fill-rule="evenodd"
                                                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                                                clip-rule="evenodd"
                                                        />
                                                </svg>
                                                <span>Login</span>
                                        </router-link>
                                </div>

                                <div class="md:hidden">
                                        <button
                                                type="button"
                                                class="text-gray-600 transition hover:text-blue-600 focus:outline-none"
                                                aria-controls="mobile-menu"
                                                :aria-expanded="open ? 'true' : 'false'"
                                                @click="toggleMobileMenu"
                                        >
                                                <SegmentIcon v-if="!open" :size="28" />
                                                <CloseIcon v-else :size="28" />
                                        </button>
                                </div>
                        </div>

                        <transition name="fade-slide">
                                <div
                                        v-if="open"
                                        id="mobile-menu"
                                        class="md:hidden border-t border-gray-100 bg-white"
                                >
                                        <div class="space-y-2 px-4 pb-4 pt-2">
                                                <div>
                                                        <button
                                                                type="button"
                                                                class="flex w-full items-center justify-between rounded-md px-2 py-2 text-left text-gray-600 transition hover:text-blue-600"
                                                                :aria-expanded="mobileDropdownOpen ? 'true' : 'false'"
                                                                @click="toggleMobileDropdown"
                                                        >
                                                                <span>Informasi</span>
                                                                <svg
                                                                        class="h-4 w-4 transition-transform duration-300"
                                                                        :class="mobileDropdownOpen ? 'rotate-180' : ''"
                                                                        fill="none"
                                                                        stroke="currentColor"
                                                                        viewBox="0 0 24 24"
                                                                >
                                                                        <path
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M19 9l-7 7-7-7"
                                                                        />
                                                                </svg>
                                                        </button>
                                                        <div
                                                                v-if="mobileDropdownOpen"
                                                                class="mt-1 space-y-1 border-l-2 border-blue-100 pl-4"
                                                        >
                                                                <RouterLink
                                                                        v-for="(item, index) in dropdownAItems"
                                                                        :key="`mobile-info-${index}`"
                                                                        :to="item.url"
                                                                        class="block py-2 text-sm text-gray-500 transition hover:text-blue-600"
                                                                        @click="closeMobileMenus"
                                                                >
                                                                        {{ item.label }}
                                                                </RouterLink>
                                                        </div>
                                                </div>
                                                <RouterLink
                                                        to="/statistik"
                                                        class="block py-2 text-gray-600 transition hover:text-blue-600"
                                                        @click="closeMobileMenus"
                                                >
                                                        Statistik
                                                </RouterLink>
                                                <router-link
                                                        to="/login"
                                                        class="block w-full rounded-full bg-blue-600 py-2.5 text-center font-semibold text-white transition hover:bg-blue-700"
                                                        @click="closeMobileMenus"
                                                >
                                                        Login
                                                </router-link>
                                        </div>
                                </div>
                        </transition>
                </div>
        </nav>
</template>

<script setup lang="ts">
import { onMounted, onUnmounted, ref, watch } from "vue"
import { useRoute } from "vue-router"
import SegmentIcon from "@/components/Icon/SegmentIcon.vue"
import CloseIcon from "@/components/Icon/CloseIcon.vue"
import NavLink from "@/components/NavLink.vue"
import DropDownMenu from "./UI/DropDownMenu.vue"
import logoppdb from "@/assets/images/logo/logo-ppdb.png"

const open = ref(false)
const mobileDropdownOpen = ref(false)
const dropdownAItems = [
        { label: "Daftar Sekolah", url: "/sekolah" },
        { label: "Persyaratan Umum", url: "/persyaratan" },
]

const route = useRoute()

const closeMobileMenus = () => {
        open.value = false
        mobileDropdownOpen.value = false
}

const toggleMobileMenu = () => {
        open.value = !open.value
        if (!open.value) {
                mobileDropdownOpen.value = false
        }
}

const toggleMobileDropdown = () => {
        mobileDropdownOpen.value = !mobileDropdownOpen.value
}

watch(
        () => route.fullPath,
        () => {
                closeMobileMenus()
        },
)

const handleResize = () => {
        if (window.innerWidth >= 768) {
                closeMobileMenus()
        }
}

onMounted(() => {
        window.addEventListener("resize", handleResize)
})

onUnmounted(() => {
        window.removeEventListener("resize", handleResize)
})
</script>

<style>
.fade-slide-enter-active,
.fade-slide-leave-active {
        transition: all 0.2s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
        opacity: 0;
        transform: translateY(-4px);
}
</style>
