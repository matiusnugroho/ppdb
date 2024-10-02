import { createRouter, createWebHistory } from "vue-router"
import routes from "@/router/routes"
import { useAuthStore } from "@/stores/auth"
import { useMessagesStore } from "@/stores/messages"

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes,
	scrollBehavior(to, from, savedPosition) {
		return savedPosition || { left: 0, top: 0 }
	},
})

router.beforeEach((to, from, next) => {
	const messagesStore = useMessagesStore()
	document.title = `PPDB ${to.meta.title}`
	const authStore = useAuthStore()
	if (to.meta.requiresAuth && !authStore.isLoggedIn()) {
		authStore.intendedURL = to.fullPath
		next({ name: "login" })
		return
	}
	if (messagesStore.shouldRemoveMessage) {
		// Clear all messages
		messagesStore.clearMessages()
	  }
	
	  if (!messagesStore.shouldRemoveMessage) {
		// If the messages are not yet marked for removal, mark them for removal
		messagesStore.markForRemoval()
	  }
	next()
})

export default router
