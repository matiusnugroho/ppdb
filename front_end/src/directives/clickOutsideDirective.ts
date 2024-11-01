import type { DirectiveBinding } from "vue"
interface HTMLElementWithClickOutside extends HTMLElement {
	
	clickOutsideEvent?: (_event: MouseEvent) => void
}

type ClickOutsideHandler = (_event: MouseEvent, ..._args: any[]) => void

interface ClickOutsideBinding extends DirectiveBinding {
	handler?: ClickOutsideHandler
	_args?: any[]
}

export const clickOutsideDirective = {
	beforeMount(el: HTMLElementWithClickOutside, binding: ClickOutsideBinding) {
		// Define the click handler
		el.clickOutsideEvent = (_event: MouseEvent) => {
			// Check if the click was outside the element
			if (!(el === _event.target || el.contains(_event.target as Node))) {
				if (typeof binding.value === "function") {
					// Call the function directly if it's a function
					binding.value(event)
				} else if (typeof binding.value.handler === "function") {
					// Call the handler with parameters if provided
					binding.value.handler(event, ...(binding.value._args || []))
				}
			}
		}
		// Add event listener to the document
		document.addEventListener("click", el.clickOutsideEvent)
	},
	unmounted(el: HTMLElementWithClickOutside) {
		// Remove the event listener when the element is unmounted
		if (el.clickOutsideEvent) {
			document.removeEventListener("click", el.clickOutsideEvent)
		}
	},
}
