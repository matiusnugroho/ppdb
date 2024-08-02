<script setup lang="ts">
import DefaultAuthCard from '@/components/Auths/DefaultAuthCard.vue'
import InputGroup from '@/components/Forms/InputGroup.vue'
import PlainLayout from '@/layouts/PlainLayout.vue'
import { useAuthStore } from '@/stores/auth'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import '@/style.css'
import { ref } from 'vue'
import requestor from '@/services/requestor'
import { ENDPOINTS } from '@/config/endpoint'

const emailValue = ref('')
const passwordValue = ref('')
const loginLoading = ref(false)

const authStore = useAuthStore()

const toasting = async () => {
  loginLoading.value = true
  try {
    // Use the login action from the auth store
    const response = await authStore.login(emailValue.value, passwordValue.value)
    toast('Login successful!', {
      autoClose: 10000,
      progressClassName: 'custom-progress-bar'
    })
    console.log({ response })
  } catch (error) {
    toast('Login failed. Please try again.', {
      autoClose: 10000,
      progressClassName: 'custom-progress-bar'
    })
    console.error('Login error:', error)
  } finally {
    loginLoading.value = false
  }
}

const me = async () => {
  try {
    // Use the login action from the auth store
    const response = await requestor.get(ENDPOINTS.ME_SISWA)
    console.log({ response })
  } catch (error) {
    console.error('Login error:', error)
  }
}
</script>

<template>
  <PlainLayout>
    <DefaultAuthCard subtitle="PPDB Online Kuantan Singingi v1" title="Login">
      <form>
        <InputGroup
          label="Email / Username"
          type="email"
          placeholder="Enter your email"
          v-model="emailValue"
        />
        <InputGroup
          label="Password"
          type="password"
          placeholder="6+ Characters, 1 Capital letter"
          v-model="passwordValue"
          autocomplete="current-password"
        />
        <div class="mb-5 mt-6">
          <button
            type="button"
            class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-2 font-medium text-white transition hover:bg-opacity-90"
            @click="toasting"
            :disabled="loginLoading"
          >
            <svg
              v-if="loginLoading"
              class="animate-spin h-5 w-5 mr-3 text-white"
              viewBox="0 0 24 24"
            ></svg>
            <span v-if="!loginLoading">Login</span>
            <span v-else>Sedang Login...</span>
          </button>
        </div>
        <div class="mb-5 mt-6">
          <button
            type="button"
            class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-2 font-medium text-white transition hover:bg-opacity-90"
            @click="me"
          >
            Me
          </button>
        </div>

        <div class="mt-6 text-center">
          <p class="font-medium">
            Belum Mempunyai Akun?
            <router-link to="/auth/signup" class="text-primary">Sign up</router-link>
          </p>
        </div>
      </form>
    </DefaultAuthCard>
  </PlainLayout>
</template>
