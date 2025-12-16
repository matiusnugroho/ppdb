package models

import "time"

// School represents a school accepting registrations.
type School struct {
	ID          string    `db:"id" json:"id"`
	NamaSekolah string    `db:"nama_sekolah" json:"nama_sekolah"`
	Jenjang     string    `db:"jenjang" json:"jenjang"`
	KecamatanID string    `db:"kecamatan_id" json:"kecamatan_id"`
	DayaTampung int       `db:"daya_tampung" json:"daya_tampung"`
	CreatedAt   time.Time `db:"created_at" json:"created_at"`
	UpdatedAt   time.Time `db:"updated_at" json:"updated_at"`
}

// RegistrationPath describes how a student can register (zonasi, afirmasi, etc).
type RegistrationPath struct {
	ID          int64  `db:"id" json:"id"`
	Name        string `db:"name" json:"name"`
	Description string `db:"description" json:"description"`
}

// RegistrationPeriod is a window in which registrations are open.
type RegistrationPeriod struct {
	ID        int64     `db:"id" json:"id"`
	Name      string    `db:"name" json:"name"`
	StartDate time.Time `db:"start_date" json:"start_date"`
	EndDate   time.Time `db:"end_date" json:"end_date"`
	IsOpen    bool      `db:"is_open" json:"is_open"`
}

// Student represents a student that can register.
type Student struct {
	ID           string    `db:"id" json:"id"`
	Nama         string    `db:"nama" json:"nama"`
	NIK          string    `db:"nik" json:"nik"`
	JenisKelamin string    `db:"jenis_kelamin" json:"jenis_kelamin"`
	TanggalLahir time.Time `db:"tanggal_lahir" json:"tanggal_lahir"`
	CreatedAt    time.Time `db:"created_at" json:"created_at"`
}

// Registration ties a student to a school within a period and path.
type Registration struct {
	ID                   int64     `db:"id" json:"id"`
	StudentID            string    `db:"student_id" json:"student_id"`
	SchoolID             string    `db:"school_id" json:"school_id"`
	RegistrationPathID   int64     `db:"registration_path_id" json:"registration_path_id"`
	RegistrationPeriodID int64     `db:"registration_period_id" json:"registration_period_id"`
	Status               string    `db:"status" json:"status"`
	Kelulusan            string    `db:"kelulusan" json:"kelulusan"`
	CreatedAt            time.Time `db:"created_at" json:"created_at"`
}

type RegistrationDetail struct {
	Registration
	SchoolName       string `db:"school_name" json:"school_name"`
	StudentName      string `db:"student_name" json:"student_name"`
	RegistrationPath string `db:"registration_path" json:"registration_path"`
	PeriodName       string `db:"period_name" json:"period_name"`
}
