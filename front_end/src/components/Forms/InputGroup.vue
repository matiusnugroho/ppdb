<script lang="ts">
import { defineComponent } from "vue"

export default defineComponent({
	props: {
		label: String,
		type: String,
		placeholder: String,
		customClasses: String,
		name: String,
		required: {
			type: Boolean,
			default: false,
		},
		modelValue: String,
	},
	emits: ["update:modelValue"],
	methods: {
		updateValue(target: HTMLInputElement) {
			this.$emit("update:modelValue", target.value)
		},
	},
})
</script>

<template>
	<div :class="customClasses">
		<label class="mb-2.5 block text-black dark:text-white">
			{{ label }}
			<span v-if="required" class="text-meta-1">*</span>
		</label>
		<input
			:type="type"
			:placeholder="placeholder"
			:value="modelValue"
			:name="name"
			:autocomplete="name"
			@input="updateValue($event.target as HTMLInputElement)"
			class="w-full rounded border-[1.5px] text-black border-stroke bg-transparent py-2 px-2 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
	</div>
</template>
