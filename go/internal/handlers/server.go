package handlers

import (
	"net/http"
	"time"

	"github.com/gin-gonic/gin"
	"github.com/google/uuid"
	"github.com/jmoiron/sqlx"

	"ppdb-go/internal/models"
)

// Server wires HTTP handlers with the database connection.
type Server struct {
	db *sqlx.DB
}

// NewServer constructs a Server.
func NewServer(db *sqlx.DB) *Server {
	return &Server{db: db}
}

// RegisterRoutes attaches handlers to the gin router.
func (s *Server) RegisterRoutes(r *gin.Engine) {
	r.GET("/health", func(c *gin.Context) {
		c.JSON(http.StatusOK, gin.H{"status": "ok"})
	})

	r.GET("/registration-paths", s.listRegistrationPaths)
	r.GET("/registration-periods/open", s.listOpenPeriods)
	r.POST("/registration-periods", s.createRegistrationPeriod)
	r.PATCH("/registration-periods/:id/state", s.updatePeriodState)

	r.GET("/schools", s.listSchools)
	r.POST("/schools", s.createSchool)
	r.GET("/schools/:id", s.getSchool)
	r.PUT("/schools/:id", s.updateSchool)

	r.POST("/students", s.createStudent)

	r.POST("/registrations", s.createRegistration)
	r.GET("/registrations/:id", s.getRegistration)
}

func (s *Server) listRegistrationPaths(c *gin.Context) {
	var paths []models.RegistrationPath
	if err := s.db.Select(&paths, `SELECT id, name, description FROM registration_paths ORDER BY id`); err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	c.JSON(http.StatusOK, paths)
}

func (s *Server) listOpenPeriods(c *gin.Context) {
	var periods []models.RegistrationPeriod
	if err := s.db.Select(&periods, `SELECT id, name, start_date, end_date, is_open FROM registration_periods WHERE is_open = 1 ORDER BY start_date DESC`); err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	c.JSON(http.StatusOK, periods)
}

func (s *Server) createRegistrationPeriod(c *gin.Context) {
	var payload struct {
		Name      string `json:"name" binding:"required"`
		StartDate string `json:"start_date" binding:"required"`
		EndDate   string `json:"end_date" binding:"required"`
		IsOpen    bool   `json:"is_open"`
	}
	if err := c.ShouldBindJSON(&payload); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	start, err := time.Parse("2006-01-02", payload.StartDate)
	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "invalid start_date"})
		return
	}
	end, err := time.Parse("2006-01-02", payload.EndDate)
	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "invalid end_date"})
		return
	}

	res, err := s.db.Exec(`INSERT INTO registration_periods (name, start_date, end_date, is_open) VALUES (?,?,?,?)`, payload.Name, start, end, payload.IsOpen)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	id, _ := res.LastInsertId()
	c.JSON(http.StatusCreated, gin.H{"id": id, "name": payload.Name, "start_date": payload.StartDate, "end_date": payload.EndDate, "is_open": payload.IsOpen})
}

func (s *Server) updatePeriodState(c *gin.Context) {
	var payload struct {
		IsOpen bool `json:"is_open"`
	}
	if err := c.ShouldBindJSON(&payload); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	res, err := s.db.Exec(`UPDATE registration_periods SET is_open = ? WHERE id = ?`, payload.IsOpen, c.Param("id"))
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	if count, _ := res.RowsAffected(); count == 0 {
		c.JSON(http.StatusNotFound, gin.H{"error": "registration period not found"})
		return
	}
	c.Status(http.StatusNoContent)
}

func (s *Server) listSchools(c *gin.Context) {
	var schools []models.School
	if err := s.db.Select(&schools, `SELECT id, nama_sekolah, jenjang, kecamatan_id, daya_tampung, created_at, updated_at FROM schools ORDER BY nama_sekolah`); err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	c.JSON(http.StatusOK, schools)
}

func (s *Server) createSchool(c *gin.Context) {
	var payload struct {
		NamaSekolah string `json:"nama_sekolah" binding:"required"`
		Jenjang     string `json:"jenjang" binding:"required"`
		KecamatanID string `json:"kecamatan_id" binding:"required"`
		DayaTampung int    `json:"daya_tampung"`
	}
	if err := c.ShouldBindJSON(&payload); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	id := uuid.NewString()
	_, err := s.db.Exec(`INSERT INTO schools (id, nama_sekolah, jenjang, kecamatan_id, daya_tampung) VALUES (?,?,?,?,?)`, id, payload.NamaSekolah, payload.Jenjang, payload.KecamatanID, payload.DayaTampung)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	c.JSON(http.StatusCreated, gin.H{"id": id})
}

