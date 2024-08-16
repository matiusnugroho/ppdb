import { useRouter } from "vue-router"
import { useAuthStore } from "@/stores/auth"

export function useAuth() {
	const router = useRouter()
	const authStore = useAuthStore()

	const login = async (username: string, password: string) => {
		try {
			const response = await authStore.login(username, password)
			if (response.success) {
				const intendedURL = authStore.intendedURL || "/dashboard"
				await router.push(intendedURL)
			}
		} catch (error: any) {
			console.error("Login error:", error)
			throw error
		}
	}

	const logout = async () => {
		await authStore.logout()
		clearAllCookies()
		router.push({ name: "login" })
	}
	const clearAllCookies = () => {
		const cookies = document.cookie.split(";")

		for (let i = 0; i < cookies.length; i++) {
			const cookie = cookies[i]
			const eqPos = cookie.indexOf("=")
			const name = eqPos > -1 ? cookie.slice(0, eqPos) : cookie
			document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/`
		}
	}

	return { login, logout }
}
