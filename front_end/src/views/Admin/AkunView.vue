<script setup lang="ts">
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import InputGroup from "@/components/Forms/InputGroup.vue"
import PasswordInput from "@/components/Forms/PasswordInput.vue"
import SpinnerLoading from "@/components/UI/SpinnerLoading.vue"
import { useAkun } from "@/composable/useAkun"
import { useSetting } from "@/composable/useSetting"
import { field_error_html } from "@/helpers/fieldErrorHtml"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { useAuthStore } from "@/stores/auth"
import { useFormValidationErrorsStore } from "@/stores/formValidationErrors"
import { showToast } from "@/utils/ui/toast"
import { computed, onMounted, ref } from "vue"
import { useRouter } from "vue-router"

const { settingData, fetchSetting, updateSetting, isLoading } = useSetting()

const authStore = useAuthStore()
const router = useRouter()
const { loadingAkun, updateAkun } = useAkun()
const initialUsername = ref("")

const credentials = ref({
	username: authStore.user!.username,
	email: authStore.user!.email,
	currentPassword: "",
	newPassword: "",
	confirmPassword: "",
})
const instagram = computed({
	get: () => settingData.value.social_media?.instagram,
	set: (value: string) => {
		settingData.value.social_media!.instagram = value
	},
})

const twitter = computed({
	get: () => settingData.value.social_media?.twitter,
	set: (value: string) => {
		settingData.value.social_media!.twitter = value
	},
})

const tiktok = computed({
	get: () => settingData.value.social_media?.tiktok,
	set: (value: string) => {
		settingData.value.social_media!.tiktok = value
	},
})

const facebook = computed({
	get: () => settingData.value.social_media?.facebook,
	set: (value: string) => {
		settingData.value.social_media!.facebook = value
	},
})

const youtube = computed({
	get: () => settingData.value.social_media?.youtube,
	set: (value: string) => {
		settingData.value.social_media!.youtube = value
	},
})

const videoTutorial = computed({
    get: () => settingData.value.url_video_tutorial,
    set: (value: string) => {
        settingData.value.url_video_tutorial = value
    }
})
const formValidationErrors = useFormValidationErrorsStore()

const saveCredentials = async () => {
    // Filter credentials to keep only fields with non-empty values
    const filteredCredentials = Object.fromEntries(Object.entries(credentials.value).filter(([, value]) => value))
    const response = await updateAkun(filteredCredentials)
    if (response.success) {
        if (credentials.value.username !== initialUsername.value) {
            showToast({
                type: "success",
                message: "Username berhasil diubah, silakan login kembali",
            })
            await authStore.logout()
            router.push({ name: "login" })
        } else {
            showToast({
                type: "success",
                message: "Akun berhasil diperbarui",
            })
        }
    } else {
        const errors = response.errors
        formValidationErrors.errors = errors
        showToast({
            type: "error",
            message: response.message,
        })
    }
}

const saveSocialMedia = async () => {
	const data = {
		url_video_tutorial: videoTutorial.value,
		social_media: {
			instagram: instagram.value as string,
			twitter: twitter.value as string,
			tiktok: tiktok.value as string,
            facebook: facebook.value as string,
            youtube: youtube.value as string,
		},
	}

	const response = await updateSetting(data)
    if (response?.success) {
        showToast({
            type: "success",
            message: "Pengaturan berhasil disimpan",
        })
    } else {
        showToast({
            type: "error",
            message: response?.message || "Gagal menyimpan pengaturan",
        })
    }
}
onMounted(async () => {
	formValidationErrors.clearErrors()
	await fetchSetting()
    
    // Ensure credentials are synced with store
    if (authStore.user) {
        initialUsername.value = authStore.user.username
        credentials.value.username = authStore.user.username
        credentials.value.email = authStore.user.email
    }

	console.log(settingData.value.social_media!.facebook)
})
</script>

