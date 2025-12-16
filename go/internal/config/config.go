package config

import (
	"fmt"
	"os"
	"time"

	"github.com/joho/godotenv"
)

// Config holds application configuration loaded from environment variables.
type Config struct {
	Port            string
	DatabaseDSN     string
	MigrationDir    string
	ShutdownTimeout time.Duration
}

// Load reads configuration from environment variables and optional .env file.
func Load() (*Config, error) {
	_ = godotenv.Load()

	port := getenv("PORT", "8080")
	dsn := os.Getenv("DB_DSN")
	if dsn == "" {
		return nil, fmt.Errorf("DB_DSN is required")
	}

	migrationDir := getenv("MIGRATION_DIR", "migrations")
	timeoutStr := getenv("SHUTDOWN_TIMEOUT", "5s")
	timeout, err := time.ParseDuration(timeoutStr)
	if err != nil {
		return nil, fmt.Errorf("invalid SHUTDOWN_TIMEOUT: %w", err)
	}

	return &Config{
		Port:            port,
		DatabaseDSN:     dsn,
		MigrationDir:    migrationDir,
		ShutdownTimeout: timeout,
	}, nil
}

func getenv(key, fallback string) string {
	if value := os.Getenv(key); value != "" {
		return value
	}
	return fallback
}
