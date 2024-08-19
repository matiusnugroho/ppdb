<script setup lang="ts">
import DefaultAuthCard from "@/components/Auths/DefaultAuthCard.vue"
import InputGroup from "@/components/Forms/InputGroup.vue"
import PasswordInput from "@/components/Forms/PasswordInput.vue"
import PlainLayout from "@/layouts/PlainLayout.vue"
import DarkModeSwitcher from "@/components/Header/DarkModeSwitcher.vue"
import { FwbAlert, FwbSpinner } from "flowbite-vue"
import "@/style.css"
import { onMounted, ref } from "vue"
import { useAuth } from "@/composable/authComposable"
import { showToast } from "@/utils/ui/toast"
import { getCSRFToken } from "@/services/csrf"
import { useRoute } from "vue-router"
import { useAuthStore } from "@/stores/auth"
import AlertSuccess from "@/components/Alerts/AlertSuccess.vue"

const emailValue = ref("")
const passwordValue = ref("")
const loginLoading = ref(false)
const loginGagal = ref(false)
const loginGagalMessage = ref("")

const { login } = useAuth()
const route = useRoute()
const authStore = useAuthStore()

const ambilCSRFToken = async () => {
	try {
		await getCSRFToken()
	} catch (error) {
		console.error(error)
		showToast({
			message: "Gagal mengambil CSRF token, silakan muat ulang halaman login ini",
			type: "error",
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
		if (error?.response?.status === 401 || error?.response?.status === 422) {
			loginGagal.value = true
			loginGagalMessage.value = "Username atau password salah"
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
	await ambilCSRFToken()
})
</script>

<template>
	<PlainLayout>
		<div class="flex justify-center">
			<DarkModeSwitcher />
		</div>
		<DefaultAuthCard subtitle="PPDB Online Kuantan Singingi v1" title="Login">
				<div class="mb-5 mt-6 animate-bottomtop" v-if="loginGagal">
					<fwb-alert icon type="danger">{{ loginGagalMessage }}</fwb-alert>
				</div>
			<AlertSuccess class="mb-5" message="Pendaftaran PPDB Online Kuantan Singingi v1 Berhasil!" detail="Silakan login dengan akun yang sudah didaftarkan" />
			<form @submit.prevent="handleLogin">
				<InputGroup label="Email / Username" type="email" placeholder="Enter your email" v-model="emailValue" />
				<PasswordInput label="Password anda" v-model="passwordValue" />
				<div class="mb-5 mt-6">
					<button
						type="submit"
						class="w-full flex justify-center items-center cursor-pointer rounded-lg border border-primary bg-primary p-2 font-medium text-white transition hover:bg-opacity-90"
						@click="handleLogin"
						:disabled="loginLoading">
						<span class="flex items-center">
							<fwb-spinner v-if="loginLoading" size="4" color="white" />
							<span class="ml-2">Login</span>
						</span>
					</button>
				</div>

				<div class="mt-6 text-center">
					<p class="font-medium">
						Belum Mempunyai Akun?
						<router-link to="/daftar" class="text-primary">Daftar</router-link>
					</p>
				</div>
			</form>
		</DefaultAuthCard>
	</PlainLayout>
</template>
