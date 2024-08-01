<script setup lang="ts">
import DefaultAuthCard from '@/components/Auths/DefaultAuthCard.vue'
import InputGroup from '@/components/Forms/InputGroup.vue'
import PlainLayout from '@/layouts/PlainLayout.vue'
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css'
import '@/style.css'

import { ref } from 'vue'
const emailValue = ref('')
const passwordValue = ref('')

const toasting = () => {
  toast("Wow so easy!", {
    autoClose: 100000,
    progressClassName: 'custom-progress-bar'
  })
}
</script>

<template>
  <PlainLayout>
    <DefaultAuthCard subtitle="PPDB Kuantan Singingi" title="Login">
      <form>
        <InputGroup label="Email / Username" type="email" placeholder="Enter your email" v-model="emailValue"/>
        {{ emailValue }}
        <InputGroup label="Password" type="password" placeholder="6+ Characters, 1 Capital letter" v-model="passwordValue"/>
        <div class="mb-5 mt-6">
          <button
            type="button"
            class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-2 font-medium text-white transition hover:bg-opacity-90"
            @click="toasting"
          >Sign in</button>
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
