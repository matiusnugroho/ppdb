import { defineStore } from "pinia"
import { ref } from "vue"

type MessageObject = {
	[key: string]: unknown
}

export const useMessagesStore = defineStore(
	"messages",
	() => {
		const messages = ref<Record<string, MessageObject>>({})

		const addMessage = (key: string, message: MessageObject) => {
			messages.value[key] = message
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
