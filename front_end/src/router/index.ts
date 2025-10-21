import { createRouter, createWebHistory } from "vue-router"
import routes from "@/router/routes"
import { useAuthStore } from "@/stores/auth"
import { useMessagesStore } from "@/stores/messages"
import { useSidebarStore } from "@/stores/sidebar"
import { useLoadingStore } from "@/stores/loadingStore"

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes,
	scrollBehavior(to, from, savedPosition) {
		return savedPosition || { left: 0, top: 0 }
	},
})

router.beforeEach(async (to, from, next) => {
        const messagesStore = useMessagesStore()
        document.title = `PPDB ${to.meta.title}`
        const authStore = useAuthStore()
        const sidebarStore = useSidebarStore()
        const loadingStore = useLoadingStore()
        loadingStore.startLoading()
        if (sidebarStore.page !== to.meta.label) {
                sidebarStore.selected = to.meta.label as string
        }
        if (to.meta.requiresAuth) {
                try {
                        await authStore.restoreSession()
                } catch (error) {
                        console.error("Failed to restore session", error)
                }

                if (!authStore.isLoggedIn()) {
                        authStore.intendedURL = to.fullPath
                        next({ name: "login" })
                        return
                }
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

router.afterEach(() => {
	const loadingStore = useLoadingStore()
	loadingStore.stopLoading()
})

export default router
