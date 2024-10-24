<script setup lang="ts">
import DashboardAdmin from "@/components/Dashboard/DashboardAdmin.vue"
import DashboardSekolah from "@/components/Dashboard/DashboardSekolah.vue"
import DashboardSiswa from "@/components/Dashboard/DashboardSiswa.vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { useAuthStore } from "@/stores/auth"
import { ref, type Component } from "vue"
const currentComponent = ref<Component | null>(null)
const authstore = useAuthStore()
const role = authstore.role
switch (role) {
	case "siswa":
		currentComponent.value = DashboardSiswa
		break
	case "sekolah":
		currentComponent.value = DashboardSekolah
		break
	case "super_admin":
		currentComponent.value = DashboardAdmin
		break
}
</script>

<template>
	<DefaultLayout>
		<component :is="currentComponent" />
	</DefaultLayout>
</template>
