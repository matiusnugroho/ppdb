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
                                const bindingValue = binding.value as
                                        | ClickOutsideHandler
                                        | { handler?: ClickOutsideHandler; _args?: unknown[] }
                                        | undefined
                                if (typeof bindingValue === "function") {
                                        // Call the function directly if it's a function
                                        bindingValue(_event)
                                } else if (bindingValue && typeof bindingValue.handler === "function") {
                                        // Call the handler with parameters if provided
                                        bindingValue.handler(_event, ...(bindingValue._args || []))
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
