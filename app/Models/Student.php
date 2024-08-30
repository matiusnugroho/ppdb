<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string',
    ];

    protected $guarded = ['id'];

    public function getThumbnailUrlAttribute()
    {
        // Check if foto_url is set
        if (isset($this->attributes['foto_url']) && !empty($this->attributes['foto_url'])) {
            // Extract the directory and filename
            $pathInfo = pathinfo($this->attributes['foto_url']);

            // Build the thumbnail URL
            return $pathInfo['dirname'].'/thumbnail_'.$pathInfo['basename'];
        }

        // Return null or a default URL if foto_url is not set
        return null;
    }

    public function toArray()
    {
        $array = parent::toArray();
        // Add custom fields or modify existing fields
        $array['thumbnail_url'] = $this->thumbnail_url;

        return $array;
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

    public function school(): BelongsTo
    {
        return $this->schools()->wherePivot('active', true)->first();
    }

    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'school_student')
            ->withPivot('active')
            ->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
