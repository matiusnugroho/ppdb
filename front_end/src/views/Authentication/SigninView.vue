<script setup lang="ts">
import DefaultAuthCard from "@/components/Auths/DefaultAuthCard.vue"
import InputGroup from "@/components/Forms/InputGroup.vue"
import PasswordInput from "@/components/Forms/PasswordInput.vue"
import PlainLayout from "@/layouts/PlainLayout.vue"
import { FwbAlert } from "flowbite-vue"
import { onMounted, ref } from "vue"
import { useAuth } from "@/composable/authComposable"
import { showToast } from "@/utils/ui/toast"
import { getCSRFToken } from "@/services/csrf"
import { useRoute } from "vue-router"
import { useAuthStore } from "@/stores/auth"
import { useMessagesStore } from "@/stores/messages"
import AlertSuccess from "@/components/Alerts/AlertSuccess.vue"
import SpinnerLoading from "@/components/UI/SpinnerLoading.vue"

const emailValue = ref("")
const passwordValue = ref("")
const loginLoading = ref(false)
const loginGagal = ref(false)
const loginGagalMessage = ref("")

const { login } = useAuth()
const route = useRoute()
const authStore = useAuthStore()
const messagesStore = useMessagesStore()

const ambilCSRFToken = async () => {
	try {
		await getCSRFToken()
	} catch (error) {
		console.error(error)
		showToast({
			message: "Gagal mengambil CSRF token, silakan muat ulang halaman login ini",
			type: "warning",
			duration: 5000,
			autoClose: true,
		})
	}
}

const handleLogin = async () => {
	loginLoading.value = true
	loginGagal.value = false
	try {
		await login(emailValue.value, passwordValue.value)
	} catch (error: any) {
		console.log("Error object handleLogin:", error)
		console.log("Error response handleLogin:", error?.response)
		if (error?.response?.status === 401 || error?.response?.status === 422) {
			loginGagal.value = true
			loginGagalMessage.value = "Username atau password salah"
		} else if (error?.response?.status === 429) {
			loginGagal.value = true
			loginGagalMessage.value = "Terlalu banyak percobaan login, coba lagi beberapa saat"
		} else if (error?.code === "ERR_NETWORK") {
			loginGagal.value = true
			loginGagalMessage.value = "Koneksi internet bermasalah"
		} else {
			loginGagal.value = true
			loginGagalMessage.value = "Sepertinya jaringan anda atau server kami mengalami masalah, coba lagi beberapa saat"
		}
	} finally {
		loginLoading.value = false
	}
}

onMounted(async () => {
	const redirectFrom = route.query.intended || "/dashboard"
	authStore.intendedURL = redirectFrom as string
    
    if (route.query.prompt) {
        loginGagal.value = true
        loginGagalMessage.value = route.query.prompt as string
    }

	await ambilCSRFToken()
})
</script>

<template>
	<PlainLayout>
		<DefaultAuthCard subtitle="PPDB Online Kuantan Singingi v1" title="Login">
			<Transition name="fade-slide-up">
				<div v-if="loginGagal" class="mb-2 mt-4">
					<fwb-alert icon type="danger">{{ loginGagalMessage }}</fwb-alert>
				</div>
			</Transition>
			<AlertSuccess v-if="messagesStore.messages?.success" class="mb-5" :message="messagesStore.messages?.success.title as string" :detail="messagesStore.messages?.success.detail as string" />
			<form @submit.prevent="handleLogin">
				<InputGroup name="username" label="Email / Username" type="email" placeholder="Enter your email" v-model="emailValue" />
				<PasswordInput label="Password anda" v-model="passwordValue" />
				<div class="mb-5 mt-6">
					<button
						type="submit"
						class="w-full flex justify-center items-center cursor-pointer rounded-lg border border-primary bg-primary p-2 font-medium text-white transition hover:bg-opacity-90"
						@click="handleLogin"
						:disabled="loginLoading">
						<span class="flex items-center">
							<SpinnerLoading :loading="loginLoading" size="xs" />
							<span class="ml-2">Login</span>
						</span>
					</button>
				</div>

				<div class="mt-6 text-center">
					<p class="font-medium">
						Belum Mempunyai Akun?
						<router-link to="/daftar" class="text-primary">Daftar</router-link> atau <router-link to="sekolah/daftar" class="text-primary">daftarkan sekolah anda</router-link>
					</p>
				</div>
			</form>
		</DefaultAuthCard>
	</PlainLayout>
</template>

<style scoped>
.fade-slide-up-enter-active,
.fade-slide-up-leave-active {
	transition: all 0.5s ease-out;
}

.fade-slide-up-enter-from,
.fade-slide-up-leave-to {
	opacity: 0;
	transform: translateY(20px);
}

.fade-slide-up-enter-to,
.fade-slide-up-leave-from {
	opacity: 1;
	transform: translateY(0);
}
</style>
