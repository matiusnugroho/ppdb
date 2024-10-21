<script setup lang="ts">
import DashboardSekolah from "@/components/Dashboard/DashboardSekolah.vue"
import DashboardSiswa from "@/components/Dashboard/DashboardSiswa.vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { useAuthStore } from "@/stores/auth"
import { ref, type Component } from "vue"
const currentComponent = ref<Component | null>(null)
const authstore = useAuthStore()
const role = authstore.role
currentComponent.value = role === "siswa" ? DashboardSiswa : DashboardSekolah
</script>

<template>
	<DefaultLayout>
			<component :is="currentComponent" />
	</DefaultLayout>
</template>
