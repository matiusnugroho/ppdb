// config/endpoint.ts

import type { endpoints } from "@/types"
const BASE_URL = "/"
const BASE_URL_API = "/api"

// Define endpoints
const ENDPOINTS: endpoints = {
	BASE_URL,
	LOGIN: `${BASE_URL_API}/auth/login`,
	LOGOUT: `${BASE_URL_API}/auth/logout`,
	ME_SISWA: `${BASE_URL_API}/siswa/me`,
	ME_SEKOLAH: `${BASE_URL_API}/sekolah/me`,
	REGISTER_SISWA: `${BASE_URL_API}/siswa/register`,
	REGISTER_SEKOLAH: `${BASE_URL_API}/sekolah/register`,
	UPDATE_PHOTO_SISWA: `${BASE_URL_API}/siswa/update-foto`,
	UPDATE_SEKOLAH_ME: `${BASE_URL_API}/sekolah/me`,
	GET_KECAMATAN: `${BASE_URL_API}/kecamatan/`,
	GET_SEKOLAH_ALL: `${BASE_URL_API}/sekolah`,
	GET_SEKOLAH: `${BASE_URL_API}/sekolah/kecamatan/{kecamatan_id}/{jenjang}`,
	GET_SEKOLAH_BY_ID: `${BASE_URL_API}/sekolah/{id}`,
	UPDATE_SEKOLAH: `${BASE_URL_API}/sekolah/{id}`,
	CSRF: `${BASE_URL_API}/sanctum/csrf-cookie`,
	DAFTAR_KE_SEKOLAH: `${BASE_URL_API}/pendaftaran/daftar`,
	BUKA_PENDAFTARAN: `${BASE_URL_API}/admin/pendaftaran/buka-pendaftaran`,
	TUTUP_PENDAFTARAN: `${BASE_URL_API}/admin/pendaftaran/tutup-pendaftaran`,
	GET_ALL_PERIODS: `${BASE_URL_API}/registration/get-all`,
	CEK_PENDAFTARAN: `${BASE_URL_API}/pendaftaran/cek-pendaftaran`,
	GET_PENDAFTAR: `${BASE_URL_API}/pendaftaran/get-pendaftar`,
	UPLOAD_DOKUMEN: `${BASE_URL_API}/pendaftaran/upload_dokumen/{id_dokumen}`,
	VERIFIKASI_DOKUMEN: `${BASE_URL_API}/pendaftaran/verifikasi_dokumen/{id_dokumen}`,
	REJECT_DOKUMEN: `${BASE_URL_API}/pendaftaran/reject_dokumen/{id_dokumen}`,
	REVISI_DOKUMEN: `${BASE_URL_API}/pendaftaran/revisi_dokumen/{id_dokumen}`,
	GET_DOCUMENT_TYPE: `${BASE_URL_API}/pendaftaran/dokumen`,
	VERIFIKASI_PENDAFTARAN: `${BASE_URL_API}/pendaftaran/verifikasi`,
	GET_VERIFIED_BY_ME: `${BASE_URL_API}/pendaftaran/verified_by_me`,
	DETAIL_VERIFIKASI: `${BASE_URL_API}/pendaftaran/detail/{id}`,
	LULUSKAN: `${BASE_URL_API}/pendaftaran/luluskan/{id}`,
	GET_PENDAFTARAN: `${BASE_URL_API}/pendaftaran/get-pendaftaran`,
	STATISTIK_SEKOLAH: `${BASE_URL_API}/statistik/sekolah`,
	STATISTIK_ADMIN: `${BASE_URL_API}/statistik/admin`,
	STATISTIK_PUBLIC: `${BASE_URL_API}/statistik/`,
	DOWNLOAD_EXCEL_SEKOLAH: `/sekolah/excel`,
	DOWNLOAD_EXCEL_SEKOLAH_WITH_DATA: `/sekolah/excel-with-data`,
	IMPORT_SEKOLAH: `${BASE_URL_API}/sekolah/import`,
	UPDATE_AKUN_ADMIN: `${BASE_URL_API}/admin/akun/update`,
	GET_JALUR: `${BASE_URL_API}/jalur`,
	GET_JALUR_PERSYARATAN: `${BASE_URL_API}/jalur/{id}/persyaratan`,
	GET_JALUR_DENGAN_PERSYARATAN: `${BASE_URL_API}/jalur/persyaratan`,
	GET_SETTING: `${BASE_URL_API}/setting`,
	UPDATE_SETTING: `${BASE_URL_API}/admin/setting/update`,
	PERSYARATAN: `${BASE_URL_API}/admin/persyaratan-jalur`,

	GANTI_PASSWORD: `${BASE_URL_API}/auth/change-password`,
}

// Helper function to replace placeholders with actual values
const replacePlaceholder = (url: string, params: Record<string, string | number>) => {
	return Object.keys(params).reduce((acc, key) => {
		return acc.replace(`{${key}}`, encodeURIComponent(params[key].toString()))
	}, url)
}

// Export endpoints and helper function
export { ENDPOINTS, replacePlaceholder }
