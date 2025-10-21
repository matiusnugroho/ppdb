import { defineStore } from "pinia"
import { ref } from "vue"
import requestor from "@/services/requestor"
import { ENDPOINTS } from "@/config/endpoint"
import type { Student, User } from "@/types"

export const useAuthStore = defineStore(
	"auth",
	() => {
		const user = ref<User | null>(null)
		const biodata = ref<Student | null>(null)
		const role = ref<string | null>(null)
		const intendedURL = ref<string | null>(null)
                const applyAuthPayload = (data: any) => {
                        user.value = data.user
                        biodata.value = data.biodata
                        role.value = data.role
                }

                const clearAuthState = () => {
                        user.value = null
                        biodata.value = null
                        role.value = null
                }

                let restoreSessionPromise: Promise<void> | null = null

                const login = async (username: string, password: string) => {
                        try {
                                const response = await requestor.post(
                                        ENDPOINTS.LOGIN,
                                        { username, password },
                                        {
                                                headers: {
                                                        "Bypass-Interceptor": "true",
                                                },
                                        },
                                )
                                applyAuthPayload(response.data)
                                return response.data
                        } catch (error) {
                                console.error("Login error from authstore:", error)
                                throw error
                        }
                }

                const restoreSession = async () => {
                        if (user.value) {
                                return
                        }

                        if (!restoreSessionPromise) {
                                restoreSessionPromise = (async () => {
                                        try {
                                                const response = await requestor.post(
                                                        ENDPOINTS.AUTH_ME,
                                                        {},
                                                        {
                                                                headers: {
                                                                        "Bypass-Interceptor": "true",
                                                                },
                                                        },
                                                )
                                                applyAuthPayload(response.data)
                                        } catch (error) {
                                                clearAuthState()
                                                throw error
                                        } finally {
                                                restoreSessionPromise = null
                                        }
                                })()
                        }

                        return restoreSessionPromise
                }

                const logout = async () => {
                        clearAuthState()
                        intendedURL.value = null
                        try {
                                await requestor.post(ENDPOINTS.LOGOUT, undefined, {
                                        headers: {
                                                "Bypass-Interceptor": "true",
                                        },
                                })
                        } catch (error) {
                                console.error("Login error from authstore:", error)
                                throw error
                        }
                }

		const isLoggedIn = () => {
			return !!user.value
		}

		// Return state and actions
		return {
			user,
			biodata,
			role,
			intendedURL,
                        login,
                        restoreSession,
                        logout,
                        isLoggedIn,
                }
	},
	{
		persist: true,
	},
)
