<?php

namespace App;

use App\Traits\uuidPrimary;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, uuidPrimary;

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'user_id';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'otp_code_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsTo("App\Roles", "role_id", 'role_id');
    }

    public function otp_codes()
    {
        return $this->belongsTo("App\Otp_codes", "otp_code_id", "otp_code_id");
    }
}
