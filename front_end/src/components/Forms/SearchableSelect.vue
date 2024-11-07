<template>
	<div class="relative group" v-click-outside="closeDropdown" :class="customClasses">
		<label class="mb-1 block text-black dark:text-white">
			{{ label }}
			<span v-if="required" class="text-meta-1">*</span>
		</label>
		<div
			@click="toggleDropdown"
			class="cursor-pointer inline-flex justify-between w-full px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500"
			:class="[error ? 'border-red-500 dark:border-red-500 bg-red-200 focus:border-red-500 focus-visible:outline-none' : 'bg-white']">
			<span class="flex items-center mr-2">
				<span v-if="loading" class="mr-2">
					<SpinnerLoading :loading="loading" size="xs" />
				</span>
				{{ selectedLabel || placeholder }}
			</span>
			<HeroIcon name="caret-down" size="18" />
		</div>
		<div v-show="isOpen" class="absolute right-0 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-[9999]">
			<!-- Search input -->
			<div class="p-1">
				<input
					v-model="searchTerm"
					class="block w-full px-4 py-2 text-gray-800 border rounded-md border-gray-300 focus:outline-none"
					type="text"
					placeholder="Search items"
					autocomplete="off"
					ref="searchInput" />
			</div>
			<!-- Scrollable Dropdown content -->
			<div class="custom-scrollbar max-h-48 overflow-y-auto">
				<a
					v-for="item in filteredItems"
					:key="item.value as string"
					href="#"
					@click.prevent="selectOption(item)"
					class="block w-full px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md">
					{{ item.label }}
				</a>
			</div>
		</div>
	</div>
</template>

<script lang="ts" setup>
import { ref, computed, nextTick } from "vue"
import type { PropType } from "vue"
import type { Option } from "@/types"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import SpinnerLoading from "@/components/UI/SpinnerLoading.vue"

const props = defineProps({
	label: String,
	options: {
		type: Array as PropType<Option[]>,
		required: true,
	},
	customClasses: String,
	required: { type: Boolean, default: false },
	modelValue: { type: String, default: "" },
	placeholder: { type: String, default: "Pilih" },
	loading: { type: Boolean, default: false },
	error: {
		type: Boolean,
		default: false,
	},
})

// Define emit
const emit = defineEmits<{
	(e: "update:modelValue", value: string): void
}>()

// State variables
const isOpen = ref(false)
const searchTerm = ref("")
const searchInput = ref<HTMLInputElement | null>(null)
const selectedLabel = ref<string | null>(null)

// Toggle dropdown visibility
const toggleDropdown = () => {
	isOpen.value = !isOpen.value
	if (isOpen.value) {
		// Focus the input after the dropdown is opened
		nextTick(() => {
			searchInput.value?.focus()
		})
	}
}
const closeDropdown = () => {
	isOpen.value = false
}

// Function to handle option selection
const selectOption = (item: Option) => {
	searchTerm.value = ""
	selectedLabel.value = item.label
	emit("update:modelValue", item.value as string)
	isOpen.value = false
}

// Computed property for filtering items
const filteredItems = computed(() => {
	const term = searchTerm.value.toLowerCase()
	return props.options.filter((item) => item.label.toLowerCase().includes(term))
})
</script>

<style scoped>
/* Custom scrollbar styling */
.custom-scrollbar::-webkit-scrollbar {
	width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
	background: #f0f0f0;
	border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
	background-color: #888;
	border-radius: 4px;
	border: 2px solid #f0f0f0;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
	background-color: #555;
}

/* Firefox scrollbar styling */
.custom-scrollbar {
	scrollbar-width: thin;
	scrollbar-color: #888 #f0f0f0;
}
</style>
