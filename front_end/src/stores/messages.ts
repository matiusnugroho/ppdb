import { defineStore } from "pinia"
import { ref } from "vue"

type MessageObject = {
	[key: string]: unknown
}

export const useMessagesStore = defineStore(
	"messages",
	() => {
		const messages = ref<Record<string, MessageObject>>({})
		const shouldRemoveMessage = ref<boolean>(false)

		const addMessage = (key: string, message: MessageObject) => {
			messages.value[key] = message
			shouldRemoveMessage.value = false
		}

		const removeMessage = (key: string) => {
			delete messages.value[key]
		}

		const clearMessages = () => {
			messages.value = {}
		}
		const markForRemoval = () => {
			shouldRemoveMessage.value = true // Set the flag to true
		}

		return {
			messages,
			shouldRemoveMessage,
			addMessage,
			removeMessage,
			clearMessages,
			markForRemoval,
		}
	},
	{
		persist: true,
	},
)
