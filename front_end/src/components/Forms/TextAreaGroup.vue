<script lang="ts">
import { defineComponent } from "vue"

export default defineComponent({
	props: {
		label: String,
		placeholder: String,
		customClasses: String,
		name: String,
		required: {
			type: Boolean,
			default: false,
		},
		modelValue: String,
		error: {
			type: Boolean,
			default: false,
		},
		rows: {
			type: Number,
			default: 3, // default rows for the textarea
		},
	},
	emits: ["update:modelValue"],
	methods: {
		updateValue(target: HTMLTextAreaElement) {
			this.$emit("update:modelValue", target.value)
		},
	},
})
</script>

<template>
	<div :class="customClasses">
		<label :for="name" class="mb-1 block text-black dark:text-white">
			{{ label }}
			<span v-if="required" class="text-meta-1">*</span>
		</label>
		<textarea
			:placeholder="placeholder"
			:value="modelValue"
			:name="name"
			:required="required"
			:id="name"
			:rows="rows"
			@input="updateValue($event.target as HTMLTextAreaElement)"
			class="w-full rounded border-[1.5px] text-black border-stroke bg-gray py-1 px-2 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
			:class="error ? 'border-red-500 dark:border-red-500 bg-red-200 focus:border-red-500 focus-visible:outline-none' : ''">
		</textarea>
	</div>
</template>
