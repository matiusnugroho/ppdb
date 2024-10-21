// config/endpoint.ts

import type { endpoints } from "@/types"

// Define base URL for your API
const BASE_URL = "/"
const BASE_URL_API = "/api"

// Define endpoints
const ENDPOINTS: endpoints = {
	BASE_URL,
	LOGIN: `${BASE_URL_API}/auth/login`,
	ME_SISWA: `${BASE_URL_API}/siswa/me`,
	REGISTER_SISWA: `${BASE_URL_API}/siswa/register`,
	REGISTER_SEKOLAH: `${BASE_URL_API}/sekolah/register`,
	UPDATE_PHOTO_SISWA: `${BASE_URL_API}/siswa/update-foto`,
	GET_KECAMATAN: `${BASE_URL_API}/kecamatan/`,
	GET_SEKOLAH: `${BASE_URL_API}/sekolah/kecamatan/{kecamatan_id}/{jenjang}`,
	CSRF: `${BASE_URL_API}/sanctum/csrf-cookie`,
	DAFTAR_KE_SEKOLAH: `${BASE_URL_API}/pendaftaran/daftar`,
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
}

// Helper function to replace placeholders with actual values
const replacePlaceholder = (url: string, params: Record<string, string | number>) => {
	return Object.keys(params).reduce((acc, key) => {
		return acc.replace(`{${key}}`, encodeURIComponent(params[key].toString()))
	}, url)
}

// Export endpoints and helper function
export { ENDPOINTS, replacePlaceholder }
