<script setup lang="ts">
import { RouterView, useRoute } from "vue-router"
import { useSidebarStore } from "@/stores/sidebar"
import { onMounted, watch } from "vue"
import { useLoadingStore } from "@/stores/loadingStore"
import WebLoadingComponent from "@/components/UI/WebLoadingComponent.vue"
const sidebarStore = useSidebarStore()
const route = useRoute()
const loadingStore = useLoadingStore()
onMounted(() => {
	if (sidebarStore.page !== route.meta.label) {
		sidebarStore.page = route.meta.label as string
	}
})

// Watch for changes in the route meta label to update the selected state
watch(
	() => route.meta.label,
	(newLabel) => {
		if (sidebarStore.page !== newLabel) {
			sidebarStore.page = newLabel as string
		}
	},
	{ immediate: true }, // Trigger immediately when component is mounted
)
</script>

<template>
	<router-view v-slot="{ Component }">
		<WebLoadingComponent v-if="loadingStore.loading" />
		<component v-else :is="Component" />
	</router-view>
</template>
