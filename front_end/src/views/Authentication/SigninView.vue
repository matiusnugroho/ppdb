<script setup lang="ts">
import DefaultAuthCard from '@/components/Auths/DefaultAuthCard.vue'
import InputGroup from '@/components/Forms/InputGroup.vue'
import PasswordInput from '@/components/Forms/PasswordInput.vue'
import PlainLayout from '@/layouts/PlainLayout.vue'
import { useAuthStore } from '@/stores/auth'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import '@/style.css'
import { ref } from 'vue'
import { FwbSpinner } from 'flowbite-vue'

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
        <PasswordInput label="Password anda" v-model="passwordValue" />
        <div class="mb-5 mt-6">
          <button
            type="button"
            class="w-full flex justify-center items-center cursor-pointer rounded-lg border border-primary bg-primary p-2 font-medium text-white transition hover:bg-opacity-90"
            @click="toasting"
            :disabled="loginLoading"
          >
            <span class="flex items-center">
              <fwb-spinner v-if="loginLoading" size="4" color="white" />
              <span class="ml-2">Login</span>
            </span>
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
