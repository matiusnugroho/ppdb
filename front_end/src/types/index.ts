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
// Corrected syntax for interface
export interface ProfileSiswaRequest
  extends Omit<Student, "foto" | "foto_url" | "thumbnail_url" | "created_at" | "updated_at" | "id" | "user_id">,
    Pick<User, "username"> {
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
