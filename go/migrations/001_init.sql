CREATE TABLE IF NOT EXISTS registration_paths (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    UNIQUE KEY unique_registration_path_name (name)
);

CREATE TABLE IF NOT EXISTS registration_periods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_open BOOLEAN DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS schools (
    id CHAR(36) PRIMARY KEY,
    nama_sekolah VARCHAR(255) NOT NULL,
    jenjang VARCHAR(50) NOT NULL,
    kecamatan_id VARCHAR(50) NOT NULL,
    daya_tampung INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS students (
    id CHAR(36) PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    nik VARCHAR(32) NOT NULL UNIQUE,
    jenis_kelamin VARCHAR(20) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS registrations (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    student_id CHAR(36) NOT NULL,
    school_id CHAR(36) NOT NULL,
    registration_path_id INT NOT NULL,
    registration_period_id INT NOT NULL,
    status VARCHAR(32) NOT NULL DEFAULT 'pending',
    kelulusan VARCHAR(32) NOT NULL DEFAULT 'proses',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_registration_student FOREIGN KEY (student_id) REFERENCES students(id),
    CONSTRAINT fk_registration_school FOREIGN KEY (school_id) REFERENCES schools(id),
    CONSTRAINT fk_registration_path FOREIGN KEY (registration_path_id) REFERENCES registration_paths(id),
    CONSTRAINT fk_registration_period FOREIGN KEY (registration_period_id) REFERENCES registration_periods(id)
);

INSERT INTO registration_paths (name, description)
VALUES
    ('Zonasi', 'Pendaftaran berbasis zonasi'),
    ('Afirmasi', 'Pendaftaran berbasis afirmasi'),
    ('Perpindahan', 'Pendaftaran karena perpindahan orang tua')
ON DUPLICATE KEY UPDATE description = VALUES(description);

INSERT INTO registration_periods (name, start_date, end_date, is_open)
VALUES
    ('Gelombang 1', CURRENT_DATE, DATE_ADD(CURRENT_DATE, INTERVAL 14 DAY), TRUE)
ON DUPLICATE KEY UPDATE end_date = VALUES(end_date), is_open = VALUES(is_open);
