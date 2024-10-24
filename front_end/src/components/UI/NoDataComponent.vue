<template>
	<div class="grid h-full place-content-center bg-white p-16 dark:bg-boxdark">
		<div class="text-center">
			<div class="text-red-500 mx-auto h-56 w-auto sm:h-64">
				<NoDataSVG class="w-full h-full" />
			</div>

			<h1 class="mt-6 text-2xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ title }}</h1>

			<p class="mt-4 text-gray-500">{{ message }}</p>
		</div>
	</div>
</template>
<script setup lang="ts">
import NoDataSVG from "@/assets/images/illustration/no_data.svg"
defineProps({
	title: {
		type: String,
		default: "No Data",
	},
	message: {
		type: String,
		default: "No Data Found",
	},
})
</script>
