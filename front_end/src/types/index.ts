// Define the interface for permissions
export interface Permission {
	id: number
	name: string
	guard_name: string
	created_at: string
	updated_at: string
	pivot: {
		role_id: number
		permission_id: number
	}
}

// Define the interface for roles
export interface Role {
	id: number
	name: string
	guard_name: string
	created_at: string
	updated_at: string
	pivot: {
		model_type: string
		model_id: number
		role_id: number
	}
	permissions: Permission[]
}

// Define the interface for student data
export interface Student {
	id: string // UUID as a string
	nisn: string
	nama: string
	tempat_lahir: string
	jenis_kelamin: string
	jenjang: string
	kecamatan_id: string
	tanggal_lahir: string // Date in ISO format (e.g., 'YYYY-MM-DD')
	nama_bapak: string
	nama_ibu: string
	nik: string
	no_kk: string
	no_hp_ortu: string
	foto: string // Path to the photo
	foto_url: string // URL to the photo
	user_id: number
	created_at: string
	updated_at: string
	thumbnail_url: string // URL to the thumbnail
}

export interface Kecamatan {
	id: number
	nama: string
}
export interface School {
	id: string // UUID as a string
	user_id: number
	user?: User
	jenjang: string
	kecamatan: Kecamatan
	created_at: string
	updated_at: string
	nama_sekolah: string
	nss: string
	path_counts: { [key: string]: number }
	npsn: string
	alamat: string
	no_telp: string
	nama_kepsek: string
	daya_tampung: number
	kecamatan_id: string
}

// Define the interface for user data
export interface User {
	id: number
	username: string
	email: string
	email_verified_at: string | null
	created_at: string
	updated_at: string
	permissions: Permission[]
	student: Student
	roles: Role[]
}

// Kecualikan data foto dan timestamps dari request
export interface ProfileSiswaRequest extends Omit<Student, "foto" | "foto_url" | "thumbnail_url" | "created_at" | "updated_at" | "id" | "user_id">, Pick<User, "username"> {
	id?: string // Optional id field
	user_id?: number // Optional user_id field
	password?: string // Optional password field
}

export interface ProfileSekolahRequest extends Omit<School, "created_at" | "updated_at" | "id" | "user_id" | "kecamatan">, Pick<User, "username"> {
	id?: string // Optional id field
	user_id?: number // Optional user_id field
	password?: string // Optional password field
}

export interface LoginResponseData {
	success: boolean
	data: {
		user: User
	}
}
export interface Registration {
	id: string
	school_id: string
	jenjang: string
	student_id: string
	kelulusan: string
	registration_period_id: string
	registration_number: string
	verified_by?: User | null
	school?: School
	created_at: string
	updated_at: string
}
export interface Pendaftar extends Registration {
	student: Student
	status: string
	documents: Document[]
}
export interface RegistrationRequest {
	school_id: string
	jenjang: string
}
export interface RegistrationResponse {
	registration: Registration | null
}
export interface Option {
	label: string
	value: string | number | null // Value can be string or number, depending on the data
}
export interface DokumenRequest {
	id_dokumen: string // The document ID as a string
	file: File // The file to be uploaded
	alasan?: string
}
export interface Document {
	id: string
	registration_id: string
	document_type_id: string
	path: string | null
	url_path: string | null
	status: string
	alasan: string
	created_at: string
	updated_at: string
	document_type?: DocumentType
	path_requirement?: Requirement
}
export interface DocumentType {
	id: string
	label: string
	created_at: string
	updated_at: string
}
export type Requirement = {
	id: number
	registration_path_id: number
	document_type_id: string
	is_required: boolean
	allowed_file_types?: string
	max_file_size?: number
	display_order?: number
	validation_rules?: string | null
	document_type?: DocumentType
	created_at: string // or Date if you want to parse it as a Date object
	updated_at: string // or Date if you want to parse it as a Date object
}
export type JalurPendaftaran = {
	id: number
	name: string
	description: string
	quota_percentage: number
	is_active?: boolean
	display_order?: number
	requirements?: Requirement[]
	created_at?: string
	updated_at?: string
}

export interface endpoints {
	[key: string]: string
}
export interface StatistikData {
	[key: string]: number | string | { [key: string]: number }
}

export interface DataSekolah {
	total: number
	currentPage: number
	prevPage: number | null
	nextPage: number | null
	lastPage: number
	data: School[]
}
