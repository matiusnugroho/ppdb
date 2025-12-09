<script setup lang="ts">
import HeroIcon from "@/components/Icon/HeroIcon.vue"
</script>

<template>
	<div class="min-h-screen bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
			<!-- Header -->
			<div class="bg-blue-600 px-8 py-10 text-center">
				<h1 class="text-3xl font-bold text-white mb-2">Persyaratan Pendaftaran</h1>
				<p class="text-blue-100 text-lg">Dokumen yang perlu dipersiapkan untuk PPDB Kuantan Singingi.</p>
			</div>

			<!-- Content -->
			<div class="p-8 md:p-12 space-y-8">
				
				<!-- Requirement List -->
				<div class="space-y-6">
					<div class="flex gap-4 items-start">
						<div class="flex-shrink-0 mt-1">
							<div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
								<HeroIcon name="academic-cap" class="w-6 h-6" />
							</div>
						</div>
						<div>
							<h3 class="text-lg font-bold text-gray-900">Ijazah / Surat Keterangan Lulus</h3>
							<p class="text-gray-600 mt-1">Scan asli Ijazah atau Surat Keterangan Lulus (SKL) dari jenjang pendidikan sebelumnya (SD/MI/Sederajat).</p>
						</div>
					</div>

					<div class="border-t border-gray-100 my-4"></div>

					<div class="flex gap-4 items-start">
						<div class="flex-shrink-0 mt-1">
							<div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
								<HeroIcon name="document-text" class="w-6 h-6" />
							</div>
						</div>
						<div>
							<h3 class="text-lg font-bold text-gray-900">Nilai Rapor</h3>
							<p class="text-gray-600 mt-1">Scan asli nilai rapor 5 semester terakhir yang telah dilegalisir.</p>
						</div>
					</div>

					<div class="border-t border-gray-100 my-4"></div>

					<div class="flex gap-4 items-start">
						<div class="flex-shrink-0 mt-1">
							<div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
								<HeroIcon name="user-circle" class="w-6 h-6" />
							</div>
						</div>
						<div>
							<h3 class="text-lg font-bold text-gray-900">Akta Kelahiran & KK</h3>
							<p class="text-gray-600 mt-1">Scan asli Akta Kelahiran dan Kartu Keluarga (KK) terbaru (minimal diterbitkan 1 tahun sebelum pendaftaran).</p>
						</div>
					</div>

					<div class="border-t border-gray-100 my-4"></div>

					<div class="flex gap-4 items-start">
						<div class="flex-shrink-0 mt-1">
							<div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600">
								<HeroIcon name="document-check" class="w-6 h-6" />
							</div>
						</div>
						<div>
							<h3 class="text-lg font-bold text-gray-900">Surat Pernyataan Keabsahan Dokumen</h3>
							<p class="text-gray-600 mt-1">
								Surat pernyataan mutlak keabsahan dokumen yang ditandatangani di atas materai Rp 10.000.
							</p>
							<div class="mt-4">
								<a 
									href="/storage/surat_pernyataan_keabsahan_dokumen.pdf" 
									target="_blank"
									class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 border border-gray-200 transition-colors text-sm font-medium"
								>
									<HeroIcon name="arrow-up-tray" class="w-4 h-4" />
									Download Template Surat
								</a>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</template>
