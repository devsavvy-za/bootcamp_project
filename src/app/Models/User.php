<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // set
    protected $table = 'user';
    protected $fillable = ['user_role_id', 'first_name', 'last_name', 'mobile_number', 'email', 'password', 'status'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];


    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }



    /**
     * User role.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_role()
    {
        return $this->belongsTo(UserRole::class);
    }

    /**
     * Invoices.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     *  Get the JWT key.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     *  Get the JWT custom claims.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
