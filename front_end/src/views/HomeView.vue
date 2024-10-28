<script setup lang="ts">
import NavBar from "@/components/NavBar.vue"
</script>

<template>
	<NavBar />

	<section class="relative py-14 lg:pt-44 lg:pb-24 bg-gray-100">
		<div class="w-full max-w-7xl mx-auto px-4 lg:px-8">
			<div class="w-full max-w-4xl mx-auto sm:px-12 mb-10 lg:mb-20">
				<h1 class="font-manrope font-bold text-4xl leading-snug sm:text-5xl text-center mb-5 text-black">The Art of Strategic Wallet Management</h1>
				<p class="text-xl font-medium leading-8 text-gray-400 text-center mb-14 max-w-xl mx-auto">
					where every expense becomes a brushstroke of intention, creating a masterpiece of financial well-being and wealth.
				</p>
				<div
					class="parent flex flex-col sm:flex-row items-center max-w-xl mx-auto justify-center gap-y-4 sm:justify-between pr-2 sm:pr-1 sm:bg-white rounded-full mb-5 relative group transition-all duration-500 border border-transparent hover:border-indigo-600 focus-within:border-indigo-600">
					<input
						type="email"
						class="block w-full px-6 py-3.5 text-base max-sm:text-center font-normal shadow-xs max-sm:bg-white text-gray-900 bg-transparent border-none rounded-full placeholder-gray-400 focus:outline-none leading-normal"
						placeholder="What’s your work email?"
						required />
					<button
						class="py-3 px-6 max-sm:w-full rounded-full bg-indigo-600 text-white text-sm leading-4 font-medium whitespace-nowrap transition-all duration-300 hover:bg-indigo-700 sm:absolute top-1.5 right-3">
						Get Started
					</button>
				</div>
				<p class="text-sm font-normal text-gray-500 text-center">no personal credit checks or founder guarantee.</p>
			</div>
			<div class="flex flex-col lg:flex-row items-center justify-center gap-4 lg:justify-between">
				<img src="https://pagedone.io/asset/uploads/1709270640.png" alt="" />

				<img src="https://pagedone.io/asset/uploads/1710391965.png" alt="" class="mx-auto w-56" />
				<img src="https://pagedone.io/asset/uploads/1709270672.png" alt="" />
			</div>
		</div>
	</section>
</template>