<template>
	<DefaultLayout>
		<BreadcrumbDefault pageTitle="Akun" />
		<div class="min-h-screen">
			<div class="max-w-4xl mx-auto space-y-6 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6">
				<!-- Credentials Card -->
				<div class="bg-white dark:bg-boxdark rounded-lg shadow-sm border border-stroke dark:border-strokedark">
					<div class="p-6">
						<h2 class="text-xl font-semibold text-black dark:text-white">Ubah data akun</h2>
					</div>
					<div class="p-6 border-t border-stroke dark:border-strokedark space-y-4">
						<!-- Username -->
						<InputGroup v-model="credentials.username" label="Username" name="username" placeholder="Enter new username">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<circle cx="12" cy="12" r="4" />
								<path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8" />
							</svg>
						</InputGroup>

						<InputGroup v-model="credentials.email" label="Email" name="email" placeholder="Email baru">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<circle cx="12" cy="12" r="4" />
								<path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8" />
							</svg>
						</InputGroup>
						<!-- Current Password -->
						<PasswordInput v-model="credentials.currentPassword" label="Password sekarang" name="currentPassword" type="password" placeholder="Masukkan password sekarang" />
						<div v-html="field_error_html('currentPassword')"></div>
						<!-- New Password -->
						<PasswordInput v-model="credentials.newPassword" label="Pawword Baru" name="newPassword" type="password" placeholder="Enter new password" />
					</div>
					<div class="p-6 border-t border-stroke dark:border-strokedark flex justify-end">
						<button @click="saveCredentials" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
							<span class="flex items-center gap-2">
								<SpinnerLoading :loading="loadingAkun" size="xs" />
								Simpan
							</span>
						</button>
					</div>
				</div>

				<!-- Social Media Card -->
				<div v-if="authStore.role === 'super_admin'" class="bg-white dark:bg-boxdark rounded-lg shadow-sm border border-stroke dark:border-strokedark">
					<div class="p-6">
						<h2 class="text-xl font-semibold text-black dark:text-white">Pengaturan Global & Media Sosial</h2>
					</div>
					<div class="p-6 border-t border-stroke dark:border-strokedark space-y-4">
                        <!-- Video Tutorial -->
                         <InputGroup v-model="videoTutorial" label="Link Video Tutorial (Youtube)" name="videoTutorial" placeholder="https://youtube.com/watch?v=...">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33z"></path>
                                <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                            </svg>
						</InputGroup>

                        <div class="divider text-sm text-gray-400">Media Sosial</div>

						<!-- Facebook -->
						<InputGroup v-model="facebook" label="Facebook URL" name="facebook" placeholder="https://facebook.com/...">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
							</svg>
						</InputGroup>

						<!-- Instagram -->
						<InputGroup v-model="instagram" label="Instagram URL" name="instagram" placeholder="https://instagram.com/...">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
								<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
								<line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
							</svg>
						</InputGroup>

						<!-- Twitter -->
						<InputGroup v-model="twitter" label="Twitter / X URL" name="twitter" placeholder="https://twitter.com/...">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z" />
							</svg>
						</InputGroup>

                        <!-- Youtube Channel -->
						<InputGroup v-model="youtube" label="Youtube Channel URL" name="youtube" placeholder="https://youtube.com/@...">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33z"></path>
                                <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
							</svg>
						</InputGroup>

						<!-- TikTok -->
						<InputGroup v-model="tiktok" label="TikTok URL" name="tiktok" placeholder="https://tiktok.com/@...">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M21 8v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5z" />
								<path d="M10 12a3 3 0 1 1-3 3V6a3 3 0 0 1 3-3" />
							</svg>
						</InputGroup>
					</div>
					<div class="p-6 border-t border-stroke dark:border-strokedark flex justify-end">
						<button @click="saveSocialMedia" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
							<SpinnerLoading :loading="isLoading" size="xs" />
							<span>Simpan Pengaturan</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</DefaultLayout>
</template>
