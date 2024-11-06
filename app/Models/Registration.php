<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Str;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'student_id', 'school_id', 'registration_number', 'registration_period_id', 'jenjang', 'status', 'kelulusan', 'registration_path_id', 'verified_by', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public $incrementing = false;

    /**
     * Get the student that owns the registration.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
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

    /**
     * Get the school that owns the registration.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the documents associated with the registration.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function registrationPeriod(): BelongsTo
    {
        return $this->belongsTo(RegistrationPeriod::class);
    }

    public function registrationPath(): BelongsTo
    {
        return $this->belongsTo(RegistrationPath::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