func (s *Server) getSchool(c *gin.Context) {
	var school models.School
	if err := s.db.Get(&school, `SELECT id, nama_sekolah, jenjang, kecamatan_id, daya_tampung, created_at, updated_at FROM schools WHERE id = ?`, c.Param("id")); err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "school not found"})
		return
	}
	c.JSON(http.StatusOK, school)
}

func (s *Server) updateSchool(c *gin.Context) {
	var payload struct {
		NamaSekolah string `json:"nama_sekolah"`
		Jenjang     string `json:"jenjang"`
		KecamatanID string `json:"kecamatan_id"`
		DayaTampung int    `json:"daya_tampung"`
	}
	if err := c.ShouldBindJSON(&payload); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	res, err := s.db.Exec(`UPDATE schools SET nama_sekolah = COALESCE(NULLIF(?, ''), nama_sekolah), jenjang = COALESCE(NULLIF(?, ''), jenjang), kecamatan_id = COALESCE(NULLIF(?, ''), kecamatan_id), daya_tampung = CASE WHEN ? = 0 THEN daya_tampung ELSE ? END WHERE id = ?`, payload.NamaSekolah, payload.Jenjang, payload.KecamatanID, payload.DayaTampung, payload.DayaTampung, c.Param("id"))
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	if count, _ := res.RowsAffected(); count == 0 {
		c.JSON(http.StatusNotFound, gin.H{"error": "school not found"})
		return
	}
	c.Status(http.StatusNoContent)
}

func (s *Server) createStudent(c *gin.Context) {
	var payload struct {
		Nama         string `json:"nama" binding:"required"`
		NIK          string `json:"nik" binding:"required"`
		JenisKelamin string `json:"jenis_kelamin" binding:"required"`
		TanggalLahir string `json:"tanggal_lahir" binding:"required"`
	}
	if err := c.ShouldBindJSON(&payload); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}
	birthdate, err := time.Parse("2006-01-02", payload.TanggalLahir)
	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "invalid tanggal_lahir"})
		return
	}
	id := uuid.NewString()
	_, err = s.db.Exec(`INSERT INTO students (id, nama, nik, jenis_kelamin, tanggal_lahir) VALUES (?,?,?,?,?)`, id, payload.Nama, payload.NIK, payload.JenisKelamin, birthdate)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	c.JSON(http.StatusCreated, gin.H{"id": id})
}

func (s *Server) createRegistration(c *gin.Context) {
	var payload struct {
		StudentID            string `json:"student_id" binding:"required"`
		SchoolID             string `json:"school_id" binding:"required"`
		RegistrationPathID   int64  `json:"registration_path_id" binding:"required"`
		RegistrationPeriodID int64  `json:"registration_period_id" binding:"required"`
	}
	if err := c.ShouldBindJSON(&payload); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	var period models.RegistrationPeriod
	if err := s.db.Get(&period, `SELECT id, name, start_date, end_date, is_open FROM registration_periods WHERE id = ?`, payload.RegistrationPeriodID); err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": "registration period not found"})
		return
	}
	today := time.Now().Truncate(24 * time.Hour)
	if !period.IsOpen || today.Before(period.StartDate) || today.After(period.EndDate) {
		c.JSON(http.StatusBadRequest, gin.H{"error": "registration period is closed"})
		return
	}

	_, err := s.db.Exec(`INSERT INTO registrations (student_id, school_id, registration_path_id, registration_period_id, status, kelulusan) VALUES (?,?,?,?, 'pending', 'proses')`, payload.StudentID, payload.SchoolID, payload.RegistrationPathID, payload.RegistrationPeriodID)
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	c.Status(http.StatusCreated)
}

func (s *Server) getRegistration(c *gin.Context) {
	var detail models.RegistrationDetail
	query := `SELECT r.id, r.student_id, r.school_id, r.registration_path_id, r.registration_period_id, r.status, r.kelulusan, r.created_at,
        s.nama_sekolah AS school_name, st.nama AS student_name, rp.name AS registration_path, rp2.name AS period_name
        FROM registrations r
        JOIN schools s ON s.id = r.school_id
        JOIN students st ON st.id = r.student_id
        JOIN registration_paths rp ON rp.id = r.registration_path_id
        JOIN registration_periods rp2 ON rp2.id = r.registration_period_id
        WHERE r.id = ?`
	if err := s.db.Get(&detail, query, c.Param("id")); err != nil {
		c.JSON(http.StatusNotFound, gin.H{"error": "registration not found"})
		return
	}
	c.JSON(http.StatusOK, detail)
}
