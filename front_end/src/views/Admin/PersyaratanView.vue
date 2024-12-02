<script setup lang="ts">
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import { usePersyaratan } from "@/composable/usePersyaratan"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import { onMounted } from "vue"

const { fetchPersyaratan, persyaratan } = usePersyaratan()

onMounted(async () => {
	await fetchPersyaratan()
	console.log(persyaratan.value)
})
</script>

<template>
	<DefaultLayout>
		<BreadcrumbDefault pageTitle="Persyaratan" />
		<div>
			<h2 class="text-2xl font-bold mb-4">Requirements Table by Path and Jenjang</h2>
			<div v-for="(jenjangs, pathName) in persyaratan" :key="pathName" class="mb-8">
				<h3 class="text-lg font-semibold mb-2">{{ pathName }}</h3>
				<table class="min-w-full border-collapse border border-gray-200">
					<thead>
						<tr>
							<th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Jenjang</th>
							<th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Requirements</th>
							<th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Wajib</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="(requirements, jenjang) in jenjangs" :key="jenjang">
							<tr v-if="requirements.length > 0">
								<td class="border border-gray-300 px-4 py-2 font-medium" :rowspan="requirements.length">
									{{ jenjang }}
								</td>
								<td class="border border-gray-300 px-4 py-2">
									{{ requirements[0].document_type.label || "Unknown Document" }}
								</td>
								<td class="border border-gray-300 px-4 py-2">
									<span v-if="requirements[0].is_required" class="text-green-500">✅</span>
									<span v-else class="text-red-500">❌</span>
								</td>
							</tr>
							<tr v-for="requirement in requirements.slice(1)" :key="requirement.id">
								<td class="border border-gray-300 px-4 py-2">
									{{ requirement.document_type.label || "Unknown Document" }}
								</td>
								<td class="border border-gray-300 px-4 py-2">
									<span v-if="requirement.is_required" class="text-green-500">✅</span>
									<span v-else class="text-red-500">❌</span>
								</td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>
		</div>
	</DefaultLayout>
</template>
