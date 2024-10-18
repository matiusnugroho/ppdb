<template>
	<div :class="customClasses">
		<label class="mb-1 block text-black dark:text-white" :for="name">
			{{ label }}
			<span v-if="required" class="text-meta-1">*</span>
		</label>
		<div class="relative">
			<input
				:type="showPassword ? 'text' : 'password'"
				:placeholder="placeholder"
				:autocomplete="autocomplete"
				:value="modelValue"
				@input="updateValue"
				:id="name"
				class="w-full rounded border-[1.5px] text-black border-stroke py-1 px-2 font-normal outline-none transition disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input"
				:class="[
					error
						? 'border-red-500 dark:border-red-500 bg-red-200 focus:border-red-500 focus-visible:outline-none'
						: 'bg-gray focus:border-primary active:border-primary dark:focus:border-primary',
				]" />

			<span class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500" @click="togglePasswordVisibility">
				<HeroIcon :name="showPassword ? 'lock-closed' : 'lock-open'" class="text-gray-500" />
			</span>
		</div>
	</div>
</template>

<script setup lang="ts">
import { ref } from "vue"
import HeroIcon from "@/components/Icon/HeroIcon.vue"

defineProps({
	label: String,
	type: { type: String, default: "password" },
	placeholder: String,
	customClasses: String,
	required: { type: Boolean, default: false },
	autocomplete: { type: String, default: "" },
	modelValue: String,
	name: String,
	error: {
		type: Boolean,
		default: false,
	},
})

const emit = defineEmits(["update:modelValue"])

const showPassword = ref(false)

const updateValue = (event: Event) => {
	const target = event.target as HTMLInputElement
	emit("update:modelValue", target.value)
}

const togglePasswordVisibility = () => {
	showPassword.value = !showPassword.value
}
</script>
