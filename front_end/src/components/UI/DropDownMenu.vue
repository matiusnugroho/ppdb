<template>
        <li
                class="relative"
                @mouseenter="openDropdown"
                @mouseleave="closeDropdown"
        >
                <button
                        type="button"
                        class="dropdown-trigger flex items-center space-x-1 rounded-md px-2 py-2 text-sm font-medium text-gray-600 transition duration-300 hover:text-blue-600 focus:outline-none"
                        :aria-expanded="isOpen ? 'true' : 'false'"
                        @click.stop="toggleDropdown"
                >
                        <span>{{ title }}</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                </button>

                <div
                        class="dropdown-menu absolute left-0 mt-2 w-56 origin-top rounded-md bg-white py-2 shadow-lg ring-1 ring-black/5 transition duration-150 ease-out"
                        :class="isOpen ? 'scale-100 opacity-100 pointer-events-auto' : 'scale-95 opacity-0 pointer-events-none'"
                >
                        <ul class="space-y-1 text-sm text-gray-700">
                                <li v-for="(item, index) in items" :key="index">
                                        <RouterLink
                                                :to="item.url"
                                                class="block px-4 py-2 transition duration-150 hover:bg-blue-50 hover:text-blue-600"
                                                @click="selectItem"
                                        >
                                                {{ item.label }}
                                        </RouterLink>
                                </li>
                        </ul>
                </div>
        </li>
</template>

<script setup lang="ts">
import { ref } from "vue"

defineProps<{
        title: string
        items: Array<{ label: string; url: string }>
}>()

const isOpen = ref(false)

const openDropdown = () => {
        isOpen.value = true
}

const closeDropdown = () => {
        isOpen.value = false
}

const toggleDropdown = () => {
        isOpen.value = !isOpen.value
}

const selectItem = () => {
        closeDropdown()
}
</script>

<style scoped>
.dropdown-menu {
        transform-origin: top;
}
</style>
