<template>
	<div :class="customClasses">
		<label class="mb-2.5 block text-black dark:text-white">
			{{ props.label }}
			<span v-if="required" class="text-meta-1">*</span>
		</label>
		<select
			:model-value="modelValue"
			@change="updateValue"
			class="w-full rounded border-[1.5px] text-black border-stroke bg-transparent py-2 px-2 font-normal outline-none transition focus:border-primary active:border-primary dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
			<option value="">{{ props.placeholder }}</option>
			<option v-for="option in options" :key="option.value as string" :value="option.value">
				{{ option.label }}
			</option>
		</select>
	</div>
</template>

<script setup lang="ts">
import type { Option } from "@/types"
import type { PropType } from "vue"

// Define the props for the select component
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
})

// Define the emit event for v-model binding
const emit = defineEmits(["update:modelValue"])

// Update the selected value emitted to the parent component
const updateValue = (event: Event) => {
	const target = event.target as HTMLSelectElement
	emit("update:modelValue", target.value)
}
</script>
