<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistrationPath extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quota_percentage',
        'is_active',
        'additional_settings',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'quota_percentage' => 'integer',
        'additional_settings' => 'array',
        'display_order' => 'integer',
    ];

    /**
     * Get all requirements for this registration path
     */
    public function requirements(): HasMany
    {
        return $this->hasMany(PathRequirement::class);
    }
    
}