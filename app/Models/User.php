<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the school that the user manages.
     */
    public function school(): HasOne
    {
        return $this->hasOne(School::class);
    }

    /**
     * Get the student associated with the user.
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function can($abilities, $arguments = [])
    {
        // If user is a super_admin, bypass permission checks
        if ($this->hasRole('super_admin')) {
            return true;
        }

        return parent::can($abilities, 'web', $arguments);
    }

    public function getRoleAttribute()
    {
        $roles = $this->roles()->get();

        if ($roles->count() === 1) {
            return $roles->first()->name;
        }

        // Return the latest role based on created_at
        return $roles->sortByDesc('created_at')->first()->name;
    }
}
