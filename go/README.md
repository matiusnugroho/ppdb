# PPDB Go Service

Port of the PPDB backend using Go, Gin, and SQLX with manual SQL migrations.

## Requirements
- Go 1.22+
- MySQL database

## Configuration
Copy `.env.example` to `.env` and adjust values:
```
DB_DSN=user:password@tcp(localhost:3306)/ppdb?parseTime=true
PORT=8080
MIGRATION_DIR=migrations
SHUTDOWN_TIMEOUT=5s
```

## Migrations
Migrations are plain SQL files in `migrations/`. Apply them with:
```
go run ./cmd/migrate
```

## Running the API
```
go run ./cmd/server
```

### Available endpoints
- `GET /health`
- `GET /registration-paths`
- `GET /registration-periods/open`
- `POST /registration-periods`
- `PATCH /registration-periods/:id/state`
- `GET /schools`
- `POST /schools`
- `GET /schools/:id`
- `PUT /schools/:id`
- `POST /students`
- `POST /registrations`
- `GET /registrations/:id`
