<script setup lang="ts">
import PhotoCard from "@/components/UI/PhotoCard.vue"
import { useAuthStore } from "@/stores/auth"
import InfoPendaftaranCard from "@/components/UI/InfoPendaftaranCard.vue"
const authstore = useAuthStore()
</script>

<template>
	<div class="flex flex-col space-y-4 md:flex-row md:space-x-4 md:space-y-0">
		<!-- PhotoCard on the left -->
		<div class="flex-1">
			<PhotoCard
				:photo_url="authstore.user!.student!.thumbnail_url"
				:nameText="authstore.user?.student.nama"
				:username="authstore.user?.username"
				:tanggal_lahir="authstore.user?.student.tanggal_lahir"
				:role="authstore.role!"
				class="h-full" />
		</div>

		<!-- InfoPendaftaranCard on the right -->
		<div class="flex-1">
			<InfoPendaftaranCard class="h-full" />
		</div>
	</div>
</template>
