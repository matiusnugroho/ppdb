import { defineStore } from "pinia"
import { ref } from "vue"

export const useMessagesStore = defineStore(
	"messages",
	() => {
		const messages = ref<Record<string, string[]>>({})

		const addMessage = (key: string, message: string) => {
			if (!messages.value[key]) {
				messages.value[key] = []
			}
			messages.value[key].push(message)
		}

		const removeMessage = (key: string) => {
			delete messages.value[key]
		}

		const clearMessages = () => {
			messages.value = {}
		}

		return {
			messages,
			addMessage,
			removeMessage,
			clearMessages,
		}
	},
	{
		persist: true,
	},
)
