<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    // set
    protected $table = 'user';
    protected $fillable = ['user_role_id', 'first_name', 'last_name', 'mobile_number', 'email', 'password', 'status'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];


    /**
     * User role.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_role()
    {
        return $this->belongsTo(UserRole::class);
    }

    /**
     * Orders.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
