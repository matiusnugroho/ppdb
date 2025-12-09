<template>
	<NavBar ref="navbarRef" />
	<main :style="{ marginTop: `${navbarHeight}px` }" class="bg-white dark:bg-gray-900 min-h-screen" id="main-home">
		<router-view />
	</main>
	<div class="snap-start">
		<HomeFooter />
	</div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from "vue"
import HomeFooter from "@/components/HomeFooter.vue"
import NavBar from "@/components/NavBar.vue"

// Define the type for the navbar ref
const navbarRef = ref<InstanceType<typeof NavBar> | null>(null)
const navbarHeight = ref(0)

onMounted(async () => {
	// Wait for the next DOM update cycle
	await nextTick()

	// Access the actual HTML element using $el
	if (navbarRef.value?.$el) {
		navbarHeight.value = navbarRef.value.$el.offsetHeight

		// Set up resize observer to handle dynamic height changes
		const resizeObserver = new ResizeObserver((entries) => {
			for (const entry of entries) {
				navbarHeight.value = entry.contentRect.height
			}
		})

		resizeObserver.observe(navbarRef.value.$el)
	}
})
</script>
