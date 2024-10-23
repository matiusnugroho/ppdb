<template>
	<article class="flex items-center gap-4 rounded-lg border border-gray-100 bg-white p-6">
		<span class="rounded-full p-3" :class="`text-${color}-600 bg-${color}-100`">
			<HeroIcon :name="icon!" size="18" class="h-6 w-6" />
		</span>

		<div>
			<p class="text-2xl font-medium text-gray-900">{{value}}</p>

			<p class="text-sm text-gray-500">{{label}}</p>
		</div>
	</article>
</template>
<script setup lang="ts">
import HeroIcon from '../Icon/HeroIcon.vue'

defineProps({
    icon : {
        type : String,
        default : "user-circle"
    },
    label : {
        type : String,
        default : "Info Label di sini"
    },
    value : {
        type : String,
        default : "Info Value di sini"
    },
    color : {
        type : String,
        default : "red"
    }
})
</script>
