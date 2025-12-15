<template>
	<DefaultLayout>
		<BreadcrumbDefault :page-title="pageTitle" />
		
        <div v-if="loadingSekolah" class="flex justify-center py-20">
            <span class="loading loading-spinner loading-lg text-primary"></span>
        </div>

        <div v-else-if="!sekolahData" class="flex flex-col items-center justify-center py-20 text-gray-500">
            <HeroIcon name="exclamation-circle" class="h-16 w-16 mb-4 text-gray-400" />
            <p class="text-xl font-semibold">Data Sekolah Tidak Ditemukan</p>
            <button @click="$router.push({ name: 'masterSekolah' })" class="btn btn-primary mt-4 text-white">
                Kembali ke Master Data
            </button>
        </div>

        <div v-else class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ sekolahData.nama_sekolah }}</h2>
                    <p class="text-sm text-gray-500">NPSN: {{ sekolahData.npsn }} | NSS: {{ sekolahData.nss }}</p>
                </div>
                <div class="flex gap-2">
                     <button v-if="mode === 'view'" @click="mode = 'edit'" class="btn btn-sm btn-outline btn-primary">
                        <HeroIcon name="document-text" class="w-4 h-4 mr-1" /> Edit
                    </button>
                    <button v-if="mode === 'edit'" @click="mode = 'view'" class="btn btn-sm btn-ghost">
                        Batal
                    </button>
                </div>
            </div>

            <!-- Reuse SekolahFormModal logic but inline or wrapped? 
                 Actually, SekolahFormModal is a modal. For a full page view, I should probably reuse the form logic or Component.
                 But since SekolahFormModal is mostly content, I can't easily extract the form without refactoring.
                 For speed and to respect the 'Aesthetic' requirement, I will recreate the layout here matching ProfileSekolahView style but editable.
            -->
            
            <div class="p-6">
                <form @submit.prevent="submitForm">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <InputGroup v-model="form.nama_sekolah" label="Nama Sekolah" name="nama_sekolah" required :disabled="mode === 'view'" />
                        <InputGroup v-model="form.nama_kepsek" label="Kepala Sekolah" name="nama_kepsek" required :disabled="mode === 'view'" />
                        <InputGroup v-model="form.nss" label="NSS" name="nss" inputmode="numeric" :disabled="mode === 'view'" />
                        <InputGroup v-model="form.npsn" label="NPSN" name="npsn" inputmode="numeric" :disabled="mode === 'view'" />
                        <InputGroup v-model="form.jenjang" label="Jenjang" name="jenjang" required :disabled="mode === 'view'" />
                        <InputGroup v-model="form.daya_tampung" label="Daya Tampung" name="daya_tampung" inputmode="numeric" :disabled="mode === 'view'" />
                        <InputGroup v-model="form.no_telp" label="No. Telepon" name="no_telp" inputmode="tel" :disabled="mode === 'view'" />
                        <InputGroup v-model="form.email" label="Email Sekolah" name="email" type="email" required :disabled="mode === 'view'" />
                        <InputGroup v-model="form.alamat" label="Alamat" name="alamat" required :disabled="mode === 'view'" />
                        <InputGroup v-model="form.username" label="Username Akun" name="username" :disabled="mode === 'view'" />
                        <InputGroup v-model="form.password" label="Password Akun (Isi jika ingin mengubah)" name="password" type="password" :disabled="mode === 'view'" placeholder="Kosongkan jika tidak ingin mengubah" />

                        <div class="flex flex-col gap-1">
                            <label class="mb-1 block text-black">Kecamatan</label>
                            <select
                                v-model="form.kecamatan_id"
                                class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 text-black outline-none transition focus:border-primary active:border-primary disabled:bg-gray-100 disabled:cursor-not-allowed"
                                :disabled="mode === 'view'">
                                <option value="" disabled>Pilih Kecamatan</option>
                                <option v-for="kec in kecamatanList" :key="kec.id" :value="kec.id">{{ kec.nama }}</option>
                            </select>
                        </div>
                    </div>

                    <div v-if="mode === 'edit'" class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <button type="button" @click="mode = 'view'" class="btn btn-ghost">Batal</button>
                        <button type="submit" class="btn btn-primary text-white" :disabled="submitting">
                            <span v-if="submitting" class="loading loading-spinner loading-xs mr-2"></span>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

	</DefaultLayout>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted, computed, watch } from "vue"
import { useRoute } from "vue-router"
import DefaultLayout from "@/layouts/DefaultLayout.vue"
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue"
import InputGroup from "@/components/Forms/InputGroup.vue"
import HeroIcon from "@/components/Icon/HeroIcon.vue"
import { useSekolah } from "@/composable/useSekolah"
import { useKecamatan } from "@/composable/useKecamatan"
import type { School } from "@/types"
import { showToast } from "@/utils/ui/toast"

const route = useRoute()
const { fetchSekolahById, updateSekolah, loadingSekolah } = useSekolah()
const { kecamatanList, fetchKecamatan } = useKecamatan()

const sekolahData = ref<School | null>(null)
const mode = ref<'view' | 'edit'>('view')
const submitting = ref(false)

const pageTitle = computed(() => {
    if (mode.value === 'edit') return 'Edit Data Sekolah'
    return 'Detail Data Sekolah'
})

const form = reactive({
	nama_sekolah: "",
	nss: "",
	npsn: "",
	jenjang: "",
	alamat: "",
	no_telp: "",
	email: "",
	nama_kepsek: "",
	kecamatan_id: "",
	daya_tampung: "",
    username: "",
    password: "",
})

const syncForm = (data: School) => {
	form.nama_sekolah = data.nama_sekolah || ""
	form.nss = data.nss || ""
	form.npsn = data.npsn || ""
	form.jenjang = data.jenjang || ""
	form.alamat = data.alamat || ""
	form.no_telp = data.no_telp || ""
	form.email = data.email || ""
	form.nama_kepsek = data.nama_kepsek || ""
	form.kecamatan_id = (data.kecamatan_id || (data.kecamatan as any)?.id || "").toString()
	form.daya_tampung = data.daya_tampung?.toString() || ""
    form.username = data.user?.username || ""
    form.password = ""
}

const loadData = async () => {
    const id = route.params.id as string
    if (id) {
        const data = await fetchSekolahById(id)
        if (data) {
            sekolahData.value = data
            syncForm(data)
        }
    }
}

const submitForm = async () => {
    if (!sekolahData.value) return
    submitting.value = true
    const success = await updateSekolah(sekolahData.value.id, { ...form })
    submitting.value = false
    
    if (success) {
        showToast({ message: "Data sekolah berhasil diperbarui" })
        mode.value = 'view'
        loadData() // Reload to get fresh data
    } else {
        showToast({ message: "Gagal memperbarui data sekolah", type: 'error' })
    }
}

onMounted(async () => {
    if (route.query.mode === 'edit') {
        mode.value = 'edit'
    }
    await fetchKecamatan()
    await loadData()
})
</script>
