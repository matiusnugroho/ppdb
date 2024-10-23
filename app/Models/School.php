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
    public function activeRegistrations()
    {
        return $this->hasMany(Registration::class)->whereHas('registrationPeriod', function ($query) {
            $query->where('is_open', true);
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
    public function activeLulusRegistrations()
    {
        return $this->hasMany(Registration::class)
            ->where('kelulusan', 'lulus')
            ->whereHas('registrationPeriod', function ($query) {
                $query->where('is_open', true);
            });
    }
    public function activeTidakLulusRegistrations()
    {
        return $this->hasMany(Registration::class)
            ->where('kelulusan', 'tidak lulus')
            ->whereHas('registrationPeriod', function ($query) {
                $query->where('is_open', true);
            });
    }
    public function activeStatusRegistrations($status)
    {
        return $this->hasMany(Registration::class)
            ->where('status', $status)
            ->whereHas('registrationPeriod', function ($query) {
                $query->where('is_open', true);
            });
    }
}
