<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PathRequirement extends Model
{
    protected $fillable = [
        'registration_path_id',
        'document_type_id',
        'is_required',
        'allowed_file_types',
        'max_file_size',
        'display_order',
        'validation_rules',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'max_file_size' => 'integer',
        'display_order' => 'integer',
        'validation_rules' => 'array',
    ];

    /**
     * Get the registration path that owns this requirement
     */
    public function registrationPath(): BelongsTo
    {
        return $this->belongsTo(RegistrationPath::class);
    }

    /**
     * Get the document type for this requirement
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    /**
     * Get the array of allowed file extensions
     */
    public function getAllowedExtensions(): array
    {
        return $this->allowed_file_types ? 
            explode(',', $this->allowed_file_types) : 
            [];
    }

    /**
     * Check if a given file extension is allowed
     */
    public function isExtensionAllowed(string $extension): bool
    {
        return in_array(
            strtolower($extension),
            array_map('strtolower', $this->getAllowedExtensions())
        );
    }

    /**
     * Get max file size in bytes
     */
    public function getMaxFileSizeInBytes(): int
    {
        return $this->max_file_size * 1024; // Convert KB to bytes
    }

    /**
     * Validate a file against this requirement's rules
     */
    public function validateFile($file): array
    {
        $errors = [];

        // Check file size
        if ($file->getSize() > $this->getMaxFileSizeInBytes()) {
            $errors[] = "File size exceeds maximum allowed size of {$this->max_file_size}KB";
        }

        // Check file extension
        $extension = $file->getClientOriginalExtension();
        if (!$this->isExtensionAllowed($extension)) {
            $errors[] = "File type .$extension is not allowed. Allowed types: " . $this->allowed_file_types;
        }

        return $errors;
    }
}