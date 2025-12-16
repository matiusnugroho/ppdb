package main

import (
	"fmt"
	"log"
	"os"
	"path/filepath"
	"sort"

	"ppdb-go/internal/config"
	"ppdb-go/internal/database"
)

func main() {
	cfg, err := config.Load()
	if err != nil {
		log.Fatalf("failed to load config: %v", err)
	}

	db, err := database.Connect(cfg.DatabaseDSN)
	if err != nil {
		log.Fatalf("failed to connect database: %v", err)
	}
	defer db.Close()

	entries, err := os.ReadDir(cfg.MigrationDir)
	if err != nil {
		log.Fatalf("failed to read migrations: %v", err)
	}

	sort.Slice(entries, func(i, j int) bool { return entries[i].Name() < entries[j].Name() })

	for _, entry := range entries {
		if entry.IsDir() || filepath.Ext(entry.Name()) != ".sql" {
			continue
		}
		path := filepath.Join(cfg.MigrationDir, entry.Name())
		content, err := os.ReadFile(path)
		if err != nil {
			log.Fatalf("failed to read %s: %v", path, err)
		}
		fmt.Printf("Applying migration %s\n", entry.Name())
		if _, err := db.Exec(string(content)); err != nil {
			log.Fatalf("failed to apply %s: %v", entry.Name(), err)
		}
	}

	fmt.Println("Migrations applied successfully")
}
