<template>
	<nav id="navbar" class="fixed top-0 left-0 z-10 w-full text-neutral-800 shadow-sm bg-white transition-all duration-300">
		<div class="flex flex-col max-w-screen-xl px-8 mx-auto lg:items-center lg:justify-between lg:flex-row py-2">
			<div class="flex flex-col lg:flex-row items-center space-x-4 xl:space-x-8">
				<div class="w-full flex flex-row items-center justify-between py-2">
					<div>
						<RouterLink to="/">
							<img :src="logoppdb" class="w-24 xl:w-28" alt="Logo PPDB" />
						</RouterLink>
					</div>
					<button class="rounded-sm lg:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
						<SegmentIcon v-if="!open" :size="24" />
						<CloseIcon v-else :size="24" />
					</button>
				</div>
			</div>
			<div class="flex items-center" :class="[open ? 'justify-start' : 'justify-end ml-auto']">
				<ul
					:class="[open ? 'flex' : 'hidden lg:flex']"
					class="w-full h-auto flex flex-col flex-grow lg:items-center pb-4 lg:pb-0 lg:justify-end lg:flex-row origin-top duration-300 xl:space-x-2 space-y-3 lg:space-y-0">
					<DropDownMenu title="Informasi" :items="dropdownAItems" />
					<NavLink name="Statistik" url="/statistik" />
				</ul>
			</div>

			<div :class="[open ? 'flex' : 'hidden lg:flex', 'space-x-3', 'ml-2']">
				<router-link to="/login" class="bg-blue-200 hover:bg-blue-300 text-blue-800 font-bold py-2 px-4 rounded-full"> Login </router-link>
			</div>
		</div>
	</nav>
</template>

<script setup lang="ts">
// Import necessary components
import { ref } from "vue"
import SegmentIcon from "@/components/Icon/SegmentIcon.vue"
import CloseIcon from "@/components/Icon/CloseIcon.vue"
import NavLink from "@/components/NavLink.vue"
import DropDownMenu from "./UI/DropDownMenu.vue"
import logoppdb from "@/assets/images/logo/logo-ppdb.png"

// Reactive state for open dropdown and navbar
const open = ref(false)
const dropdownAItems = [
	{ label: "Sekolah", url: "/sekolah" },
	{ label: "Persyaratan", url: "/persyaratan" },
]
</script>

<style>
/* Keep the same style definitions as the original */
.cover-gradient {
	background: linear-gradient(169.4deg, rgba(57, 132, 244, 0.04) -6.01%, rgba(12, 211, 255, 0.04) 36.87%, rgba(47, 124, 240, 0.04) 78.04%, rgba(14, 101, 232, 0.04) 103.77%);
}
.cover-gradient-2 {
	background: linear-gradient(169.4deg, rgba(57, 132, 244, 0.1) -6.01%, rgba(12, 211, 255, 0.1) 36.87%, rgba(47, 124, 240, 0.1) 78.04%, rgba(14, 101, 232, 0.1) 103.77%);
}
.bg-blue-gradient,
.text-gradient {
	background: linear-gradient(136.91deg, #468ef9 -12.5%, #0c66ee 107.5%);
}

/* Transition styles */
.slide-enter-active {
	transition-duration: 0.3s;
	transition-timing-function: ease-in;
}

.slide-leave-active {
	transition-duration: 0.3s;
	transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to,
.slide-leave {
	max-height: 100px;
	overflow: hidden;
}

.slide-enter,
.slide-leave-to {
	overflow: hidden;
	max-height: 0;
}
</style>
