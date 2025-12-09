<script setup lang="ts">
import StatsCardComponent from "@/components/UI/StatsCardComponent.vue"
import LoadingInfoComponent from "@/components/UI/LoadingInfoComponent.vue"
import { useStatistik } from "@/composable/useStatistik"
import { usePendaftaran } from "@/composable/usePendaftaran"
import { onMounted, ref, computed } from "vue"
import { showToast } from "@/utils/ui/toast"
import BreadcrumbDefault from "../Breadcrumbs/BreadcrumbDefault.vue"
import TabelSekolahWithDataComponent from "./TabelSekolahWithDataComponent.vue"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import ModalComponent from "@/components/UI/ModalComponent.vue"

const { statistik, fetchStatistik, error, loadingStatistik } = useStatistik()
const { bukaPendaftaran, tutupPendaftaran, loadingPendaftar } = usePendaftaran()

const modalOpen = ref<InstanceType<typeof ModalComponent> | null>(null)
const formData = ref({
	tahun_ajaran: "",
	start_date: "",
	end_date: "",
})

const isPeriodOpen = computed(() => {
	return statistik.value?.tahun_ajaran !== '-' && statistik.value?.tahun_ajaran !== undefined;
})

onMounted(() => {
	fetchData()
})

const fetchData = () => {
	fetchStatistik()
	if (error.value) {
		console.error(error)
		showToast({
			message: error?.toString() ?? "An unknown error occurred",
			type: "error",
		})
	}
}

const handleOpenModal = () => {
	formData.value = {
		tahun_ajaran: "",
		start_date: new Date().toISOString().split('T')[0],
		end_date: "",
	}
	modalOpen.value?.show()
}

const confirmClosePeriod = async () => {
	if (confirm("Apakah anda yakin ingin menutup tahun ajaran ini?")) {
		const res = await tutupPendaftaran()
		if (res.success) {
			showToast({ message: "Pendaftaran berhasil ditutup", type: "success" })
			fetchData()
		} else {
			showToast({ message: res.message ?? "Gagal menutup pendaftaran", type: "error" })
		}
	}
}

const submitNewPeriod = async () => {
	const res = await bukaPendaftaran(formData.value)
	if (res.id) { // Assuming success returns the period object with ID
		showToast({ message: "Tahun ajaran berhasil dibuka", type: "success" })
		modalOpen.value?.close()
		fetchData()
	} else {
		showToast({ message: res.message ?? "Gagal membuka pendaftaran", type: "error" })
	}
}
</script>

<template>
	<BreadcrumbDefault pageTitle="Dashboard" />
	<LoadingInfoComponent v-if="loadingStatistik" />
	<div v-else class="space-y-6">
		<!-- Status Tahun Ajaran Card -->
		<div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
			<div class="flex items-center gap-4">
				<div class="p-3 rounded-full" :class="isPeriodOpen ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'">
					<HeroIcon name="calendar" class="w-8 h-8" />
				</div>
				<div>
					<h3 class="font-bold text-gray-800 text-lg">Status Tahun Ajaran</h3>
					<div class="text-sm text-gray-500">
						<span v-if="isPeriodOpen" class="font-medium text-green-600">Aktif: {{ statistik?.tahun_ajaran }} ({{ statistik?.periode }})</span>
						<span v-else class="font-medium text-red-500">Tidak ada tahun ajaran aktif</span>
					</div>
				</div>
			</div>
			<div>
				<button v-if="isPeriodOpen" @click="confirmClosePeriod" :disabled="loadingPendaftar" class="btn btn-error text-white btn-sm px-6">
					Tutup Pendaftaran
				</button>
				<button v-else @click="handleOpenModal" class="btn btn-primary text-white btn-sm px-6">
					Buka Pendaftaran Baru
				</button>
			</div>
		</div>

		<div class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
			<StatsCardComponent icon="document-check" label="Sekolah" :value="statistik?.sekolah" color="blue" />
			<StatsCardComponent icon="document-check" label="SD" :value="statistik?.sd" color="orange" />
			<StatsCardComponent icon="document-check" label="SMP" :value="statistik?.smp" color="orange" />
			<StatsCardComponent icon="calendar" :label="statistik?.periode as string" :value="statistik?.tahun_ajaran" color="orange" />
		</div>
		<div class="row mt-4">
			<TabelSekolahWithDataComponent />
		</div>

		<!-- Modal Buka Pendaftaran -->
		<ModalComponent 
			ref="modalOpen" 
			title="Buka Tahun Ajaran Baru" 
			confirmLabel="Buka Pendaftaran" 
			:confirmHandler="submitNewPeriod" 
			:loading="loadingPendaftar"
		>
			<div class="space-y-4 py-4">
				<div class="form-control">
					<label class="label"><span class="label-text">Tahun Ajaran</span></label>
					<input v-model="formData.tahun_ajaran" type="text" placeholder="Contoh: 2025/2026" class="input input-bordered w-full" />
				</div>
				<div class="grid grid-cols-2 gap-4">
					<div class="form-control">
						<label class="label"><span class="label-text">Tanggal Mulai</span></label>
						<input v-model="formData.start_date" type="date" class="input input-bordered w-full" />
					</div>
					<div class="form-control">
						<label class="label"><span class="label-text">Tanggal Selesai</span></label>
						<input v-model="formData.end_date" type="date" class="input input-bordered w-full" />
					</div>
				</div>
			</div>
		</ModalComponent>
	</div>
</template>
