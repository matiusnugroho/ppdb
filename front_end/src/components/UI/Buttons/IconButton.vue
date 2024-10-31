<script setup lang="ts">
import { computed } from 'vue'
import HeroIcon from "@/components/Icon/HeroIcon.vue"

const props = defineProps<{
	icon: string
    mode?: 'square' | 'round'
    color?: string
    href?: string
}>()

const buttonClass = computed(() => {
  const baseClass = 'inline-block p-3 focus:outline-none focus:ring cursor-pointer'
  const modeClass = props.mode === 'round' ? 'rounded-full' : 'rounded-lg'
  const colorClass = props.color ? `text-${props.color}-400 bg-${props.color}-200 hover:bg-${props.color}-300 active:bg-${props.color}-400` : ''

  return `${baseClass} ${modeClass} ${colorClass}`
})
</script>

<template>
  <a :href="props.href" :class="buttonClass">
    <HeroIcon :name="props.icon" size="18" class="h-6 w-6" />
  </a>
</template>
