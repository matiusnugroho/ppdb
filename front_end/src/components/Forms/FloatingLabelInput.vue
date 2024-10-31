<script lang="ts">
import { defineComponent } from "vue"

export default defineComponent({
	props: {
		label: String,
		type: {
			type: String,
			default: "text",
		},
		placeholder: String,
		customClasses: String,
		name: String,
		inputmode: {
			type: String as () => "text" | "email" | "search" | "tel" | "url" | "none" | "numeric" | "decimal",
			default: "text",
		},
		required: {
			type: Boolean,
			default: false,
		},
		modelValue: String,
		error: {
			type: Boolean,
			default: false,
		},
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
	<!-- <div :class="customClasses">
		<label :for="name" class="mb-1 block text-black dark:text-white">
			{{ label }}
			<span v-if="required" class="text-meta-1">*</span>
		</label>
		<input
			:type="type"
			:placeholder="placeholder"
			:value="modelValue"
			:name="name"
			:required="required"
			:id="name"
			:autocomplete="name"
			:inputmode="inputmode"
			@input="updateValue($event.target as HTMLInputElement)"
			class="w-full rounded border-[1.5px] text-black border-stroke bg-gray py-1 px-2 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
			:class="error ? 'border-red-500 dark:border-red-500 bg-red-200 focus:border-red-500 focus-visible:outline-none' : ''" />
	</div> -->
	<label :for="name" class="relative block rounded-md border border-gray-200 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600">
		<input 
			:type="type" 
			:id="name" 
			:value="modelValue" 
			@input="updateValue($event.target as HTMLInputElement)" 
			:name="name"
			:required="required"
			:inputmode="inputmode"
			class="peer border-none bg-transparent placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0" 
			:placeholder="name"
			:class="error ? 'border-red-500 dark:border-red-500 bg-red-200 focus:border-red-500 focus-visible:outline-none' : ''" />

		<span
			class="pointer-events-none absolute start-2.5 top-0 -translate-y-1/2 bg-white p-0.5 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">
			{{ label }}
		</span>
	</label>
</template>
