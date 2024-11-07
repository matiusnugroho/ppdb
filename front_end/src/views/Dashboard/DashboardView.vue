<script setup lang="ts">
import DashboardAdmin from "@/components/Dashboard/DashboardAdmin.vue"
import DashboardSekolah from "@/components/Dashboard/DashboardSekolah.vue"
import DashboardSiswa from "@/components/Dashboard/DashboardSiswa.vue"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { useAuthStore } from "@/stores/auth"
import { ref, type Component, markRaw } from "vue"
const currentComponent = ref<Component | null>(null)
const authstore = useAuthStore()
const role = authstore.role

const components = {
	DashboardAdmin: markRaw(DashboardAdmin),
	DashboardSekolah: markRaw(DashboardSekolah),
	DashboardSiswa: markRaw(DashboardSiswa),
}
switch (role) {
	case "siswa":
		currentComponent.value = components.DashboardSiswa
		break
	case "sekolah":
		currentComponent.value = components.DashboardSekolah
		break
	case "super_admin":
		currentComponent.value = components.DashboardAdmin
		break
}
</script>

<template>
	<DefaultLayout>
		<component :is="currentComponent" />
	</DefaultLayout>
</template>
