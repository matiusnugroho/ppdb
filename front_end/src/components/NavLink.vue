<template>
        <li>
                <router-link
                        class="text-sm font-medium text-gray-600 transition duration-300 hover:text-blue-600"
                        :to="url"
                >
                        {{ name }}
                </router-link>
        </li>
</template>

<script setup lang="ts">
defineProps<{
        name: string
        url: string
}>()
</script>
