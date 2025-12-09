<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class School extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string',
    ];

    protected $guarded = ['id'];

    public $incrementing = false;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'school_student');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function activeRegistrations($periodId = null)
    {
        $query = $this->hasMany(Registration::class);
        if ($periodId) {
            return $query->where('registration_period_id', $periodId);
        }
        return $query->whereHas('registrationPeriod', function ($q) {
            $q->where('is_open', true);
        });
    }

    public function lulusRegistrations()
    {
        return $this->hasMany(Registration::class)->where('kelulusan', 'lulus');
    }

    public function tidakLulusRegistrations()
    {
        return $this->hasMany(Registration::class)->where('kelulusan', 'tidak lulus');
    }

    public function activeLulusRegistrations($periodId = null)
    {
        $query = $this->hasMany(Registration::class)->where('kelulusan', 'lulus');
        if ($periodId) {
            return $query->where('registration_period_id', $periodId);
        }
        return $query->whereHas('registrationPeriod', function ($q) {
            $q->where('is_open', true);
        });
    }

    public function activeTidakLulusRegistrations($periodId = null)
    {
        $query = $this->hasMany(Registration::class)->where('kelulusan', 'tidak lulus');
        if ($periodId) {
            return $query->where('registration_period_id', $periodId);
        }
        return $query->whereHas('registrationPeriod', function ($q) {
            $q->where('is_open', true);
        });
    }

    public function activeStatusRegistrations($status, $periodId = null)
    {
        $query = $this->hasMany(Registration::class)->where('status', $status);
        if ($periodId) {
            return $query->where('registration_period_id', $periodId);
        }
        return $query->whereHas('registrationPeriod', function ($q) {
            $q->where('is_open', true);
        });
    }

    public function activeCountByJalur($jalur, $periodId = null)
    {
        $query = $this->hasMany(Registration::class)->where('registration_path_id', $jalur);
        if ($periodId) {
            return $query->where('registration_period_id', $periodId)->count();
        }
        return $query->whereHas('registrationPeriod', function ($q) {
            $q->where('is_open', true);
        })->count();
    }
}
