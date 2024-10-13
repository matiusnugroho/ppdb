<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Storage;

class Document extends Model
{
    protected $fillable = [
        'id', 'registration_id', 'document_type_id', 'path', 'status',
    ];

    public $incrementing = false;

    protected $appends = ['url_path'];

    /**
     * Get the registration that owns the document.
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the document type that owns the document.
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Automatically generate UUID for new models
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function getUrlPathAttribute(): string
    {
        if(empty($this->path)) {
            return '';
        }
        return asset(Storage::url($this->path));
    }
}
